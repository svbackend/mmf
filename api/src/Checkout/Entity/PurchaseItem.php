<?php

namespace App\Checkout\Entity;

use App\Product\Entity\Product;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Checkout\Repository\PurchaseItemRepository")
 */
class PurchaseItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Product\Entity\Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false)
     */
    private Product $product;

    /**
     * @ORM\ManyToOne(targetEntity="Purchase", inversedBy="cartItems")
     * @ORM\JoinColumn(name="cart_id", referencedColumnName="id", nullable=false)
     */
    private Purchase $purchase;

    /**
     * @ORM\Column(type="integer")
     */
    private int $qty;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private string $price;

    public function __construct(
        Product $product,
        Purchase $purchase,
        int $qty
    )
    {
        $this->product = $product;
        $this->purchase = $purchase;
        $this->qty = $qty;
        $this->price = $product->getPrice();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getPurchase(): Purchase
    {
        return $this->purchase;
    }

    public function getQty(): int
    {
        return $this->qty;
    }

    public function setQty(int $qty): void
    {
        $this->qty = $qty;
    }
}
