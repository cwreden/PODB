<?php

namespace OpenCoders\Podb\Service;


use Doctrine\ORM\EntityManager;
use OpenCoders\Podb\Persistence\Entity\Language;

class LanguageService extends BaseEntityService
{
    /**
     * @var string EntityClassName (FQN)
     */
    const ENTITY_NAME = 'OpenCoders\Podb\Persistence\Entity\Language';

    function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, self::ENTITY_NAME);
    }

    /**
     * @return Language[]
     */
    public function getAll()
    {
        $repository = $this->getRepository();
        return $repository->findAll();
    }

    /**
     * @param $id
     * @return null|Language
     */
    public function get($id)
    {
        $repository = $this->getRepository();
        return $repository->find($id);
    }

    /**
     * @param $locale
     * @return null|Language
     */
    public function getByLocale($locale)
    {
        $repository = $this->getRepository();
        return $repository->findOneBy(
            array(
                'locale' => $locale
            )
        );
    }

    /**
     * @param $attributes
     * @return Language
     */
    public function create($attributes)
    {
        $language = new Language();

        foreach ($attributes as $key => $value) {
            if ($key == 'name') {
                $language->setName($value);
            } else if ($key == 'locale') {
                $language->setLocale($value);
            }
        }

        $em = $this->getEntityManager();
        $em->persist($language);

        return $language;
    }

    /**
     * Update language
     *
     * @param $id
     * @param $attributes
     * @return null|Language
     */
    public function update($id, $attributes)
    {
        $language = $this->get($id);

        foreach ($attributes as $key => $value) {
            if ($key == 'name') {
                $language->setName($value);
            } else if ($key == 'locale') {
                $language->setLocale($value);
            }
        }

        return $language;
    }
}