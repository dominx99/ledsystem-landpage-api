<?php declare(strict_types=1);

namespace App\Account\Domain\Exception;

use Fig\Http\Message\StatusCodeInterface;

final class AuthorizationException extends \Exception
{
    protected $message = 'Wrong email or password.';
    protected $code = StatusCodeInterface::STATUS_UNAUTHORIZED;
}
