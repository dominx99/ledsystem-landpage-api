<?php declare(strict_types=1);

namespace App\Realization\Http\Controllers;

use App\Media\Application\Create\CreateMediaFromUploadedFilesCommandHandler;
use App\Realization\Application\Create\CreateRealizationCommand;
use App\Realization\Application\Create\CreateRealizationCommandHandler;
use App\Realization\Domain\Repository\RealizationRepository;
use App\Shared\Domain\Validation\ValidationException;
use App\Shared\Domain\Validation\Validator;
use App\Shared\Http\Responses\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Respect\Validation\Validator as v;
use App\Media\Application\Create\CreateMediaFromUploadedFilesCommand;
use App\Media\Domain\Repository\FileRepository;

final class RealizationController
{
    public function __construct (
        private CreateRealizationCommandHandler $createRealization,
        private Validator $validator,
        private RealizationRepository $realizationRepository,
        private CreateMediaFromUploadedFilesCommandHandler $createMediaFromUploadedFiles,
        private FileRepository $fileRepository,
    ) {}

    public function index(): ResponseInterface
    {
        $realizations = $this->realizationRepository->findAll();

        $realizations = array_filter($realizations, fn($realization) => ! empty($realization['mainImageId']));

        $realizations = array_map(function($realization) {
            return array_merge($realization, [
                'mainImage' => $this->fileRepository->findByMediaId($realization['mainImageId']),
            ]);
        }, $realizations);

        return JsonResponse::create(
            $realizations,
        );
    }

    public function show(ServerRequestInterface $request): ResponseInterface
    {
        $slug = $request->getAttribute('slug');

        $realization = $this->realizationRepository->findOneBySlug($slug);

        $realization = array_merge($realization, [
            'mainImage' => $this->fileRepository->findByMediaId($realization['mainImageId']),
        ]);

        return JsonResponse::create($realization);
    }

    public function store(ServerRequestInterface $request): ResponseInterface
    {
        $body = $request->getParsedBody();
        $files = $request->getUploadedFiles();

        $this->validator->validate($body, [
            'name'        => v::notEmpty(),
            'slug'        => v::notEmpty(),
            'description' => v::notEmpty(),
        ]);

        $this->validator->validate($files, [
            'images' => v::notEmpty(),
        ]);

        if ($this->realizationRepository->existsBySlug($body['slug'])) {
            throw ValidationException::withMessages([
                'slug' => [
                    "Realizacja z podanym slug'iem już istnieje",
                ],
            ]);
        }

        $realizationId = (string) Uuid::uuid4();

        $this->createRealization->handle(new CreateRealizationCommand(
            $realizationId,
            $request->getAttribute('decodedToken')->id(),
            $body['name'],
            $body['slug'],
            $body['description'],
        ));

        $this->createMediaFromUploadedFiles->handle(new CreateMediaFromUploadedFilesCommand(
            $realizationId,
            $files['images'],
        ));

        return JsonResponse::create(['status' => 'success']);
    }
}
