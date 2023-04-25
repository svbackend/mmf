<?php

namespace App\Product\Controller;

use App\Common\Controller\BaseAction;
use App\Common\Http\Response\HttpOutputInterface;
use App\Common\OpenApi\Ref\ServerErrorRef;
use App\Product\DTO\ViewProductDto;
use App\Product\Http\Response\ViewProductResponse;
use App\Product\Repository\ProductRepository;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @OA\Tag(name="Product")
 */
class ViewProductAction extends BaseAction
{
    private ProductRepository $productRepository;

    public function __construct(
        ProductRepository $productRepository
    )
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/api/v1/products/{id}", methods={"GET"})
     * @OA\Response(response=200, description="product details", @Model(type=ViewProductResponse::class))
     * @OA\Response(response=404, description="product not found")
     * @OA\Response(response=500, description="server error", @Model(type=ServerErrorRef::class))
     */
    public function __invoke(
        int $id
    ): HttpOutputInterface
    {
        $product = $this->productRepository->findOneById($id);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        return new ViewProductResponse(
            ViewProductDto::fromProduct($product)
        );
    }
}
