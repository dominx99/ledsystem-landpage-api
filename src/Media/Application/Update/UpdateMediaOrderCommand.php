<?php

declare(strict_types = 1);

namespace App\Media\Application\Update;

final class UpdateMediaOrderCommand
{
    public function __construct(
        public array $medias,
    ) {}
}
