<?php

declare(strict_types = 1);

namespace App\Media\Infrastructure\Remover;

use App\Media\Domain\Remover\FileRemoverInterface;

final class FileRemover implements FileRemoverInterface
{
    public function remove(string $path): void
    {
        if (is_dir($path)) {
            rmdir($path);

            return;
        }

        unlink($path);
    }
}
