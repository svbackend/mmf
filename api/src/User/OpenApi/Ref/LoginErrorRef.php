<?php

namespace App\User\OpenApi\Ref;

use OpenApi\Annotations as OA;

class LoginErrorRef
{
    /** @OA\Property(example="invalid_creds") */
    public string $error;
}
