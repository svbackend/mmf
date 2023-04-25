<?php

namespace App\Checkout\Http\Response;

use App\Checkout\DTO\CartWithItemsDto;
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
