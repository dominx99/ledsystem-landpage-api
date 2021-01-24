<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Validation;

use Respect\Validation\Exceptions\NestedValidationException;
use App\Shared\Domain\Validation\Validator;
use App\Shared\Domain\Validation\ValidationException;

final class RespectValidator implements Validator
{
    public function validate(array $params, array $rules): void
    {
        $errors = [];

        foreach ($rules as $field => $rule) {
            try {
                $rule
                    ->setName(ucfirst($field))
                    ->assert($params[$field] ?? null);
            } catch (NestedValidationException $e) {
                $errors[$field] = $e->getMessages();
            }
        }

        if (count($errors) > 0) {
            throw ValidationException::withMessages($errors);
        }
    }
}
