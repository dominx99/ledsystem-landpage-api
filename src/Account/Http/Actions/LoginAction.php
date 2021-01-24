<?php declare(strict_types=1);

namespace App\Account\Http\Actions;

use App\Account\Domain\Exception\AuthorizationException;
use App\Shared\Domain\Validation\Validator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator as v;
use App\Account\Domain\Exception\UserNotFoundException;
use App\Account\Domain\Repository\UserRepository;
use App\Shared\Domain\Validation\ValidationException;
use App\Shared\Http\Responses\JsonResponse;
use App\Shared\Infrastructure\JWT\JWTEncoder;

final class LoginAction
{
    private Validator $validator;
    private UserRepository $userRepository;

    public function __construct(
        Validator $validator,
        UserRepository $userRepository,
    ) {
        $this->validator = $validator;
        $this->userRepository = $userRepository;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $params = $request->getParsedBody() ?? [];

        try {
            $this->validator->validate($params, [
                'email'    => v::notEmpty(),
                'password' => v::notEmpty(),
            ]);
        } catch (ValidationException) {
            throw new AuthorizationException();
        }

        try {
            $user = $this->userRepository->findOneByEmail($params['email']);
        } catch (UserNotFoundException) {
            throw new AuthorizationException();
        }

        if (! password_verify($params['password'], $user->getPassword())) {
            throw new AuthorizationException();
        }

        $accessToken = (string) JWTEncoder::fromUser($user);

        $user->setAccessToken($accessToken);
        $this->userRepository->update($user);

        return JsonResponse::create([
            'accessToken' => $accessToken,
        ]);
    }
}
