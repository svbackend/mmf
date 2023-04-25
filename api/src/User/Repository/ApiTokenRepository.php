<?php

namespace App\User\Repository;

use App\User\Entity\ApiToken;
use App\User\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ApiToken>
 *
 * @method ApiToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApiToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApiToken[]    findAll()
 * @method ApiToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApiTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApiToken::class);
    }

    public function save(ApiToken $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ApiToken $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findUserByToken(string $apiToken): ?User
    {
        /** @var ApiToken|null $token */
        $token = $this->createQueryBuilder('t')
            ->innerJoin('t.user', 'u')
            ->andWhere('t.apiToken = :apiToken')
            ->setParameter('apiToken', $apiToken)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        if ($token instanceof ApiToken && $token->isValid()) {
            return $token->getUser();
        }

        return null;
    }
}
