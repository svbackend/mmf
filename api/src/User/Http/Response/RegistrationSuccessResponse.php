<?php

namespace App\User\Http\Response;

use App\Common\Http\Response\HttpOutputInterface;
use Symfony\Component\HttpFoundation\Response;

class RegistrationSuccessResponse implements HttpOutputInterface
{
    public int $userId;

    public function __construct(
        int $userId
    )
    {
        $this->userId = $userId;
    }

    public function getHttpStatus(): int
    {
        return Response::HTTP_CREATED;
    }
}
