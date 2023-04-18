<?php

namespace App\Repository;

use App\Entity\ShoppingSharingUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ShoppingSharingUser>
 *
 * @method ShoppingSharingUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShoppingSharingUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShoppingSharingUser[]    findAll()
 * @method ShoppingSharingUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShoppingSharingUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShoppingSharingUser::class);
    }

    public function save(ShoppingSharingUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ShoppingSharingUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ShoppingSharingUser[] Returns an array of ShoppingSharingUser objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ShoppingSharingUser
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
