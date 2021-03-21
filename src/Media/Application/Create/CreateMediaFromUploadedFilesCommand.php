<?php

declare(strict_types = 1);

namespace App\Media\Application\Create;

final class CreateMediaFromUploadedFilesCommand
{
    public function __construct(
        public string $realizationId,
        public array $images,
    ) {}
}
