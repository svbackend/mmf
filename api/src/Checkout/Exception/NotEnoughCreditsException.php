<?php

namespace App\Checkout\Exception;

class NotEnoughCreditsException extends \Exception
{
    public float $requiredCredits;
    public float $userCredits;

    public function __construct(
        float $requiredCredits,
        float $userCredits
    )
    {
        $this->requiredCredits = $requiredCredits;
        $this->userCredits = $userCredits;

        parent::__construct();
    }
}
