<?php

namespace App\User\DTO;


use App\User\Entity\User;

class UserDto
{
    public int $id;
    public string $email;

    /** @var string[] $roles */
    public array $roles;

    public float $credits;

    public function __construct(
        int $id,
        string $email,
        array $roles,
        float $credits
    )
    {
        $this->roles = $roles;
        $this->email = $email;
        $this->id = $id;
        $this->credits = $credits;
    }

    public static function fromUser(User $user): self
    {
        return new self(
            $user->getId(),
            $user->getEmail(),
            $user->getRoles(),
            (float)$user->getCredits()
        );
    }
}
