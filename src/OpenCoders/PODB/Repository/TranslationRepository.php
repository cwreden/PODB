<?php

namespace OpenCoders\PODB\Repository;

use OpenCoders\PODB\Entity\Translation;

class TranslationRepository extends Repository
{
    /**
     * @var string
     */
    protected $entityClass = 'PODB\Entity\Translation';

    /**
     * @return Translation[]
     */
    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @param Translation $entity
     * @return integer
     */
    public function create(Translation $entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);
        return $entity->getId();
    }

    /**
     * @param Translation $entity
     */
    public function update(Translation $entity)
    {
        $this->getEntityManager()->flush($entity);
    }

    /**
     * @param $id
     * @return Translation
     */
    public function get($id)
    {
        return $this->getRepository()->find($id);
    }
}