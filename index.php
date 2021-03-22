<?php declare(strict_types = 1);

require_once './vendor/autoload.php';

use Slim\Factory\AppFactory;
use DI\Container;
use App\Shared\Http\Middleware\ExceptionMiddleware;
use Psr\Log\LoggerInterface;

$container = new Container();

require_once './bootstrap/dependencies.php';

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->addBodyParsingMiddleware();
$app->addMiddleware(new ExceptionMiddleware($container->get(LoggerInterface::class)));
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
            ->withHeader('Access-Control-Allow-Origin', 'https://ledsystem-landpage.herokuapp.com')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

require_once './routes/api/v1.php';

$app->run();
