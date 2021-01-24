<?php declare(strict_types = 1);

use App\Account\Http\Actions\LoginAction;
use Slim\Interfaces\RouteCollectorProxyInterface;

$app->group('/api/v1', function (RouteCollectorProxyInterface $group) {
    $group->post('/auth/login', LoginAction::class);
});
