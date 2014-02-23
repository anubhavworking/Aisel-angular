<?php

namespace Aisel\ConfigBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Exception;

/**
 * ConfigRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ConfigRepository extends EntityRepository
{

    /*
      * Get all settings
      *
      * @return int value
      * */

    public function getAllSettings()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $values = $qb->select('c.entity, c.value')
            ->from('AiselConfigBundle:Config', 'c')
            ->getQuery()
            ->execute();

        $config = array();
        foreach ($values as $k=>$v) {
            $config[$v['entity']] = $v['value'];
        }

        return $config;
    }

    public function getConfig($entity) {
        return $this->findOneBy(array('entity' => $entity));
    }

    public function setConfig($entity, $value)
    {
        $config = $this->getConfig($entity);

        if (!$config) {
            $config = new Config();
        }

        try {
            $config->setEntity($entity);
            $config->setValue($value);
            $this->_em->persist($config);
            $this->_em->flush();

        } catch(Exception $e) {
            throw new Exception($e);
        }

        return true;
    }
}
