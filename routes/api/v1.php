<?php declare(strict_types = 1);

use App\Account\Http\Actions\LoginAction;
use App\Account\Http\Middleware\AuthorizationTokenMiddleware;
use App\Realization\Http\Controllers\RealizationController;
use Slim\Interfaces\RouteCollectorProxyInterface;

$app->group('/api/v1', function (RouteCollectorProxyInterface $group) {
    $group->post('/auth/login', LoginAction::class);

    $group->get('/realizations', RealizationController::class . ':index');
    $group->get('/realizations/{slug}', RealizationController::class . ':show');

    $group->group('', function (RouteCollectorProxyInterface $group) {
        $group->post('/realizations', RealizationController::class . ':store');
        $group->post('/realizations/edit', RealizationController::class . ':update');
    })->addMiddleware(new AuthorizationTokenMiddleware());
});
