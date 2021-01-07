<?php

namespace Infrastructure\Repository;

use Doctrine\ORM\EntityRepository;
use Domain\User\Model\User;

class UserRepository extends EntityRepository
{
    /**
     * @return User|null
     */
    public function findAllOrderedBymail(): ?User
    {
        return $this->getEntityManager()
           ->createQuery(
           'SELECT p FROM Domain:User:Model:User u ORDER BY u.email ASC'
           )
           ->getResult();
   }

}