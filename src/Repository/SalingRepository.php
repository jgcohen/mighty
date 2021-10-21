<?php

namespace App\Repository;

use App\Entity\Saling;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Saling|null find($id, $lockMode = null, $lockVersion = null)
 * @method Saling|null findOneBy(array $criteria, array $orderBy = null)
 * @method Saling[]    findAll()
 * @method Saling[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Saling::class);
    }

    // /**
    //  * @return Saling[] Returns an array of Saling objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Saling
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
