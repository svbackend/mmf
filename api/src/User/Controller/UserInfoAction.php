<?php

namespace App\User\Controller;

use App\Common\Controller\BaseAction;
use App\Common\Http\Response\AuthRequiredErrorResponse;
use App\User\DTO\UserDto;
use App\User\Entity\User;
use App\User\Http\Response\UserInfoResponse;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @OA\Tag(name="User")
 * @see UserInfoActionTest
 */
class UserInfoAction extends BaseAction
{
    /**
     * @Route("/api/v1/me", methods={"GET"})
     * @OA\Response(response=200, description="success", @Model(type=UserInfoResponse::class))
     * @OA\Response(response=401, description="auth required", @Model(type=AuthRequiredErrorResponse::class))
     * @Security(name="ApiToken")
     */
    public function __invoke(): UserInfoResponse
    {
        $this->denyAccessUnlessGranted(User::ROLE_USER);

        /** @var User|null $user */
        $user = $this->getUser();

        return new UserInfoResponse(
            UserDto::fromUser($user)
        );
    }
}
