<?php

namespace App\Checkout\Http\Request;

use App\Common\Http\Request\HttpInputInterface;
use Symfony\Component\Validator\Constraints as Assert;

class AddToCartRequest implements HttpInputInterface
{
    public int $productId;
    public int $qty;

    public function __construct(
        int $productId,
        int $qty
    )
    {
        $this->productId = $productId;
        $this->qty = $qty;
    }

    public static function rules(): Assert\Collection
    {
        return new Assert\Collection([
            'productId' => [
                new Assert\NotBlank(),
                new Assert\Type('integer'),
                new Assert\Positive(),
            ],
            'qty' => [
                new Assert\NotBlank(),
                new Assert\Type('integer'),
                new Assert\Positive(),
            ],
        ]);
    }
}
