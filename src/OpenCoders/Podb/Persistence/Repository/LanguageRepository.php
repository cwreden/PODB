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
}