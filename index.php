<?php declare(strict_types = 1);

require_once './vendor/autoload.php';

use App\Shared\Http\Middleware\CorsMiddleware;
use Slim\Factory\AppFactory;
use DI\Container;
use App\Shared\Http\Middleware\ExceptionMiddleware;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpNotFoundException;

$container = new Container();

require_once './bootstrap/dependencies.php';

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->addBodyParsingMiddleware();
$app->addMiddleware(new CorsMiddleware());
$app->addMiddleware(new ExceptionMiddleware($container->get(LoggerInterface::class)));
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

require_once './routes/api/v1.php';

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
    throw new HttpNotFoundException($request);
});

$app->run();
