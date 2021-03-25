<?php declare(strict_types=1);

namespace App\Shared\Domain\Exception;

use Throwable;

final class UnexpectedException extends \Exception
{
    public function __construct (
        private Throwable $exception
    ) {}

    public function getParentException(): Throwable
    {
        return $this->exception;
    }
}
