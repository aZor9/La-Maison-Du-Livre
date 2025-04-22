<?php

namespace App\Repository;

use App\Entity\Empruntexemplaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Empruntexemplaire>
 *
 * @method Empruntexemplaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Empruntexemplaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Empruntexemplaire[]    findAll()
 * @method Empruntexemplaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmpruntexemplaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Empruntexemplaire::class);
    }

//    /**
//     * @return Empruntexemplaire[] Returns an array of Empruntexemplaire objects
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

//    public function findOneBySomeField($value): ?Empruntexemplaire
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
