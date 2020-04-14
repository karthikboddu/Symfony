<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
        $this->em = $this->getEntityManager();
    }

    public function findByUsernameOrEmail(string $username): string
    {
        return $this->createQueryBuilder('u')
             ->where('u.username = :username OR u.email = :email')
             ->setParameter('username', $username)
             ->setParameter('email', $username)
             ->getQuery()
             ->getOneOrNullResult();
    }

    public function findUsersByRole($role)
    {
        $qb = $this->createQueryBuilder('u');
        $qb->select('u')
            ->where('u.roles LIKE :roles  ')
            ->setParameter('roles', '%"'.$role.'"%');

        return $qb->getQuery()->getArrayResult();
    }

    public function findByUsersActive($role){
        $query = $this->em->createQuery("SELECT u from App\Entity\User u  WHERE JSON_CONTAINS(u.roles, :u_role) ");
        $query->setParameter('u_role',$role);
        return $query->getArrayResult();
    }

    public function findByCountUers(){
        $query = $this->em->createQuery('SELECT count(u.id) as NoOfUsers from App\Entity\User u');
        return $query->getArrayResult();
    }


    public function DeleteUsers($u_id){
        $query = $this->em->createQuery("UPDATE App\Entity\User u SET u.active = '0' WHERE u.id = :u_id ");
        $query->setParameter('u_id',$u_id);
        return $query->getArrayResult();
    }

    public function findByFileUserId($u_id){
        $query1= $this->em->createQuery("SELECT u,pu,psf,pm FROM App\Entity\User u JOIN u.userMediaData pu LEFT join u.postuser pss JOIN pss.postfile psf  JOIN pu.fileuplodtype pm  WHERE  u.active ='1' AND u.id = :u_id  ");
        $query1->setParameter('u_id',$u_id);
        $users1 = $query1->getArrayResult();
        return $users1;
    }
   // SELECT * FROM `users` WHERE JSON_CONTAINS(roles, '["ROLE_USER"]')
}
