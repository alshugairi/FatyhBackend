<?php

namespace App\Enums;

enum PlatformType: string
{
    case Web = 'web';
    case Android = 'android';
    case Ios = 'ios';
    case Pos = 'pos';
    case Tablet = 'tablet';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::Web => 'web',
            self::Android => 'android',
            self::Ios => 'ios',
            self::Pos => 'pos',
            self::Tablet => 'tablet',
        };
    }

}
