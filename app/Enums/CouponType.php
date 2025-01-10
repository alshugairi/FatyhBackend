<?php

namespace App\Enums;

enum CouponType:string
{
    case PERCENTAGE = 'percentage';
    case FIXED_AMOUNT = 'fixed_amount';

    /**
     * @return array
     */
    public static function asString(): array
    {
        return [
            self::PERCENTAGE->value => __('admin.percentage'),
            self::FIXED_AMOUNT->value => __('admin.fixed_amount'),
        ];
    }
}
