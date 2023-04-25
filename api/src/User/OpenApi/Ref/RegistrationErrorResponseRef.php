<?php

namespace App\User\OpenApi\Ref;

use OpenApi\Annotations as OA;

class RegistrationErrorResponseRef
{
    /** @OA\Property(example="already_exists") */
    public string $code;
}
