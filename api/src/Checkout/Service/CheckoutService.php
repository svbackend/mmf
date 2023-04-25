<?php

namespace App\Checkout\Service;

use App\Cart\Repository\CartItemRepository;
use App\Cart\Repository\CartRepository;
use App\Checkout\Entity\Purchase;
use App\Checkout\Entity\PurchaseItem;
use App\Checkout\Exception\NotEnoughCreditsException;
use App\Checkout\Exception\NotEnoughStockException;
use App\Checkout\Repository\PurchaseItemRepository;
use App\Checkout\Repository\PurchaseRepository;
use App\User\Entity\User;
use App\User\ValueObject\CreditsValue;
use Doctrine\ORM\EntityManagerInterface;

class CheckoutService
{
    private EntityManagerInterface $em;
    private CartItemRepository $cartItemRepository;
    private CartRepository $cartRepository;
    private PurchaseItemRepository $purchaseItemRepository;
    private PurchaseRepository $purchaseRepository;

    public function __construct(EntityManagerInterface $em, CartItemRepository $cartItemRepository, CartRepository $cartRepository, PurchaseItemRepository $purchaseItemRepository, PurchaseRepository $purchaseRepository)
    {
        $this->em = $em;
        $this->cartItemRepository = $cartItemRepository;
        $this->cartRepository = $cartRepository;
        $this->purchaseItemRepository = $purchaseItemRepository;
        $this->purchaseRepository = $purchaseRepository;
    }


    /**
     * @throws NotEnoughCreditsException
     * @throws NotEnoughStockException
     */
    public function checkout(User $user)
    {
        $cart = $this->cartRepository->getCartByUser($user);
        $cartItems = $this->cartItemRepository->findItemsForCheckout($cart);

        $total = .0;
        foreach ($cartItems as $cartItem) {
            $total += $cartItem->getProduct()->getPrice() * $cartItem->getQty();

            if ($cartItem->getProduct()->getQty() < $cartItem->getQty()) {
                throw new NotEnoughStockException();
            }
        }

        $userCredits = (float)$user->getCredits();
        if ($total > $userCredits) {
            throw new NotEnoughCreditsException($total, $userCredits);
        }

        // Convert cart to purchase, and remove cart items
        $purchase = new Purchase($user);
        $this->purchaseRepository->save($purchase);

        foreach ($cartItems as $cartItem) {
            $purchaseItem = new PurchaseItem(
                $cartItem->getProduct(),
                $purchase,
                $cartItem->getQty()
            );

            $this->cartItemRepository->remove($cartItem);
            $this->purchaseItemRepository->save($purchaseItem);
        }

        $newCredits = new CreditsValue($userCredits - $total);
        $user->setCredits($newCredits);

        $this->em->flush();
    }
}
