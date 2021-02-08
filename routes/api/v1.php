<?php declare(strict_types = 1);

use App\Account\Http\Actions\LoginAction;
use App\Account\Http\Middleware\AuthorizationTokenMiddleware;
use App\Realization\Http\Controllers\RealizationController;
use Slim\Interfaces\RouteCollectorProxyInterface;

$app->group('/api/v1', function (RouteCollectorProxyInterface $group) {
    $group->post('/auth/login', LoginAction::class);

    $group->group('', function (RouteCollectorProxyInterface $group) {
        $group->post('/realizations', RealizationController::class . ':store');
    })->addMiddleware(new AuthorizationTokenMiddleware());
});
