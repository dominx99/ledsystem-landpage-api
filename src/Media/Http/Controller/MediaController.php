<?php

declare(strict_types = 1);

namespace App\Media\Http\Controller;

use Psr\Http\Message\ResponseInterface;
use App\Shared\Http\Responses\JsonResponse;
use App\Media\Application\Remove\RemoveMediaCommandHandler;
use App\Media\Application\Remove\RemoveMediaCommand;
use Psr\Http\Message\ServerRequestInterface;

final class MediaController
{
    public function __construct (
        private RemoveMediaCommandHandler $removeMedia,
    ) {}

    public function remove(ServerRequestInterface $request): ResponseInterface
    {
        $this->removeMedia->handle(new RemoveMediaCommand(
            $request->getAttribute('mediaId'),
        ));

        return JsonResponse::create(['status' => 'success']);
    }
}
