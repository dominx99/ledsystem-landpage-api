<?php declare(strict_types=1);

namespace App\Account\Domain\Repository;

use App\Account\Domain\Resource\User;

interface UserRepository
{
    /** @throws UserNotFoundException */
    public function findOneByEmail(string $email): User;
    public function update(User $user): void;
}
