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

        $medias = array_map(function (array $media) {
            return array_merge($media, [
                'images' => $this->fileRepository->findByMediaId($media['id']),
            ]);
        }, $medias);

        return JsonResponse::create($medias);
    }

    public function mainImage(ServerRequestInterface $request): ResponseInterface
    {
        $realization = $this->realizationRepository->find(
            $request->getAttribute('realizationId'),
        );

        $mainImage = array_merge($this->mediaRepository->find($realization['mainImageId']), [
            'images' => $this->fileRepository->findByMediaId($realization['mainImageId']),
        ]);

        return JsonResponse::create($mainImage);
    }
}
