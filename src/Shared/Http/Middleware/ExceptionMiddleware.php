<?php declare(strict_types=1);

namespace App\Shared\Http\Middleware;

use App\Account\Domain\Exception\AuthorizationException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Response;
use App\Shared\Domain\Exception\BusinessException;
use App\Shared\Domain\Validation\ValidationException;
use App\Shared\Http\Responses\JsonResponse;
use \Throwable;
use Slim\Routing\RouteContext;

final class ExceptionMiddleware implements MiddlewareInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Server\RequestHandlerInterface $handler
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = new Response();
        $response = $response->withHeader('Content-Type', 'application/json');

        $routeContext = RouteContext::fromRequest($request);
        $routingResults = $routeContext->getRoutingResults();
        $methods = $routingResults->getAllowedMethods();
        $requestHeaders = $request->getHeaderLine('Access-Control-Request-Headers');

        $response = $response->withHeader('Access-Control-Allow-Origin', env('FRONT_BASE_URL'));
        $response = $response->withHeader('Access-Control-Allow-Methods', implode(',', $methods));
        $response = $response->withHeader('Access-Control-Allow-Headers', $requestHeaders);
        $response = $response->withHeader('Access-Control-Allow-Credentials', 'true');

        try {
            $response = $handler->handle($request);
        } catch (BusinessException $e) {
            $response->getBody()->write(json_encode(["error" => $e->getMessage()]));
            $response = $response->withStatus(
                $e->getCode() ? $e->getCode() : StatusCodeInterface::STATUS_BAD_REQUEST
            );
        } catch (AuthorizationException $e) {
            $response = JsonResponse::create([
                'error' => $e->getMessage()
            ], $e->getCode());
        } catch (ValidationException $e) {
            $response->getBody()->write(json_encode(["errors" => $e->messages()]));
            $response = $response->withStatus(
                $e->getCode() ? $e->getCode() : StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY
            );
        } catch (Throwable $t) {
            $this->logException($t);

            throw $t;
        }

        return $response;
    }

    private function logException(Throwable $t): void
    {
        $this->logger->error(
            sprintf(
                (
                    "\n File: %s" .
                    "\n Line: %s" .
                    "\n Message: %s" .
                    "\n Trace: \n %s"
                ),
                $t->getFile(),
                $t->getLine(),
                $t->getMessage(),
                $t->getTraceAsString(),
            ),
        );
    }
}
