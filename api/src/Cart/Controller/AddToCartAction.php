<?php

namespace App\Cart\Controller;

use App\Cart\Http\Request\AddToCartRequest;
use App\Cart\Repository\CartRepository;
use App\Cart\Service\CartItemAdderService;
use App\Common\Controller\BaseAction;
use App\Common\Http\Response\HttpOutputInterface;
use App\Common\OpenApi\Ref\ServerErrorRef;
use App\Common\OpenApi\Ref\ValidationErrorResponseRef;
use App\Product\Repository\ProductRepository;
use App\User\Entity\User;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @OA\Tag(name="Cart")
 */
class AddToCartAction extends BaseAction
{
    private CartRepository $cartRepository;
    private ProductRepository $productRepository;
    private CartItemAdderService $cartItemAdderService;

    public function __construct(
        CartRepository $cartRepository,
        ProductRepository $productRepository,
        CartItemAdderService $cartItemAdderService
    )
    {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
        $this->cartItemAdderService = $cartItemAdderService;
    }

    /**
     * @Route("/api/v1/cart", methods={"POST"})
     * @OA\RequestBody(@Model(type=AddToCartRequest::class))
     * @OA\Response(response=201, description="created")
     * @OA\Response(response=400, description="validation error", @Model(type=ValidationErrorResponseRef::class))
     * @OA\Response(response=500, description="server error", @Model(type=ServerErrorRef::class))
     * @Security(name="ApiToken")
     */
    public function __invoke(
        AddToCartRequest $request
    ): HttpOutputInterface
    {
        $this->denyAccessUnlessGranted(User::ROLE_USER);

        /** @var User $user */
        $user = $this->getUser();

        $cart = $this->cartRepository->getCartByUser($user);
        $product = $this->productRepository->find($request->productId);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        if ($product->getQty() < $request->qty) {
            return $this->error('qty_too_big');
        }

        $this->cartItemAdderService->addToCart($cart, $product, $request->qty);

        return $this->success();
    }
}
