<?php

namespace App\Product\Http\Request;

use App\Common\Http\Request\HttpInputInterface;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

class NewProductRequest implements HttpInputInterface
{
    public string $name;
    public string $description;

    /** @OA\Property(example="15.75") */
    public float $price;

    /** @OA\Property(example="1") */
    public int $quantity;

    public function __construct(
        string $name,
        string $description,
        float $price,
        int $quantity
    )
    {
        $this->name = $name;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    public static function rules(): Assert\Collection
    {
        return new Assert\Collection([
            'name' => [new Assert\NotBlank(), new Assert\Length(['min' => 2, 'max' => 255])],
            'description' => [],
            'quantity' => [new Assert\NotBlank(), new Assert\Type('integer'), new Assert\GreaterThanOrEqual(0)],
            'price' => [new Assert\NotBlank(), new Assert\Type('float'), new Assert\GreaterThanOrEqual(0)]
        ]);
    }
}
