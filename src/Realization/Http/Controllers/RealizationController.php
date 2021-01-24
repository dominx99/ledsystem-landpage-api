<?php declare(strict_types=1);

namespace App\Realization\Http\Controllers;

use App\Realization\Application\Create\CreateRealizationCommand;
use App\Realization\Application\Create\CreateRealizationCommandHandler;
use App\Shared\Http\Responses\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;

final class RealizationController
{
    private CreateRealizationCommandHandler $createRealization;

    public function __construct(CreateRealizationCommandHandler $createRealization)
    {
        $this->createRealization = $createRealization;
    }

    public function store(ServerRequestInterface $request): ResponseInterface
    {
        $body = $request->getParsedBody();

        $this->createRealization->handle(new CreateRealizationCommand(
            (string) Uuid::uuid4(),
            $request->getAttribute('decodedToken')->id(),
            $body['name'],
            $body['description'],
        ));

        return JsonResponse::create();
    }
}
