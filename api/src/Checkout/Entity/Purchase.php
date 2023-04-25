<?php

namespace App\Checkout\Entity;

use App\User\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Checkout\Repository\PurchaseRepository")
 */
class Purchase
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\OneToOne(targetEntity="App\User\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $owner;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $placedAt;

    public function __construct(User $owner)
    {
        $this->owner = $owner;
        $this->placedAt = new \DateTimeImmutable();
    }
}
