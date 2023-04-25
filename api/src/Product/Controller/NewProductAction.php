<?php

namespace App\Product\Controller;

use App\User\Entity\User;
use App\Common\Controller\BaseAction;
use App\Common\Http\Response\HttpOutputInterface;
use App\Common\OpenApi\Ref\ServerErrorRef;
use App\Common\OpenApi\Ref\ValidationErrorResponseRef;
use App\Product\Entity\Product;
use App\Product\Http\Request\NewProductRequest;
use App\Product\Http\Response\NewProductSuccessResponse;
use App\Product\Repository\ProductRepository;
use App\Product\ValueObject\PriceValue;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @OA\Tag(name="Product")
 */
class NewProductAction extends BaseAction
{
    private ProductRepository $productRepository;

    public function __construct(
        ProductRepository $productRepository
    )
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/api/v1/products", methods={"POST"})
     * @OA\RequestBody(@Model(type=NewProductRequest::class))
     * @OA\Response(response=201, description="created", @Model(type=NewProductSuccessResponse::class))
     * @OA\Response(response=400, description="validation error", @Model(type=ValidationErrorResponseRef::class))
     * @OA\Response(response=500, description="server error", @Model(type=ServerErrorRef::class))
     * @Security(name="ApiToken")
     */
    public function __invoke(
        NewProductRequest $request
    ): HttpOutputInterface
    {
        $this->denyAccessUnlessGranted(User::ROLE_ADMIN);

        /** @var User $admin */
        $admin = $this->getUser();

        $price = new PriceValue($request->price);

        $newProduct = new Product(
            $request->name,
            $request->description,
            $request->quantity,
            $price,
            $admin
        );

        $this->productRepository->save($newProduct, true);

        return new NewProductSuccessResponse($newProduct->getId());
    }
}
