<?php

declare(strict_types = 1);

namespace App\Account\Http\Middleware;

use App\Account\Service\JwtDecoder;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use App\Shared\Domain\Exception\BusinessException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\BeforeValidException;

final class AuthorizationTokenMiddleware implements MiddlewareInterface
{
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface
    {
        if (empty($request->getHeader('Authorization'))) {
            throw new BusinessException("Token is required");
        }

        try {
            $decodedToken = JwtDecoder::fromBearer($request->getHeader('Authorization')[0]);

            $request = $request->withAttribute('decodedToken', $decodedToken);
        } catch (SignatureInvalidException | ExpiredException | BeforeValidException $e) {
            throw new BusinessException($e->getMessage());
        }

        $response = $handler->handle($request);

        return $response;
    }
}
