<?php

namespace App\Repository;

use App\Entity\CarouselImages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CarouselImages|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarouselImages|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarouselImages[]    findAll()
 * @method CarouselImages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarouselImagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarouselImages::class);
    }

    // /**
    //  * @return CarouselImages[] Returns an array of CarouselImages objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CarouselImages
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
