<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
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

    public function findByUsersActive(){
        $query = $this->em->createQuery('SELECT u from App\Entity\User u');
        return $query->getArrayResult();
    }

    public function findByCountUers(){
        $query = $this->em->createQuery('SELECT count(u.id) as NoOfUsers from App\Entity\User u');
        return $query->getArrayResult();
    }
}
