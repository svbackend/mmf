<?php

namespace App\User\Http\Response;

use App\User\DTO\UserDto;
use App\Common\Http\Response\HttpOutputInterface;
use Symfony\Component\HttpFoundation\Response;

class LoginSuccessResponse implements HttpOutputInterface
{
    public UserDto $user;
    public string $apiToken;

    public function __construct(
        UserDto $user,
        string $apiToken
    )
    {
        $this->apiToken = $apiToken;
        $this->user = $user;
    }

    public function getHttpStatus(): int
    {
        return Response::HTTP_OK;
    }
}
