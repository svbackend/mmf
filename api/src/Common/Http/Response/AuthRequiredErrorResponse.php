<?php

namespace App\Common\Http\Response;

use OpenApi\Annotations as OA;

class AuthRequiredErrorResponse
{
    /** @OA\Property(example="api_token_required") */
    public string $code;
}
