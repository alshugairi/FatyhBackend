<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'type' => $this->type,
            'value' => $this->value,
            'start_date' => $this->start_date->format('Y-m-d'),
            'end_date' => $this->end_date->format('Y-m-d'),
            'remaining_days' => $this->calculateRemainingDays(),
        ];
    }

    private function calculateRemainingDays()
    {
        $endDate = Carbon::parse($this->end_date);
        $today = Carbon::today();

        if ($endDate->lt($today)) {
            return 0;
        }

        return $today->diffInDays($endDate);
    }
}
