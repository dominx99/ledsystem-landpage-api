<?php

declare(strict_types = 1);

namespace App\Media\Infrastructure\Repository;

use App\Media\Domain\Repository\FileRepository;
use Doctrine\DBAL\Connection;
use App\Media\Domain\Resource\File;

final class FileRepositoryDbal implements FileRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function add(File $file): void
    {
        $this
            ->connection
            ->createQueryBuilder()
            ->insert("files")
            ->values([
                "id"       => ":id",
                "mediaId"  => ":mediaId",
                "filename" => ":filename",
                "path"     => ":path",
                "fullPath" => ":fullPath",
                "url"      => ":url",
            ])
            ->setParameters([
                "id"       => $file->id,
                "mediaId"  => $file->mediaId,
                "filename" => $file->filename,
                "path"     => $file->path,
                "fullPath" => $file->fullPath,
                "url"      => $file->url,
            ])
            ->execute();
    }
}
