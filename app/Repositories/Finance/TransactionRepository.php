<?php

namespace App\Repositories\Finance;

use App\{Models\Transaction, Repositories\BaseRepository};

class TransactionRepository extends BaseRepository
{
    public function __construct(Transaction $model)
    {
        parent::__construct($model);
    }
}
