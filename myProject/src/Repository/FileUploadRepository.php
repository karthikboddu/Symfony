<?php

namespace App\Repository;

use App\Entity\FileUpload;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FileUpload|null find($id, $lockMode = null, $lockVersion = null)
 * @method FileUpload|null findOneBy(array $criteria, array $orderBy = null)
 * @method FileUpload[]    findAll()
 * @method FileUpload[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FileUploadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FileUpload::class);
        $this->em = $this->getEntityManager();
    }

    // /**
    //  * @return FileUpload[] Returns an array of FileUpload objects
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
    public function findOneBySomeField($value): ?FileUpload
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByUploadDetailsById($id){

        $query1= $this->em->createQuery("SELECT fileupload,fut,futn FROM App\Entity\FileUpload fileupload  join fileupload.fileuplodtype fut join fut.MediaUploadName futn WHERE fileupload.status = '1' AND fileupload.id IN (:id) ");
        $query1->setParameter('id',$id);
        $users1 = $query1->getScalarResult();
        return $users1;
    }

    public function findByUploadDetailsByTypeId($id){

        $query1= $this->em->createQuery("SELECT fileupload,fut FROM App\Entity\FileUpload fileupload  join fileupload.fileuplodtype fut WHERE fileupload.status = '1' AND fileupload.fileuplodtype IN (:id) ");
        $query1->setParameter('id',$id);
        $users1 = $query1->getScalarResult();
        return $users1;
    }

    public function findByMediaUploadData($id,$type)
    {
        if($type=="uploaded"){
            $mediaTypeSql= $this->em->createQuery("SELECT FU,FUT FROM App\Entity\FileUpload FU  join FU.fileuplodtype FUT WHERE FU.status = '1' AND FU.id IN (:id) ");
        }else{
            $mediaTypeSql= $this->em->createQuery("SELECT FU,FUT FROM App\Entity\FileUpload FU  join FU.fileuplodtype FUT WHERE FU.status = '1' AND FU.id NOT IN (:id) ");
        }
        
        $mediaTypeSql->setParameter('id',$id);
        $users1 = $mediaTypeSql->getScalarResult();
        return $users1;    
    }
}
