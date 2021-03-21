<?php

declare(strict_types = 1);

namespace App\Media\Domain\Uploader;

interface MultipleFileUploaderInterface
{
    public function upload(array $files): void;
}
