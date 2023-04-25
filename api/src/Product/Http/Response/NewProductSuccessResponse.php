<?php

namespace App\Product\Http\Response;

use App\Common\Http\Response\HttpOutputInterface;
use Symfony\Component\HttpFoundation\Response;

class NewProductSuccessResponse implements HttpOutputInterface
{
    public int $productId;

    public function __construct(
        int $productId
    )
    {
        $this->productId = $productId;
    }

    public function getHttpStatus(): int
    {
        return Response::HTTP_CREATED;
    }
}
