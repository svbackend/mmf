<?php

namespace App\Product\Controller;

use App\User\Entity\User;
use App\Common\Controller\BaseAction;
use App\Common\Http\Response\HttpOutputInterface;
use App\Common\OpenApi\Ref\ServerErrorRef;
use App\Product\Repository\ProductRepository;
use App\Product\Security\Voter\ProductVoter;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @OA\Tag(name="Product")
 */
class DeleteProductAction extends BaseAction
{
    private ProductRepository $productRepository;

    public function __construct(
        ProductRepository $productRepository
    )
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/api/v1/products/{id}", methods={"DELETE"})
     * @OA\Response(response=204, description="product deleted")
     * @OA\Response(response=500, description="server error", @Model(type=ServerErrorRef::class))
     * @Security(name="ApiToken")
     */
    public function __invoke(int $id): HttpOutputInterface
    {
        $this->denyAccessUnlessGranted(User::ROLE_ADMIN);

        $product = $this->productRepository->findOneById($id);

        if (!$product) {
            return $this->success();
        }

        $this->denyAccessUnlessGranted(ProductVoter::DELETE, $product);

        $product->delete();
        $this->productRepository->save($product, true);

        return $this->success();
    }
}
