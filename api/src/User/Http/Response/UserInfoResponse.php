<?php

namespace App\User\Http\Response;

use App\User\DTO\UserDto;
use App\Common\Http\Response\HttpOutputInterface;
use Symfony\Component\HttpFoundation\Response;

class UserInfoResponse implements HttpOutputInterface
{
    public UserDto $user;

    public function __construct(
        UserDto $user
    )
    {
        $this->user = $user;
    }


    public function getHttpStatus(): int
    {
        return Response::HTTP_OK;
    }
}
