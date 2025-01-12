<?php

namespace App\Services;

use App\{Enums\UserType, Models\User};
use JsonException;
use MElaraby\VictoryLink\VictoryLink;
use Random\RandomException;

class VerificationService
{

    public function sendCode(User $user, int|string $code): void
    {
    }

    public function storeCode(User $user, int $code): void
    {
        $user->forceFill(attributes: [
            'verification_code' => $code,
            'verification_expires_at' => now()->addHour()
        ])->save();
    }

    public function verifyUser(User $user): void
    {
        $attributes = [
            'verified' => true,
            'verification_code' => null,
        ];

        if ($user->email_verified_at === null) {
            $attributes['email_verified_at'] = now();
        }

        $user->forceFill(attributes: $attributes)->save();
    }

    public function isCodeCorrect(User $user, $code): bool
    {
        return $user->verification_code === $code;
    }

    /**
     * @return int
     * @throws RandomException
     */
    public function generateCode(): int
    {
        return random_int(min: 1000, max: 9999);
    }
}
