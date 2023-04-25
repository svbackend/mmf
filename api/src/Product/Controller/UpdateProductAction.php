<?php

namespace App\Product\Controller;

use App\User\Entity\User;
use App\Common\Controller\BaseAction;
use App\Common\Http\Response\HttpOutputInterface;
use App\Common\OpenApi\Ref\ServerErrorRef;
use App\Common\OpenApi\Ref\ValidationErrorResponseRef;
use App\Product\Http\Request\UpdateProductRequest;
use App\Product\Repository\ProductRepository;
use App\Product\Security\Voter\ProductVoter;
use App\Product\ValueObject\PriceValue;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @OA\Tag(name="Product")
 */
class UpdateProductAction extends BaseAction
{
    private ProductRepository $productRepository;

    public function __construct(
        ProductRepository $productRepository
    )
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/api/v1/products/{id}", methods={"PUT"})
     * @OA\RequestBody(@Model(type=UpdateProductRequest::class))
     * @OA\Response(response=200, description="updated")
     * @OA\Response(response=400, description="validation error", @Model(type=ValidationErrorResponseRef::class))
     * @OA\Response(response=404, description="product not found")
     * @OA\Response(response=500, description="server error", @Model(type=ServerErrorRef::class))
     * @Security(name="ApiToken")
     */
    public function __invoke(
        int $id,
        UpdateProductRequest $request
    ): HttpOutputInterface
    {
        $this->denyAccessUnlessGranted(User::ROLE_ADMIN);

        $product = $this->productRepository->findOneById($id);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        $this->denyAccessUnlessGranted(ProductVoter::EDIT, $product);

        $product->update(
            $request->name,
            $request->description,
            $request->quantity,
            new PriceValue($request->price)
        );

        $this->productRepository->save($product, true);

        return $this->success();
    }
}
