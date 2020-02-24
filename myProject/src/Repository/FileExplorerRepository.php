<?php

namespace App\Repository;

use App\Entity\FileExplorer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FileExplorer|null find($id, $lockMode = null, $lockVersion = null)
 * @method FileExplorer|null findOneBy(array $criteria, array $orderBy = null)
 * @method FileExplorer[]    findAll()
 * @method FileExplorer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FileExplorerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FileExplorer::class);
    }

    // /**
    //  * @return FileExplorer[] Returns an array of FileExplorer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FileExplorer
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByFolderAll($limitId ,$offsetId)
    {

        // $query = $this->em->createQuery("SELECT pfp.id as post_id,users.id AS user_id ,GROUP_CONCAT( fu.id SEPARATOR ', ') AS upload_id FROM App\Entity\UserPostUpload p JOIN p.fk_user_id users JOIN p.fk_post_id pfp left join p.fk_upload_id fu group by p.fk_post_id");
        // $totalPosts = $query->getScalarResult();
        
        // return $totalPosts;


        return $this->getEntityManager()
        ->createQuery("SELECT pfp.id as post_id,users.id AS user_id ,GROUP_CONCAT( fu.id SEPARATOR ', ') AS upload_id , fk_folder.id as folder_id FROM App\Entity\UserPostUpload p JOIN p.fk_user_folder fk_folder JOIN p.fk_user_id users JOIN p.fk_post_id pfp left join p.fk_upload_id fu group by p.fk_user_folder")
        // ->setMaxResults($limitId)
        //  ->setFirstResult($offsetId)
        ->getScalarResult();
    }

    public function findByFoldersById($id){

        // $query1= $this->em->createQuery("SELECT p FROM App\Entity\Post p  WHERE  p.status = '1' AND p.id = :id ");
        // $query1->setParameter('id',$id);
        // $users1 = $query1->getScalarResult();
        // return $users1;

        return $this->getEntityManager()
        ->createQuery("SELECT f FROM App\Entity\FileExplorer f WHERE f.id = :id")
        ->setParameter('id',$id)
        ->setMaxResults(5)
        // ->setFirstResult(10)
        ->getScalarResult();
    }

}
