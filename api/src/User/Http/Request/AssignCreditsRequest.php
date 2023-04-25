<?php

namespace App\User\Http\Request;

use App\Common\Http\Request\HttpInputInterface;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

class AssignCreditsRequest implements HttpInputInterface
{
    /** @OA\Property(example="17.50") */
    public float $credits;

    public function __construct(float $credits)
    {
        $this->credits = $credits;
    }

    public static function rules(): Assert\Collection
    {
        return new Assert\Collection([
            'credits' => [
                new Assert\Type('float'),
                new Assert\NotBlank(),
                new Assert\PositiveOrZero(),
            ],
        ]);
    }
}
