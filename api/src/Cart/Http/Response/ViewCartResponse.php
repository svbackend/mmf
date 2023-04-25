<?php

namespace App\Cart\Http\Response;

use App\Cart\DTO\CartWithItemsDto;
use App\Common\Http\Response\HttpOutputInterface;

class ViewCartResponse implements HttpOutputInterface
{
    public CartWithItemsDto $cart;

    public function __construct(
        CartWithItemsDto $cart
    ) {
        $this->cart = $cart;
    }

    public function getHttpStatus(): int
    {
        return 200;
    }
}
