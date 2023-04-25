<?php

namespace App\Checkout\DTO;

class CartWithItemsDto
{
    /** @var CartItemDto[] $items */
    public array $items;
    public \DateTimeInterface $updatedAt;

    /** @param CartItemDto[] $items */
    public function __construct(
        array $items,
        \DateTimeInterface $updatedAt
    ) {
        $this->items = $items;
        $this->updatedAt = $updatedAt;
    }
}
