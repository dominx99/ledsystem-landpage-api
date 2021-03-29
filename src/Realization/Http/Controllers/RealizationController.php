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
use App\Media\Domain\Repository\MediaRepository;
use App\Shared\Domain\Exception\BusinessException;
use App\Shared\Domain\Exception\UnexpectedException;
use App\Realization\Application\Update\UpdateRealizationMainImageCommand;
use App\Realization\Application\Update\UpdateRealizationCommand;
use App\Realization\Application\Update\UpdateRealizationCommandHandler;
use App\Realization\Application\Update\UpdateRealizationMainImageCommandHandler;
use App\Realization\Application\Remove\RemoveRealizationCommand;
use App\Realization\Application\Remove\RemoveRealizationCommandHandler;

final class RealizationController
{
    public function __construct (
        private CreateRealizationCommandHandler $createRealization,
        private UpdateRealizationCommandHandler $updateRealization,
        private Validator $validator,
        private RealizationRepository $realizationRepository,
        private CreateMediaFromUploadedFilesCommandHandler $createMediaFromUploadedFiles,
        private FileRepository $fileRepository,
        private MediaRepository $mediaRepository,
        private UpdateRealizationMainImageCommandHandler $updateRealizationMainImage,
        private RemoveRealizationCommandHandler $removeRealization,
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

        $realizations = array_values($realizations);

        return JsonResponse::create(
            $realizations,
        );
    }

    public function show(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $slug = $request->getAttribute('slug');

            $realization = $this->realizationRepository->findOneBySlug($slug);

            $medias = $this->mediaRepository->findByRealizationId($realization['id']);
            $images = array_map(function (array $media) {
                return $this->fileRepository->findByMediaId($media['id']);
            }, $medias);

            $realization = array_merge($realization, [
                'mainImage' => $this->fileRepository->findByMediaId($realization['mainImageId']),
                'images' => $images,
            ]);

            return JsonResponse::create($realization);
        } catch (BusinessException $e) {
            throw $e;
        } catch (\Throwable $t) {
            throw new UnexpectedException($t);
        }
    }

    public function update(ServerRequestInterface $request): ResponseInterface
    {
        $body = $request->getParsedBody() ?? [];
        $files = $request->getUploadedFiles() ?? [];

        $this->validator->validate($body, [
            'id'          => v::notEmpty(),
            'name'        => v::notEmpty(),
            'slug'        => v::notEmpty(),
            'description' => v::notEmpty(),
        ]);

        $realization = $this->realizationRepository->find($body['id']);

        if (
            $this->realizationRepository->existsBySlug($body['slug']) &&
            $realization['slug'] !== $body['slug']
        ) {
            throw ValidationException::withMessages([
                'slug' => [
                    "Realizacja z podanym slug'iem już istnieje",
                ],
            ]);
        }

        $realizationId = $realization['id'];

        $this->updateRealization->handle(new UpdateRealizationCommand(
            $realizationId,
            $request->getAttribute('decodedToken')->id(),
            $body['name'],
            $body['slug'],
            $body['description'],
        ));

        if (! isset($files['images'])) {
            return JsonResponse::create(['status' => 'success']);
        }

        try {
            $this->createMediaFromUploadedFiles->handle(new CreateMediaFromUploadedFilesCommand(
                $realizationId,
                $files['images'],
            ));
        } catch (\Throwable $t) {
            throw new UnexpectedException($t);
        }

        return JsonResponse::create(['status' => 'success']);
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

        $medias = $this->mediaRepository->findByRealizationId($realizationId);

        if (count ($medias) > 0) {
            $this->updateRealizationMainImage->handle(new UpdateRealizationMainImageCommand(
                $realizationId,
                $medias[0]['id'],
            ));
        }

        return JsonResponse::create(['status' => 'success']);
    }

    public function remove(ServerRequestInterface $request): ResponseInterface
    {
        $this->removeRealization->handle(new RemoveRealizationCommand(
            $request->getAttribute('realizationId'),
        ));

        return JsonResponse::create(['status' => 'success']);
    }
}
