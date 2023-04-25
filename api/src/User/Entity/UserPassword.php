<?php

namespace App\User\Entity;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserPassword
{
    private string $plainPassword;
    private UserPasswordEncoderInterface $passwordHasher;

    public function __construct(
        string $plainPassword,
        UserPasswordEncoderInterface $passwordHasher
    )
    {
        $this->passwordHasher = $passwordHasher;
        $this->plainPassword = $plainPassword;
    }

    public function getHashedPassword(UserInterface $user): string
    {
        return $this->passwordHasher->encodePassword($user, $this->plainPassword);
    }

    public function isPasswordValid(UserInterface $user): bool
    {
        return $this->passwordHasher->isPasswordValid($user, $this->plainPassword);
    }
}
