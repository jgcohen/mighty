<?php

namespace App\Repository;

use App\Classe\Search;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */


    public function findOneBySlug($slug): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.slug = :val')
            ->setParameter('val', $slug)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Requete pour récuperer des produits en fonction de la recherche du User
     * @return Product[] Returns an array of Product objects
     */
    public function findWithSearch(Search $search)
    {
        return $this->createQueryBuilder('p')
             ->select('c','p')
            ->Join("p.category", "c")
            ->where("c.id in(:categories)")
            ->setParameter('categories', $search->categories)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult();
    }
}
