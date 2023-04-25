<?php

namespace App\Cart\Controller;

use App\Cart\Http\Response\ViewCartResponse;
use App\Cart\Repository\CartRepository;
use App\Common\Controller\BaseAction;
use App\Common\Http\Response\HttpOutputInterface;
use App\Common\OpenApi\Ref\ServerErrorRef;
use App\User\Entity\User;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @OA\Tag(name="Cart")
 */
class ViewCartAction extends BaseAction
{
    private CartRepository $cartRepository;

    public function __construct(
        CartRepository $cartRepository
    )
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * @Route("/api/v1/cart", methods={"GET"})
     * @OA\Response(response=200, description="cart with products", @Model(type=ViewCartResponse::class))
     * @OA\Response(response=404, description="product not found")
     * @OA\Response(response=500, description="server error", @Model(type=ServerErrorRef::class))
     */
    public function __invoke(): HttpOutputInterface
    {
        $this->denyAccessUnlessGranted(User::ROLE_USER);

        /** @var User $user */
        $user = $this->getUser();
        $cartWithProductsDto = $this->cartRepository->getCartWithItems($user);

        return new ViewCartResponse($cartWithProductsDto);
    }
}
