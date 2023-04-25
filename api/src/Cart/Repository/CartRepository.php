<?php

namespace App\Cart\Repository;

use App\Cart\CartWithProductsDto;
use App\Cart\DTO\CartItemDto;
use App\Cart\DTO\CartWithItemsDto;
use App\Cart\Entity\Cart;
use App\Cart\Entity\CartItem;
use App\Product\Entity\Product;
use App\User\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cart>
 *
 * @method Cart|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cart|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cart[]    findAll()
 * @method Cart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    public function save(Cart $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Cart $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function getCartByUser(User $user): Cart
    {
        $cart = $this->findOneBy(['owner' => $user]);

        if (!$cart) {
            $cart = new Cart($user);
            $this->save($cart, true);
        }

        return $cart;
    }

    public function getCartWithItems(User $user): CartWithItemsDto
    {
        $cart = $this->getCartByUser($user);
        $cartItems = $this->findItemsByCart($cart);

        return new CartWithItemsDto(
            array_map(fn (CartItem $cartItem) => CartItemDto::fromCartItem($cartItem), $cartItems),
            $cart->getUpdatedAt()
        );
    }

    /** @return CartItem[] */
    private function findItemsByCart(Cart $cart): array
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('ci')
            ->from(CartItem::class, 'ci')
            ->innerJoin('ci.product', 'p')
            ->addSelect('p')
            ->where('ci.cart = :cart')
            ->setParameter('cart', $cart)
            ->getQuery()
            ->getResult();
    }
}
