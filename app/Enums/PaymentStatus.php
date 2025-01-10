<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case PARTIALLY_PAID = 'partially_paid';
    case REFUNDED = 'refunded';
    case FAILED = 'failed';


    public static function all(): array
    {
        return [
            self::PENDING->value,
            self::PAID->value,
            self::PARTIALLY_PAID->value,
            self::REFUNDED->value,
            self::FAILED->value,
        ];
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::PENDING => 'bg-warning',
            self::FAILED => 'bg-danger',
            self::PAID => 'bg-success',
            self::PARTIALLY_PAID => 'bg-info',
            self::REFUNDED => 'bg-success',
        };
    }

    public static function getBadgeHtml(string $statusValue): string
    {
        if (!self::tryFrom($statusValue)) {
            return '<span class="badge badge-secondary">'.__('frontend.unknown_status').'</span>';
        }

        $status = self::from($statusValue);

        return sprintf(
            '<span class="badge %s">%s</span>',
            $status->badgeClass(),
            ucfirst(str_replace('_', ' ', $status->value))
        );
    }
}
