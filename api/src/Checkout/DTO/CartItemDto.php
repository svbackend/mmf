<?php

namespace App\Checkout\DTO;

use App\Checkout\Entity\PurchaseItem;
use App\Product\DTO\ViewProductDto;

class CartItemDto
{
    public ViewProductDto $product;
    public int $qty;

    public function __construct(
        ViewProductDto $product,
        int $qty
    ) {
        $this->product = $product;
        $this->qty = $qty;
    }

    public static function fromCartItem(PurchaseItem $cartItem): self
    {
        return new self(
            ViewProductDto::fromProduct($cartItem->getProduct()),
            $cartItem->getQty()
        );
    }
}
