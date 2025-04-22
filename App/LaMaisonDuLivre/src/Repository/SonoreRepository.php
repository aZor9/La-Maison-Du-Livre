<?php

namespace App\Repository;

use App\Entity\Sonore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sonore>
 *
 * @method Sonore|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sonore|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sonore[]    findAll()
 * @method Sonore[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SonoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sonore::class);
    }

//    /**
//     * @return Sonore[] Returns an array of Sonore objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Sonore
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
