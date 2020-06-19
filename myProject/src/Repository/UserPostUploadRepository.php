<?php

namespace App\Repository;

use App\Entity\UserPostUpload;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserPostUpload|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserPostUpload|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserPostUpload[]    findAll()
 * @method UserPostUpload[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserPostUploadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserPostUpload::class);
        $this->em = $this->getEntityManager();
    }

    // /**
    //  * @return UserPostUpload[] Returns an array of UserPostUpload objects
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
    public function findOneBySomeField($value): ?UserPostUpload
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function findByAllActiveUploadId(){
        $query = $this->em->createQuery("SELECT pfp.id as post_id,users.id AS user_id ,GROUP_CONCAT( fu.id SEPARATOR ', ') AS upload_id FROM App\Entity\UserPostUpload p JOIN p.fk_user_id users JOIN p.fk_post_id pfp left join p.fk_upload_id fu group by p.fk_post_id  ");
        // $query->setParameter('pid',$pid);
        $uploadData = $query->getScalarResult();
        return $uploadData;
    }
    
}
