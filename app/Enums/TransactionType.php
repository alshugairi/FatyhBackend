<?php

namespace App\Enums;

enum TransactionType: string
{
    case PURCHASE_PAYMENT = 'purchase_payment';
    case ORDER_PAYMENT = 'order_payment';
    case ORDER_REFUND = 'order_refund';
    case EXPENSE = 'expense';
    case CAPITAL = 'capital';
    case OPENING_BALANCE = 'opening_balance';
    case DEPOSIT = 'deposit';
    case WITHDRAWAL = 'withdrawal';
    case TRANSFER = 'transfer';
    case ADJUSTMENT_ADD = 'adjustment_add';
    case ADJUSTMENT_SUBTRACT = 'adjustment_subtract';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function getType(self $type): string
    {
        return match($type) {
            self::OPENING_BALANCE,
            self::CAPITAL,
            self::ORDER_PAYMENT,
            self::DEPOSIT,
            self::ADJUSTMENT_ADD => 'debit',    // Increases balance

            self::PURCHASE_PAYMENT,
            self::ORDER_REFUND,
            self::EXPENSE,
            self::WITHDRAWAL,
            self::ADJUSTMENT_SUBTRACT => 'credit',  // Decreases balance

            self::TRANSFER => 'both'
        };
    }

    public function label(): string
    {
        return match($this) {
            self::PURCHASE_PAYMENT => __('admin.purchase_payment'),
            self::ORDER_PAYMENT => __('admin.order_payment'),
            self::ORDER_REFUND => __('admin.order_refund'),
            self::EXPENSE => __('admin.expense'),
            self::CAPITAL => __('admin.capital'),
            self::OPENING_BALANCE => __('admin.opening_balance'),
            self::DEPOSIT => __('admin.deposit'),
            self::WITHDRAWAL => __('admin.withdrawal'),
            self::TRANSFER => __('admin.transfer'),
            self::ADJUSTMENT_ADD => __('admin.adjustment_add'),
            self::ADJUSTMENT_SUBTRACT => __('admin.adjustment_subtract'),
        };
    }
}
