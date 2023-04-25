<?php

namespace App\Common\Http\Response;

use Symfony\Component\HttpFoundation\Response;

class SuccessResponse implements HttpOutputInterface
{
    public string $code = 'success';

    private int $httpStatus;

    public function __construct(
        string $code = 'success',
        int $httpStatus = Response::HTTP_OK
    )
    {
        $this->code = $code;
        $this->httpStatus = $httpStatus;
    }

    public function getHttpStatus(): int
    {
        return $this->httpStatus;
    }
}
