<?php

namespace OpenCoders\PODB\Repository;

use OpenCoders\PODB\Entity\Language;

class LanguageRepository extends Repository
{
    protected $entityClass = 'PODB\Entity\Language';

    /**
     * @return Language[]
     */
    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @param Language $entity
     * @return integer
     */
    public function create(Language $entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);
        return $entity->getId();
    }

    /**
     * @param Language $entity
     */
    public function update(Language $entity)
    {
        $this->getEntityManager()->flush($entity);
    }

    /**
     * @param $id
     * @return Language
     */
    public function get($id)
    {
        return $this->getRepository()->find($id);
    }
}