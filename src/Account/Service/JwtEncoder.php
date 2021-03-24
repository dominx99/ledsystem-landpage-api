<?php declare(strict_types=1);

namespace App\Account\Service;

use App\Account\Domain\Resource\User;
use Firebase\JWT\JWT;

final class JwtEncoder extends JWT
{
    public static function fromUser(User $user): string
    {
        return static::encode([
            'id' => $user->getId(),
        ], env('JWT_KEY'));
    }
}
