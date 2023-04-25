<?php

namespace App\User\Entity;

use App\User\Repository\UserRepository;
use App\User\ValueObject\CreditsValue;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`users`")
 */
class User implements UserInterface
{
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(length=180, unique=true)
     */
    private string $email;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles;

    /**
     * @ORM\Column
     */
    private string $password;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private string $credits;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $createdAt;

    public function __construct(
        string $email,
        UserPassword $password
    )
    {
        $this->email = $email;
        $this->password = $password->getHashedPassword($this);
        $this->roles = [self::ROLE_USER];
        $this->credits = '0.00';
        $this->createdAt = new \DateTimeImmutable();
    }

    public function setCredits(CreditsValue $credits)
    {
        $this->credits = $credits->getValue();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getSalt()
    {
        return null;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->getEmail();
    }

    public function eraseCredentials()
    {
        // we do not store plain passwords, so nothing to do here
    }

    public function setPasswordHash(string $newHashedPassword): void
    {
        $this->password = $newHashedPassword;
    }

    public function getCredits(): string
    {
        return $this->credits;
    }
}
