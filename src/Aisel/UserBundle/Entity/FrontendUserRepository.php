<?php

namespace Aisel\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * Frontend user repository
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class FrontendUserRepository extends EntityRepository
{

    /*
     * Find user by Username and Password
     *
     * @return int value
     * */

    public function findUser($username, $email)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('COUNT(u.id)')
            ->from('AiselUserBundle:FrontendUser', 'u')
            ->where('u.username = :username')
            ->orWhere('u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $email);

        $r = $qb->getQuery()->getSingleScalarResult();

        return $r;
    }

}
