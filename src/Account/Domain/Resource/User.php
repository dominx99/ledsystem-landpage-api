<?php declare(strict_types=1);

namespace App\Account\Domain\Resource;

final class User
{
    private string $id;
    private string $name;
    private string $email;
    private string $password;
    private string $accessToken;

    public function __construct(
        string $id,
        string $name,
        string $email,
        string $password,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public static function fromArray(array $user): self
    {
        return new static(
            $user['id'],
            $user['name'],
            $user['email'],
            $user['password'],
        );
    }

    public function setAccessToken(string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }
}
