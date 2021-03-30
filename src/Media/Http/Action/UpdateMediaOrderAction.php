<?php

declare(strict_types = 1);

namespace App\Media\Http\Action;

use App\Shared\Http\Responses\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Media\Application\Update\UpdateMediaOrderCommand;
use App\Media\Application\Update\UpdateMediaOrderCommandHandler;

final class UpdateMediaOrderAction
{
    public function __construct (
        public UpdateMediaOrderCommandHandler $updateMediaOrder,
    ) {}

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $body = $request->getParsedBody();

        $this->updateMediaOrder->handle(new UpdateMediaOrderCommand(
            $body['medias'],
        ));

        return JsonResponse::create(['status' => 'success']);
    }
}
