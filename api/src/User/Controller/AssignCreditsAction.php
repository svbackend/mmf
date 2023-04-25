<?php

namespace App\User\Controller;

use App\Common\Controller\BaseAction;
use App\Common\Http\Response\HttpOutputInterface;
use App\Common\OpenApi\Ref\ServerErrorRef;
use App\User\Entity\User;
use App\User\Http\Request\AssignCreditsRequest;
use App\User\Repository\UserRepository;
use App\User\ValueObject\CreditsValue;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @OA\Tag(name="User")
 */
class AssignCreditsAction extends BaseAction
{
    private UserRepository $userRepository;

    public function __construct(
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/api/v1/users/{id}/assign-credits", methods={"PUT"})
     * @OA\RequestBody(@Model(type=AssignCreditsRequest::class))
     * @OA\Response(response=204, description="success")
     * @OA\Response(response=500, description="server error", @Model(type=ServerErrorRef::class))
     */
    public function __invoke(
        int $id,
        AssignCreditsRequest $request
    ): HttpOutputInterface
    {
        $this->denyAccessUnlessGranted(User::ROLE_ADMIN);

        $user = $this->userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException();
        }

        $credits = new CreditsValue($request->credits);
        $user->setCredits($credits);
        $this->userRepository->save($user, true);

        return $this->success();
    }
}
