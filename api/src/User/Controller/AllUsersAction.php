<?php

namespace App\User\Controller;

use App\Common\Controller\BaseAction;
use App\Common\Http\Response\HttpOutputInterface;
use App\Common\OpenApi\Ref\ServerErrorRef;
use App\User\DTO\UserDto;
use App\User\Http\Response\AllUsersResponse;
use App\User\Repository\UserRepository;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @OA\Tag(name="User")
 */
class AllUsersAction extends BaseAction
{
    private UserRepository $userRepository;

    public function __construct(
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/api/v1/users", methods={"GET"})
     * @OA\Response(response=200, description="List of all users", @Model(type=AllUsersResponse::class))
     * @OA\Response(response=500, description="Server error", @Model(type=ServerErrorRef::class))
     */
    public function __invoke(): HttpOutputInterface
    {
        $users = $this->userRepository->findAll();

        $viewUserDtos = array_map(function ($user) {
            return UserDto::fromUser($user);
        }, $users);

        return new AllUsersResponse($viewUserDtos);
    }
}
