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


        $query1= $this->em->createQuery("SELECT u,pu,pt,pf FROM App\Entity\User u JOIN u.postuser pu JOIN pu.posttag pt LEFt JOIN pu.postfile pf WHERE u.active = '1' AND pu.status = '1' ");
        $users1 = $query1->getArrayResult();
        return $users1;
    }


    public function findByAllUserHomePosts(){
        $query1= $this->em->createQuery("SELECT u,pu,pt,pf FROM App\Entity\User u JOIN u.postuser pu JOIN pu.posttag pt LEFt JOIN pu.postfile pf WHERE u.active = '1' AND pu.status = '1' ");
        $users1 = $query1->getScalarResult();
        return $users1;
    }
    
}
