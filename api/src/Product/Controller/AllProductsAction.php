<?php

namespace App\Product\Controller;

use App\Common\Controller\BaseAction;
use App\Common\Http\Response\HttpOutputInterface;
use App\Common\OpenApi\Ref\ServerErrorRef;
use App\Product\DTO\ViewProductDto;
use App\Product\Http\Response\AllProductsResponse;
use App\Product\Http\Response\ViewProductResponse;
use App\Product\Repository\ProductRepository;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @OA\Tag(name="Product")
 */
class AllProductsAction extends BaseAction
{
    private ProductRepository $productRepository;

    public function __construct(
        ProductRepository $productRepository
    )
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/api/v1/products", methods={"GET"})
     * @OA\Response(response=200, description="List of all products", @Model(type=AllProductsResponse::class))
     * @OA\Response(response=500, description="Server error", @Model(type=ServerErrorRef::class))
     */
    public function __invoke(): HttpOutputInterface
    {
        $products = $this->productRepository->findAll();

        $viewProductDtos = array_map(function ($product) {
            return ViewProductDto::fromProduct($product);
        }, $products);

        return new AllProductsResponse($viewProductDtos);
    }
}
