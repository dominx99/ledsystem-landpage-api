<?php

declare(strict_types = 1);

namespace App\Realization\Http\Actions;

use App\Media\Domain\Repository\FileRepository;
use App\Media\Domain\Repository\MediaRepository;
use App\Realization\Domain\Repository\RealizationRepository;
use Psr\Http\Message\ResponseInterface;
use App\Shared\Http\Responses\JsonResponse;

final class GetRealizationsVisibleOnMainPageAction
{
    public function __construct (
        private RealizationRepository $realizationRepository,
        private MediaRepository $mediaRepository,
        private FileRepository $fileRepository,
    ) {}

    public function __invoke(): ResponseInterface
    {
        $realizations = $this->realizationRepository->findAllVisibleOnMainPage();

        $realizations = array_filter($realizations, fn($realization) => ! empty($realization['mainImageId']));

        $realizations = array_map(function($realization) {
            return array_merge($realization, [
                'mainImage' => array_merge($this->mediaRepository->find($realization['mainImageId']), [
                    'images' => $this->fileRepository->findByMediaId($realization['mainImageId']),
                ]),
            ]);
        }, $realizations);

        $realizations = array_values($realizations);

        return JsonResponse::create(
            $realizations,
        );
    }
}
