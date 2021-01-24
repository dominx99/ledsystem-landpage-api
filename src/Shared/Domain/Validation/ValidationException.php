<?php declare(strict_types=1);

namespace App\Shared\Domain\Validation;

final class ValidationException extends \Exception
{
    private array $messages;

    private function __construct(array $messages)
    {
        $this->messages = $messages;
    }

    public static function withMessages(array $messages): self
    {
        return new static($messages);
    }

    public function messages(): array
    {
        return $this->messages;
    }
}
