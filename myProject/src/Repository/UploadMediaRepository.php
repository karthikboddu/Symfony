<?php

namespace App\Repository;

use App\Entity\UploadMedia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UploadMedia|null find($id, $lockMode = null, $lockVersion = null)
 * @method UploadMedia|null findOneBy(array $criteria, array $orderBy = null)
 * @method UploadMedia[]    findAll()
 * @method UploadMedia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UploadMediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UploadMedia::class);
        $this->em = $this->getEntityManager();
    }

    // /**
    //  * @return UploadMedia[] Returns an array of UploadMedia objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UploadMedia
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByMediaTypes(){

        $query1= $this->em->createQuery("SELECT mt FROM App\Entity\UploadMedia mt  ");
        $users1 = $query1->getScalarResult();
        return $users1;
    }
}
