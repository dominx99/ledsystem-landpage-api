<?php

declare(strict_types = 1);

namespace App\Account\ValueObject;

use App\Shared\Domain\Exception\BusinessException;

final class DecodedToken
{
    private string $id;

    public function __construct(array $data)
    {
        if (empty($data["id"])) {
            throw new BusinessException("Invalid token data");
        }

        $this->id = $data["id"];
    }

    public function id(): string
    {
        return $this->id;
    }
}
