<?php declare(strict_types=1);

namespace App\Account\Domain\Exception;

final class UserNotFoundException extends \Exception
{
    protected $message = "User not found.";
}
