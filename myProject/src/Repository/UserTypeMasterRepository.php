<?php

namespace App\Repository;

use App\Entity\UserTypeMaster;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserTypeMaster|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserTypeMaster|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserTypeMaster[]    findAll()
 * @method UserTypeMaster[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserTypeMasterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserTypeMaster::class);
    }

    // /**
    //  * @return UserTypeMaster[] Returns an array of UserTypeMaster objects
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
    public function findOneBySomeField($value): ?UserTypeMaster
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
