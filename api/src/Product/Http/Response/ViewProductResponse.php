<?php

namespace App\Product\Http\Response;

use App\Common\Http\Response\HttpOutputInterface;
use App\Product\DTO\ViewProductDto;

class ViewProductResponse implements HttpOutputInterface
{
    public ViewProductDto $product;

    public function __construct(
        ViewProductDto $product
    )
    {
        $this->product = $product;
    }

    public function getHttpStatus(): int
    {
        return 200;
    }
}
