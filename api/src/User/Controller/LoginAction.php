<?php

namespace App\User\Controller;

use App\User\DTO\UserDto;
use App\User\Entity\ApiToken;
use App\User\Entity\UserPassword;
use App\User\Http\Request\LoginRequest;
use App\User\Http\Response\LoginSuccessResponse;
use App\User\OpenApi\Ref\LoginErrorRef;
use App\User\Repository\ApiTokenRepository;
use App\User\Repository\UserRepository;
use App\Common\Controller\BaseAction;
use App\Common\Http\Response\HttpOutputInterface;
use App\Common\OpenApi\Ref\ServerErrorRef;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @OA\Tag(name="User")
 */
class LoginAction extends BaseAction
{
    private ApiTokenRepository $apiTokens;
    private UserRepository $userRepository;
    private UserPasswordEncoderInterface $passwordHasher;

    public function __construct(
        ApiTokenRepository $apiTokens,
        UserRepository $userRepository,
        UserPasswordEncoderInterface $passwordHasher
    )
    {
        $this->apiTokens = $apiTokens;
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @Route("/api/v1/login", methods={"POST"})
     * @OA\RequestBody(@Model(type=LoginRequest::class))
     * @OA\Response(response=200, description="success", @Model(type=LoginSuccessResponse::class))
     * @OA\Response(response=401, description="invalid creds", @Model(type=LoginErrorRef::class))
     * @OA\Response(response=500, description="server error", @Model(type=ServerErrorRef::class))
     */
    public function __invoke(LoginRequest $loginRequest): HttpOutputInterface
    {
        $userPassword = new UserPassword($loginRequest->password, $this->passwordHasher);
        $user = $this->userRepository->findByEmailAndPassword($loginRequest->email, $userPassword);

        if (!$user) {
            return $this->error('invalid_creds', 401);
        }

        $apiToken = new ApiToken($user);
        $this->apiTokens->save($apiToken, true);

        return new LoginSuccessResponse(
            UserDto::fromUser($user),
            $apiToken->getToken(),
        );
    }
}
