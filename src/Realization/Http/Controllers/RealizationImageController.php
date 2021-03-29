<?php declare(strict_types=1);

namespace App\Realization\Http\Controllers;

use App\Shared\Http\Responses\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Media\Domain\Repository\FileRepository;
use App\Media\Domain\Repository\MediaRepository;
use App\Realization\Domain\Repository\RealizationRepository;

final class RealizationImageController
{
    public function __construct (
        private FileRepository $fileRepository,
        private MediaRepository $mediaRepository,
        private RealizationRepository $realizationRepository,
    ) {}

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        $medias = $this->mediaRepository->findByRealizationId(
            $request->getAttribute('realizationId'),
        );

        $images = array_map(function (array $media) {
            return $this->fileRepository->findByMediaId($media['id']);
        }, $medias);

        return JsonResponse::create($images);
    }

    public function mainImage(ServerRequestInterface $request): ResponseInterface
    {
        $realization = $this->realizationRepository->find(
            $request->getAttribute('realizationId'),
        );

        $mainImage = $this->fileRepository->findByMediaId($realization['mainImageId']);

        return JsonResponse::create($mainImage);
    }
}
