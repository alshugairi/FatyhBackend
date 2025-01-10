<?php

namespace App\Services\Finance;

use App\{Enums\TransactionType, Repositories\Finance\TransactionRepository, Services\BaseService};
use Illuminate\{Database\Eloquent\Model, Http\JsonResponse, Pipeline\Pipeline, Support\Facades\DB};
use Yajra\DataTables\DataTables;

class TransactionService extends BaseService
{
    public function __construct(TransactionRepository $repository)
    {
        parent::__construct($repository);
    }

    public function list(array $filters = [], array $relations = [], array $withCount = []): JsonResponse
    {
        $query = $this->repository->getModel()->with($relations);

        return DataTables::of(app(Pipeline::class)->send($query)->through($filters)->thenReturn())
            ->editColumn('reference_type', function ($item){ return $item->reference_type->label(); })
            ->editColumn('payment_method', function ($item){ return __('admin.'.$item->payment_method); })
            ->toJson();
    }

    public function create(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            $lastTransaction = $this->repository->getModel()->latest('id')->first();
            $currentBalance = $lastTransaction ? $lastTransaction->balance : 0;

            $data['creator_id'] = auth()->id();

            $referenceType = TransactionType::from($data['reference_type']);
            $type = TransactionType::getType($referenceType);

            if ($type === 'both') {
                $fromTransaction = $this->repository->create(
                    array_merge($data,[
                        'type' => 'credit',
                        'reference_id' => $data['from_account_id'],
                        'balance' => $currentBalance - $data['amount'],
                        'number' => $this->generateNumber(),
                        'notes' => 'Transfer to account #' . $data['to_account_id'],
                    ])
                );

                return $this->repository->create(
                    array_merge($data,[
                        'type' => 'debit',
                        'reference_id' => $data['to_account_id'],
                        'balance' => $currentBalance + $data['amount'],
                        'number' => $this->generateNumber(),
                        'notes' => 'Transfer from account #' . $data['from_account_id'],
                    ])
                );
            }

            $newBalance = $type === 'debit' ?
                $currentBalance + $data['amount'] :
                $currentBalance - $data['amount'];

            $data['type'] = $type;
            $data['number'] = $this->generateNumber();
            $data['balance'] = $newBalance;

            return $this->repository->create($data);
        });
    }

    private function generateNumber(): string
    {
        $prefix = 'TRX';
        $date = now()->format('Ymd');
        $lastNumber = $this->repository
            ->getModel()
            ->whereDate('created_at', today())
            ->latest()
            ->first()?->number;

        $sequence = $lastNumber
            ? (int)substr($lastNumber, -4) + 1 :
            1;

        return sprintf('%s-%s-%04d', $prefix, $date, $sequence);
    }
}
