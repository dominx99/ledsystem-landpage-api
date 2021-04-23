<?php

declare(strict_types = 1);

namespace App\Realization\Http\Actions;

use Psr\Http\Message\ResponseInterface;
use App\Shared\Http\Responses\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use App\Realization\Application\Update\ChangeRealizationVisibilityOnMainPageCommand;
use App\Realization\Application\Update\ChangeRealizationVisibilityOnMainPageCommandHandler;

final class ChangeRealizationVisibilityOnMainPageAction
{
    public function __construct (
        private ChangeRealizationVisibilityOnMainPageCommandHandler $changeRealizationVisibilityOnMainPageHandler,
    ) {}

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $realizationId = $request->getAttribute('realizationId');
        $body = $request->getParsedBody();

        $this->changeRealizationVisibilityOnMainPageHandler->handle(new ChangeRealizationVisibilityOnMainPageCommand(
            $realizationId,
            (bool) $body['isVisible'],
        ));

        return JsonResponse::create(['status' => 'success']);
    }
}
