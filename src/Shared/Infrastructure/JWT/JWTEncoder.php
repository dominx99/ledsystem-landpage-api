<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\JWT;

use App\Account\Domain\Resource\User;
use Firebase\JWT\JWT;

final class JWTEncoder extends JWT
{
    public static function fromUser(User $user): string
    {
        return static::encode([
            'id' => $user->getId(),
        ], getenv('JWT_KEY'));
    }
}
