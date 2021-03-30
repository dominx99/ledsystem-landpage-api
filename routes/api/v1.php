<?php declare(strict_types = 1);

use App\Account\Http\Actions\LoginAction;
use App\Account\Http\Middleware\AuthorizationTokenMiddleware;
use App\Media\Http\Controller\MediaController;
use App\Realization\Http\Controllers\RealizationController;
use Slim\Interfaces\RouteCollectorProxyInterface;
use App\Realization\Http\Controllers\RealizationImageController;
use App\Realization\Http\Controllers\SetRealizationMainImageAction;
use App\Media\Http\Action\UpdateMediaOrderAction;

$app->group('/api/v1', function (RouteCollectorProxyInterface $group) {
    $group->post('/auth/login', LoginAction::class);

    $group->get('/realizations', RealizationController::class . ':index');
    $group->get('/realizations/{slug}', RealizationController::class . ':show');

    $group->group('', function (RouteCollectorProxyInterface $group) {
        $group->post('/realizations', RealizationController::class . ':store');
        $group->post('/realizations/edit', RealizationController::class . ':update');
        $group->get('/realizations/{realizationId}/images', RealizationImageController::class . ':index');
        $group->get('/realizations/{realizationId}/main-image', RealizationImageController::class . ':mainImage');
        $group->post('/realizations/{realizationId}/remove', RealizationController::class . ':remove');
        $group->post('/realizations/{realizationId}/set-main-image', SetRealizationMainImageAction::class);
        $group->post('/medias/{mediaId}/remove', MediaController::class . ':remove');
        $group->post('/medias/update-order', UpdateMediaOrderAction::class);
    })->addMiddleware(new AuthorizationTokenMiddleware());
});
