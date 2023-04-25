<?php

namespace App\Product\DTO;

use App\Product\Entity\Product;

class ViewProductDto
{
    public int $id;
    public string $name;
    public string $description;
    public int $quantity;
    public string $price;
    public int $ownerId;

    public function __construct(
        int $id,
        string $name,
        string $description,
        int $quantity,
        string $price,
        int $ownerId
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->ownerId = $ownerId;
    }

    public static function fromProduct(Product $product): self
    {
        return new self(
            $product->getId(),
            $product->getName(),
            $product->getDescription(),
            $product->getQty(),
            $product->getPrice(),
            $product->getOwner()->getId()
        );
    }
}
