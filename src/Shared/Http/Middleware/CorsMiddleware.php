<?php declare(strict_types=1);

namespace App\Shared\Http\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Slim\Routing\RouteContext;

final class CorsMiddleware implements MiddlewareInterface
{
    public function __construct (
        private LoggerInterface $logger,
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $routeContext = RouteContext::fromRequest($request);
        $routingResults = $routeContext->getRoutingResults();
        $methods = $routingResults->getAllowedMethods();
        $requestHeaders = $request->getHeaderLine('Access-Control-Request-Headers');

        $origin = $request->getHeader('Origin');

        if (is_array($origin) && count($origin) > 0) {
            $origin = $origin[0];
        }

        if (! $origin) {
            $origin = env('FRONT_BASE_URL');
        }

        $allowedOrigins = explode(',', env('ALLOWED_ORIGINS'));

        $response = $handler->handle($request);

        if (in_array($origin, $allowedOrigins)) {
            $response = $response->withHeader('Access-Control-Allow-Origin', $origin);
        } else {
            $response = $response->withHeader('Access-Control-Allow-Origin', env('FRONT_BASE_URL'));
        }

        $response = $response->withHeader('Access-Control-Allow-Methods', implode(',', $methods));
        $response = $response->withHeader('Access-Control-Allow-Headers', $requestHeaders);
        $response = $response->withHeader('Access-Control-Allow-Credentials', 'true');

        return $response;
    }
}
