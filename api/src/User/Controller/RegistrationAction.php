<?php

namespace App\User\Controller;

use App\User\Entity\User;
use App\User\Entity\UserPassword;
use App\User\Http\Request\RegistrationRequest;
use App\User\Http\Response\RegistrationSuccessResponse;
use App\User\OpenApi\Ref\RegistrationErrorResponseRef;
use App\Common\Controller\BaseAction;
use App\Common\Http\Response\HttpOutputInterface;
use App\Common\OpenApi\Ref\ServerErrorRef;
use App\Common\OpenApi\Ref\ValidationErrorResponseRef;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @OA\Tag(name="User")
 */
class RegistrationAction extends BaseAction
{
    private EntityManagerInterface $em;
    private UserPasswordEncoderInterface $passwordHasher;

    public function __construct(
        EntityManagerInterface $em,
        UserPasswordEncoderInterface $passwordHasher
    )
    {
        $this->passwordHasher = $passwordHasher;
        $this->em = $em;
    }

    /**
     * @Route("/api/v1/registration", methods={"POST"})
     * @OA\RequestBody(@Model(type=RegistrationRequest::class))
     * @OA\Response(response=201, description="created", @Model(type=RegistrationSuccessResponse::class))
     * @OA\Response(response=400, description="validation error", @Model(type=ValidationErrorResponseRef::class))
     * @OA\Response(response=422, description="user already exists", @Model(type=RegistrationErrorResponseRef::class))
     * @OA\Response(response=500, description="server error", @Model(type=ServerErrorRef::class))
     */
    public function __invoke(
        RegistrationRequest $request,
        Request $httpRequest
    ): HttpOutputInterface
    {
        $userPassword = new UserPassword($request->password, $this->passwordHasher);

        $newUser = new User(
            $request->email,
            $userPassword,
        );

        $this->em->persist($newUser);

        try {
            $this->em->flush();
        } catch (UniqueConstraintViolationException $e) {
            return $this->error('already_exists');
        }

        return new RegistrationSuccessResponse($newUser->getId());
    }
}
