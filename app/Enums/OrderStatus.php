<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING_PAYMENT = 'pending_payment';
    case PAYMENT_FAILED = 'payment_failed';
    case PAYMENT_CONFIRMED = 'payment_confirmed';

    case CONFIRMED = 'confirmed';
    case IN_PREPARATION = 'in_preparation';
    case AWAITING_PICKUP = 'awaiting_pickup';

    case SHIPPED = 'shipped';
    case IN_TRANSIT = 'in_transit';
    case OUT_FOR_DELIVERY = 'out_for_delivery';
    case DELIVERED = 'delivered';

    case CANCELED = 'canceled';
    case RETURN_REQUESTED = 'return_requested';
    case RETURNED = 'returned';
    case REFUND_REQUESTED = 'refund_requested';
    case REFUNDED = 'refunded';

    case REJECTED = 'rejected';
    case LOST_IN_TRANSIT = 'lost_in_transit';

    public static function all(): array
    {
        return [
            self::PENDING_PAYMENT->value,
            self::PAYMENT_FAILED->value,
            self::PAYMENT_CONFIRMED->value,
            self::CONFIRMED->value,
            self::IN_PREPARATION->value,
            self::AWAITING_PICKUP->value,
            self::SHIPPED->value,
            self::IN_TRANSIT->value,
            self::OUT_FOR_DELIVERY->value,
            self::DELIVERED->value,
            self::CANCELED->value,
            self::RETURN_REQUESTED->value,
            self::RETURNED->value,
            self::REFUND_REQUESTED->value,
            self::REFUNDED->value,
            self::REJECTED->value,
            self::LOST_IN_TRANSIT->value,
        ];
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::PENDING_PAYMENT => 'bg-warning',
            self::PAYMENT_FAILED => 'bg-danger',
            self::PAYMENT_CONFIRMED => 'bg-success',
            self::CONFIRMED => 'bg-primary',
            self::IN_PREPARATION => 'bg-info',
            self::AWAITING_PICKUP => 'bg-secondary',
            self::SHIPPED => 'bg-secondary',
            self::IN_TRANSIT => 'bg-secondary',
            self::OUT_FOR_DELIVERY => 'bg-info',
            self::DELIVERED => 'bg-success',
            self::CANCELED => 'bg-dark',
            self::RETURN_REQUESTED => 'bg-warning',
            self::RETURNED => 'bg-warning',
            self::REFUND_REQUESTED => 'bg-info',
            self::REFUNDED => 'bg-success',
            self::REJECTED => 'bg-danger',
            self::LOST_IN_TRANSIT => 'bg-danger',
        };
    }

    public static function getBadgeHtml(self $status): string
    {
        $statusValue = $status->value;
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
