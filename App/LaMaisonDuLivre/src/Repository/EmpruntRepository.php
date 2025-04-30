<?php

namespace App\Repository;

use App\Entity\Emprunt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Emprunt>
 *
 * @method Emprunt|null find($id, $lockMode = null, $lockVersion = null)
 * @method Emprunt|null findOneBy(array $criteria, array $orderBy = null)
 * @method Emprunt[]    findAll()
 * @method Emprunt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmpruntRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emprunt::class);
    }

//    /**
//     * @return Emprunt[] Returns an array of Emprunt objects
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

//    public function findOneBySomeField($value): ?Emprunt
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function countActiveReservationsByUser(int $userId): int
    {
        return (int) $this->createQueryBuilder('e')
            ->select('COUNT(e.IdEmprunt)') // Use the correct primary key field
            ->join('e.empruntexemplaires', 'ee') // Jointure avec Empruntexemplaire
            ->join('ee.exemplaire', 'ex') // Jointure avec Exemplaire
            ->where('e.utilisateur = :userId')
            ->andWhere('ex.Statut != :statut') // Vérifie que l'exemplaire n'est pas disponible
            ->setParameter('userId', $userId)
            ->setParameter('statut', 'disponible')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
