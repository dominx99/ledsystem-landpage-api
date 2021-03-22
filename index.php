<?php declare(strict_types = 1);

require_once './vendor/autoload.php';

use App\Shared\Http\Middleware\CorsMiddleware;
use Slim\Factory\AppFactory;
use DI\Container;
use App\Shared\Http\Middleware\ExceptionMiddleware;
use Psr\Log\LoggerInterface;

$container = new Container();

require_once './bootstrap/dependencies.php';

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->addMiddleware(new ExceptionMiddleware($container->get(LoggerInterface::class)));
$app->addMiddleware(new CorsMiddleware());
$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();
$app->addErrorMiddleware(true, false, false);

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

require_once './routes/api/v1.php';

$app->run();
