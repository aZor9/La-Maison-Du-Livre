<?php

namespace App\Repository;

use App\Entity\Titreperiodique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Titreperiodique>
 *
 * @method Titreperiodique|null find($id, $lockMode = null, $lockVersion = null)
 * @method Titreperiodique|null findOneBy(array $criteria, array $orderBy = null)
 * @method Titreperiodique[]    findAll()
 * @method Titreperiodique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TitreperiodiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Titreperiodique::class);
    }

//    /**
//     * @return Titreperiodique[] Returns an array of Titreperiodique objects
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

//    public function findOneBySomeField($value): ?Titreperiodique
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
