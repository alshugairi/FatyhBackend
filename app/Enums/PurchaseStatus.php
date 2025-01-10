<?php

namespace App\Enums;

enum PurchaseStatus: string
{
    case PENDING = 'pending';
    case ORDERED = 'ordered';
    case RECEIVED = 'received';
    case CANCELLED = 'cancelled';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::PENDING => __('admin.pending'),
            self::ORDERED => __('admin.ordered'),
            self::RECEIVED => __('admin.received'),
            self::CANCELLED => __('admin.cancelled'),
        };
    }

    public static function keyValue(): array
    {
        return [
            self::PENDING->value => __('admin.pending'),
            self::ORDERED->value => __('admin.ordered'),
            self::RECEIVED->value => __('admin.received'),
            self::CANCELLED->value => __('admin.cancelled'),
        ];
    }
}
