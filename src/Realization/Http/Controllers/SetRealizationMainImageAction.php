<?php

declare(strict_types = 1);

namespace App\Realization\Http\Controllers;

use App\Realization\Application\Update\UpdateRealizationMainImageCommand;
use App\Realization\Application\Update\UpdateRealizationMainImageCommandHandler;
use App\Shared\Http\Responses\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator as v;
use App\Shared\Domain\Validation\Validator;

final class SetRealizationMainImageAction
{
    public function __construct (
        private UpdateRealizationMainImageCommandHandler $updateRealizationMainImage,
        private Validator $validator,
    ) {}

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $body = $request->getParsedBody();

        $this->validator->validate($body, [
            'mediaId' => v::notEmpty(),
        ]);

        $this->updateRealizationMainImage->handle(new UpdateRealizationMainImageCommand(
            $request->getAttribute('realizationId'),
            $body['mediaId'],
        ));

        return JsonResponse::create(['status' => 'success']);
    }
}
