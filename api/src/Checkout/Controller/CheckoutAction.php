<?php

namespace App\Checkout\Controller;

use App\Checkout\Exception\NotEnoughCreditsException;
use App\Checkout\Exception\NotEnoughStockException;
use App\Checkout\Service\CheckoutService;
use App\Common\Controller\BaseAction;
use App\Common\Http\Response\HttpOutputInterface;
use App\Common\OpenApi\Ref\ServerErrorRef;
use App\Common\OpenApi\Ref\ValidationErrorResponseRef;
use App\User\Entity\User;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @OA\Tag(name="Checkout")
 */
class CheckoutAction extends BaseAction
{
    private CheckoutService $checkoutService;

    public function __construct(
        CheckoutService $checkoutService
    )
    {
        $this->checkoutService = $checkoutService;
    }

    /**
     * @Route("/api/v1/checkout", methods={"POST"})
     * @OA\Response(response=201, description="created")
     * @OA\Response(response=400, description="validation error", @Model(type=ValidationErrorResponseRef::class))
     * @OA\Response(response=500, description="server error", @Model(type=ServerErrorRef::class))
     * @Security(name="ApiToken")
     */
    public function __invoke(): HttpOutputInterface
    {
        $this->denyAccessUnlessGranted(User::ROLE_USER);

        /** @var User $user */
        $user = $this->getUser();

        try {
            $this->checkoutService->checkout($user);
        } catch (NotEnoughCreditsException $notEnoughCredits) {
            return $this->error('not_enough_credits');
        } catch (NotEnoughStockException $notEnoughStock) {
            return $this->error('not_enough_stock');
        }

        return $this->success();
    }
}
