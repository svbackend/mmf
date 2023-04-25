<?php

namespace App\Cart\DTO;

use App\Cart\Entity\CartItem;
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

    public static function fromCartItem(CartItem $cartItem): self
    {
        return new self(
            ViewProductDto::fromProduct($cartItem->getProduct()),
            $cartItem->getQty()
        );
    }
}
