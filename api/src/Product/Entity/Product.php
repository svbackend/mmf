<?php

namespace App\Product\Entity;

use App\User\Entity\User;
use App\Product\ValueObject\PriceValue;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Product\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="text")
     */
    private string $description;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private string $price;

    /**
     * @ORM\Column(type="integer")
     */
    private int $qty;

    /**
     * @ORM\ManyToOne(targetEntity="App\User\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $owner;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $deletedAt;

    public function __construct(
        string $name,
        string $description,
        int $qty,
        PriceValue $price,
        User $owner
    )
    {
        $this->name = $name;
        $this->description = $description;
        $this->setQty($qty);
        $this->price = $price->getValue();
        $this->owner = $owner;
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->deletedAt = null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function update(
        string $name,
        string $description,
        int $qty,
        PriceValue $price
    )
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price->getValue();
        $this->setQty($qty);
        $this->updatedAt = new \DateTimeImmutable();
    }

    private function setQty(int $qty): void
    {
        $this->qty = max($qty, 0);
    }

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function delete()
    {
        $this->deletedAt = new \DateTimeImmutable();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getQty(): int
    {
        return $this->qty;
    }
}
