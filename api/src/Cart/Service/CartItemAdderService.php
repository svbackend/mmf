<?php

namespace App\Cart\Service;

use App\Cart\Entity\Cart;
use App\Cart\Entity\CartItem;
use App\Cart\Repository\CartItemRepository;
use App\Product\Entity\Product;

class CartItemAdderService
{
    private CartItemRepository $cartItemRepository;

    public function __construct(
        CartItemRepository $cartItemRepository
    )
    {
        $this->cartItemRepository = $cartItemRepository;
    }

    public function addToCart(Cart $cart, Product $product, int $qty)
    {
        $cartItem = $this->cartItemRepository->findOneBy([
            'cart' => $cart,
            'product' => $product
        ]);

        if ($cartItem) {
            $cartItem->setQty($qty);
        } else {
            $cartItem = new CartItem($product, $cart, $qty);
        }

        $this->cartItemRepository->save($cartItem, true);
    }
}
