<?php

declare(strict_types = 1);

namespace App\Realization\Domain\Exception;

use App\Shared\Domain\Exception\BusinessException;

final class RealizationNotFoundException extends BusinessException
{
    protected $message = "Realization not found.";
}
