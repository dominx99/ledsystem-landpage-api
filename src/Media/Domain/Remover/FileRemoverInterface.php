<?php

declare(strict_types = 1);

namespace App\Media\Domain\Remover;

interface FileRemoverInterface
{
    public function remove(string $path): void;
}
