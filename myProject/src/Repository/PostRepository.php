<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;


/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
        $this->em = $this->getEntityManager();
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.postuser = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findByUsersRoles(){
        // $query = $this->em->createQuery("SELECT p,pt,pf FROM App\Entity\Post p JOIN p.posttag pt left JOIN p.postfile pf");
        // $users = $query->getArrayResult();


        $query1= $this->em->createQuery("SELECT u,pu,pt,pf FROM App\Entity\User u JOIN u.postuser pu JOIN pu.posttag pt LEFt JOIN pu.postfile pf WHERE  pu.status = '1' AND u.active ='1' ");
        
        $users1 = $query1->getScalarResult();
        return $users1;
    }

    public function findByPostsById($id){
        // $query = $this->em->createQuery("SELECT p,pt,pf FROM App\Entity\Post p JOIN p.posttag pt left JOIN p.postfile pf");
        // $users = $query->getArrayResult();


        $query1= $this->em->createQuery("SELECT p FROM App\Entity\Post p  WHERE  p.status = '1' AND p.postuser = :id ");
        $query1->setParameter('id',$id);
        $users1 = $query1->getScalarResult();
        return $users1;
    }

    public function findByPostsByPostId($id){

        // $query1= $this->em->createQuery("SELECT p FROM App\Entity\Post p  WHERE  p.status = '1' AND p.id = :id ");
        // $query1->setParameter('id',$id);
        // $users1 = $query1->getScalarResult();
        // return $users1;

        return $this->getEntityManager()
        ->createQuery("SELECT p FROM App\Entity\Post p  WHERE  p.status = '1' AND p.id = :id")
        ->setParameter('id',$id)
        ->setMaxResults(5)
        // ->setFirstResult(10)
        ->getScalarResult();
    }


    public function findByAllUserHomePosts(){
        $query1= $this->em->createQuery("SELECT u,pu,pt,pf FROM App\Entity\User u JOIN u.postuser pu JOIN pu.posttag pt LEFt JOIN pu.postfile pf WHERE u.active = '1' AND pu.status = '1' ");
        $users1 = $query1->getScalarResult();
        return $users1;
    }

    public function findByTotalActivePosts(){
        $query = $this->em->createQuery("SELECT count(p.id) as totalposts from App\Entity\Post p  where p.status='1'");
        $totalPosts = $query->getScalarResult();
        return $totalPosts;
    }

    public function findByAdminAllPosts(){
        $query = $this->em->createQuery("SELECT p FROM App\Entity\Post p ");
        $totalPosts = $query->getScalarResult();
        return $totalPosts;
    }

    public function findByFileUpload(){

        $query1= $this->em->createQuery("SELECT u,pu,psf,pm FROM App\Entity\User u JOIN u.userMediaData pu LEFT join u.postuser pss JOIN pss.postfile psf  JOIN pu.fileuplodtype pm  WHERE  u.active ='1' ");
        
        $users1 = $query1->getArrayResult();
        return $users1;
    }

    public function findByAllPostsActive(){
        $query = $this->em->createQuery("SELECT p.id FROM App\Entity\Post p where p.status='1' ");
        $totalPosts = $query->getArrayResult();
        return $totalPosts;
    }

    public function findByAllPostsActiveUploadId($pid){
        $query = $this->em->createQuery("SELECT fp.id FROM App\Entity\UserPostUpload upu join upu.fk_post_id fp   where upu.fk_post_id IN (:pid)  ");
        $query->setParameter('pid',$pid);
        $totalPosts = $query->getScalarResult();
        return $totalPosts;
    }
    

    public function findByGroup($uid)
    {

        // return $this->createQueryBuilder('p')
   
        //     ->addSelect("GROUP_CONCAT( p.name SEPARATOR '; ') AS locationNames")
          
        //     ->getQuery()
        //     ->getArrayResult()
        // ;

        // $query = $this->em->createQuery("SELECT p,pfp,GROUP_CONCAT( pfu.id SEPARATOR ', ') AS locationNames FROM App\Entity\UserPostUpload p JOIN p.fk_upload_id pfu JOIN p.fk_post_id pfp group by p.fk_user_id");

         $query = $this->em->createQuery("SELECT p,pfp.id,GROUP_CONCAT( fu.id SEPARATOR ', ') AS locationNames FROM App\Entity\UserPostUpload p JOIN p.fk_post_id pfp left join p.fk_upload_id fu group by p.fk_post_id");


        $query = $this->em->createQuery("SELECT upu,fp,GROUP_CONCAT( fu.id SEPARATOR ', ') AS locationNames  FROM App\Entity\UserPostUpload upu JOIN upu.fk_post_id fp JOIN upu.fk_upload_id fu where fp.id in (:uid) " );
        $query->setParameter('uid',$uid);
        $totalPosts = $query->getScalarResult();
        
        return $totalPosts;
    }

    public function findByGroupAll($limitId,$offsetId)
    {

        // $query = $this->em->createQuery("SELECT pfp.id as post_id,users.id AS user_id ,GROUP_CONCAT( fu.id SEPARATOR ', ') AS upload_id FROM App\Entity\UserPostUpload p JOIN p.fk_user_id users JOIN p.fk_post_id pfp left join p.fk_upload_id fu group by p.fk_post_id");
        // $totalPosts = $query->getScalarResult();
        
        // return $totalPosts;


        return $this->getEntityManager()
        ->createQuery("SELECT pfp.id as post_id,users.id AS user_id ,GROUP_CONCAT( fu.id SEPARATOR ', ') AS upload_id FROM App\Entity\UserPostUpload p JOIN p.fk_user_id users JOIN p.fk_post_id pfp left join p.fk_upload_id fu group by p.fk_post_id")
        ->setMaxResults($limitId)
         ->setFirstResult($offsetId)
        ->getScalarResult();
    }

    public function findByPostGroupByPid($pid)
    {

        // $query = $this->em->createQuery("SELECT pfp.id as post_id,users.id AS user_id ,GROUP_CONCAT( fu.id SEPARATOR ', ') AS upload_id FROM App\Entity\UserPostUpload p JOIN p.fk_user_id users JOIN p.fk_post_id pfp left join p.fk_upload_id fu group by p.fk_post_id");
        // $totalPosts = $query->getScalarResult();
        
        // return $totalPosts;


        return $this->getEntityManager()
        ->createQuery("SELECT pfp.id as post_id,users.id AS user_id ,GROUP_CONCAT( fu.id SEPARATOR ', ') AS upload_id FROM App\Entity\UserPostUpload p JOIN p.fk_user_id users JOIN p.fk_post_id pfp left join p.fk_upload_id fu where pfp=:pid group by p.fk_post_id")
         ->setParameter('pid',$pid)
        ->getScalarResult();
    }

    public function findByMediaDataByTypeId($id){
        // $query = $this->em->createQuery("SELECT p,pt,pf FROM App\Entity\Post p JOIN p.posttag pt left JOIN p.postfile pf");
        // $users = $query->getArrayResult();


        $query1= $this->em->createQuery("SELECT UMT.id FROM App\Entity\UploadMediaType UMT WHERE  UMT.MediaUploadName = :id  ");
        $query1->setParameter('id',$id);
        $users1 = $query1->getScalarResult();
        return $users1;
    }

}
