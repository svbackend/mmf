<?php

namespace App\Product\Http\Response;

use App\Common\Http\Response\HttpOutputInterface;
use App\Product\DTO\ViewProductDto;

class AllProductsResponse implements HttpOutputInterface
{
    /** @var ViewProductDto[] $product */
    public array $products;

    public function __construct(
        array $products
    )
    {
        $this->products = $products;
    }

    public function getHttpStatus(): int
    {
        return 200;
    }
}
