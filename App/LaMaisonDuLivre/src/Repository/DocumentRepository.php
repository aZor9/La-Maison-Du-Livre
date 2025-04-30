<?php

namespace App\Repository;

use App\Entity\Document;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Document>
 *
 * @method Document|null find($id, $lockMode = null, $lockVersion = null)
 * @method Document|null findOneBy(array $criteria, array $orderBy = null)
 * @method Document[]    findAll()
 * @method Document[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Document::class);
    }

//    /**
//     * @return Document[] Returns an array of Document objects
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

//    public function findOneBySomeField($value): ?Document
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }



    /**
     * Recherche les documents selon un mot-clé et un type.
     */
    public function findBySearchAndType(string $search, string $type): array
    {
        $qb = $this->createQueryBuilder('d');
    
        if (!empty($search)) {
            $qb->andWhere('d.titre LIKE :search')
               ->setParameter('search', '%' . $search . '%');
        }
    
        if (!empty($type)) {
            // Utilisation de INSTANCE OF pour filtrer par type
            $qb->andWhere('d INSTANCE OF :type')
               ->setParameter('type', $this->mapTypeToClass($type));
        }
    
        return $qb->getQuery()->getResult();
    }
    
    /**
     * Mappe les types de documents à leurs classes correspondantes.
     */
    private function mapTypeToClass(string $type): string
    {
        return match ($type) {
            'livre' => \App\Entity\Livre::class,
            'video' => \App\Entity\Video::class,
            'sonore' => \App\Entity\Sonore::class,
            'titreperiodique' => \App\Entity\TitrePeriodique::class,
            default => \App\Entity\Document::class,
        };
    }

}
