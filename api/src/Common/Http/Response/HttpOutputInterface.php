<?php

namespace App\Common\Http\Response;

interface HttpOutputInterface
{
    public function getHttpStatus(): int;
}
