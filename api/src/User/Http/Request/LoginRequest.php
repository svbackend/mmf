<?php

namespace App\User\Http\Request;

use App\User\Validation\ValidationRule;
use App\Common\Http\Request\HttpInputInterface;
use Symfony\Component\Validator\Constraints as Assert;

class LoginRequest implements HttpInputInterface
{
    public string $email;
    public string $password;

    public function __construct(
        string $email,
        string $password
    )
    {
        $this->password = $password;
        $this->email = $email;
    }

    public static function rules(): Assert\Collection
    {
        return new Assert\Collection([
            'email' => ValidationRule::email(),
            'password' => ValidationRule::password(),
        ]);
    }
}
