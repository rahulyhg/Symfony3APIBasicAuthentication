<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function getUserByUsernameOrEmail($username)
    {
        return $this->createQueryBuilder('u')
             ->where('u.username = :username OR u.email = :email')
             ->setParameter('username', $username)
             ->setParameter('email', $username)
             ->getQuery()
             ->getOneOrNullResult();
    }
}
