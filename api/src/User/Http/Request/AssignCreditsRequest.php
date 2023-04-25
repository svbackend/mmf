<?php

namespace App\User\Http\Request;

use App\Common\Http\Request\HttpInputInterface;
use Symfony\Component\Validator\Constraints as Assert;

class AssignCreditsRequest implements HttpInputInterface
{
    public float $credits;

    public function __construct(float $credits)
    {
        $this->credits = $credits;
    }

    public static function rules(): Assert\Collection
    {
        return new Assert\Collection([
            'credits' => [
                new Assert\NotBlank(),
                new Assert\PositiveOrZero(),
            ],
        ]);
    }
}
