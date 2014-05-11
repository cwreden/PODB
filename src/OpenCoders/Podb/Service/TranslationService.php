<?php

namespace OpenCoders\Podb\Service;


use Doctrine\ORM\EntityManager;
use OpenCoders\Podb\Persistence\Entity\Translation;

class TranslationService extends BaseEntityService
{
    /**
     * @var string EntityClassName (FQN)
     */
    const ENTITY_NAME = 'OpenCoders\Podb\Persistence\Entity\Translation';

    function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, self::ENTITY_NAME);
    }

    /**
     * @return Translation[]
     */
    public function getAll()
    {
        $repository = $this->getRepository();
        return $repository->findAll();
    }

    /**
     * @param $id
     * @return null|Translation
     */
    public function get($id)
    {
        $repository = $this->getRepository();
        return $repository->find($id);
    }

    /**
     * @param $attributes
     * @return Translation
     */
    public function create($attributes)
    {
        $translation = new Translation();

        foreach ($attributes as $key => $value) {
            if ($key == 'fuzzy') {
                $translation->setFuzzy($value);
            } else if ($key == 'msgStr') {
                $translation->setMsgStr($value);
            } else if ($key == 'msgStr1') {
                $translation->setMsgStr1($value);
            } else if ($key == 'msgStr2') {
                $translation->setMsgStr2($value);
            }
        }

        $em = $this->getEntityManager();
        $em->persist($translation);

        return $translation;
    }

    /**
     * Update translation
     *
     * @param $id
     * @param $attributes
     * @return null|Translation
     */
    public function update($id, $attributes)
    {
        $translation = $this->get($id);

        foreach ($attributes as $key => $value) {
            if ($key == 'fuzzy') {
                $translation->setFuzzy($value);
            } else if ($key == 'msgStr') {
                $translation->setMsgStr($value);
            } else if ($key == 'msgStr1') {
                $translation->setMsgStr1($value);
            } else if ($key == 'msgStr2') {
                $translation->setMsgStr2($value);
            }
        }

        return $translation;
    }
}