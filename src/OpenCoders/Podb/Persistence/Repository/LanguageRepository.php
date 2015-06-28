<?php

namespace OpenCoders\Podb\Persistence\Repository;

use OpenCoders\Podb\Persistence\Entity\Language;

class LanguageRepository extends EntityRepositoryAbstract
{

    /**
     * @return Language[]
     */
    public function getAll()
    {
        return $this->findAll();
    }

    /**
     * @param $id
     * @return null|Language
     */
    public function get($id)
    {
        return $this->find($id);
    }

    /**
     * @param $locale
     * @return null|Language
     */
    public function getByLocale($locale)
    {
        return $this->findOneBy(
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
                $language->setLabel($value);
            } else if ($key == 'locale') {
                $language->setLocale($value);
            }
        }

        $this->getEntityManager()->persist($language);

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
                $language->setLabel($value);
            } else if ($key == 'locale') {
                $language->setLocale($value);
            }
        }

        return $language;
    }
}