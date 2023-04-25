<?php

namespace App\Common\Http\Response;

use Symfony\Component\HttpFoundation\Response;

class ErrorResponse implements HttpOutputInterface
{
    public string $code;
    private int $httpStatus;

    public function __construct(
        string $code,
        int $httpStatus = Response::HTTP_UNPROCESSABLE_ENTITY
    )
    {
        $this->httpStatus = $httpStatus;
        $this->code = $code;
    }

    public function getHttpStatus(): int
    {
        return $this->httpStatus;
    }
}
