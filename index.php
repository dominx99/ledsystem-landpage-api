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

require_once './routes/api/v1.php';

$app->run();
