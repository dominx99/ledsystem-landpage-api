<?php declare(strict_types=1);

namespace App\Account\Service;

use Firebase\JWT\JWT;
use App\Shared\Domain\Exception\BusinessException;
use App\Account\ValueObject\DecodedToken;

final class JwtDecoder extends JWT
{
    public static function fromBearer(string $token): DecodedToken
    {
        if (! $token = substr($token, 7)) {
            throw new BusinessException("Not valid token");
        }

        return new DecodedToken(
            (array) static::decode($token, getenv("JWT_KEY"), ["HS256"])
        );
    }
}
