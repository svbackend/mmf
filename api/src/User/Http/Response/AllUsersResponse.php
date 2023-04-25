<?php

namespace App\User\Http\Response;

use App\Common\Http\Response\HttpOutputInterface;
use App\User\DTO\UserDto;
use Symfony\Component\HttpFoundation\Response;

class AllUsersResponse implements HttpOutputInterface
{
    /** @var UserDto[] $users */
    public array $users;

    public function __construct(
        array $users
    )
    {
        $this->users = $users;
    }


    public function getHttpStatus(): int
    {
        return Response::HTTP_OK;
    }
}
