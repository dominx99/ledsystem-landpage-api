<?php declare(strict_types=1);

namespace App\Account\Infrastructure\Repository;

use App\Account\Domain\Repository\UserRepository;
use App\Account\Domain\Resource\User;
use Doctrine\DBAL\Connection;
use App\Account\Domain\Exception\UserNotFoundException;

final class UserRepositoryDbal implements UserRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findOneByEmail(string $email): User
    {
        $qb = $this
            ->connection
            ->createQueryBuilder();

        $qb
            ->select('*')
            ->from('users', 'u')
            ->where('u.email = :email')
            ->setParameter('email', $email);

        $user = $this->connection->fetchAssociative(
            $qb->getSQL(),
            $qb->getParameters(),
        );

        if (! $user) {
            throw new UserNotFoundException();
        }

        return User::fromArray($user);
    }

    public function update(User $user): void
    {
        $this
            ->connection
            ->createQueryBuilder()
            ->update("users", "u")
            ->set("u.accessToken", ":accessToken")
            ->where("u.id = :id")
            ->setParameters([
                "id"          => $user->getId(),
                "accessToken" => $user->getAccessToken(),
            ])
            ->execute();
    }
}
