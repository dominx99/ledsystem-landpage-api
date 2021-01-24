<?php declare(strict_types=1);

namespace App\Shared\Domain\Validation;

interface Validator
{
    /** @throws \App\Shared\Domain\Validation\ValidationException */
    public function validate(array $params, array $rules): void;
}
