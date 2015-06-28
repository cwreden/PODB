<?php

namespace OpenCoders\Podb\Persistence\Repository;

use OpenCoders\Podb\Exception\DeprecatedException;
use OpenCoders\Podb\Exception\MissingParameterException;
use OpenCoders\Podb\Persistence\Entity\Translation;

class TranslationRepository extends EntityRepositoryAbstract
{

    /**
     * @return Translation[]
     */
    public function getAll()
    {
        return $this->findAll();
    }

    /**
     * @param $id
     * @return null|Translation
     */
    public function get($id)
    {
        return $this->find($id);
    }

    /**
     * @param $attributes
     * @return Translation
     * @throws MissingParameterException
     * @deprecated
     */
    public function create($attributes)
    {
        throw new DeprecatedException();
        $translation = new Translation();

        if (!isset($attributes['dataSet'])) {
            throw new MissingParameterException('dataSet');
        } elseif (!isset($attributes['language'])) {
            throw new MissingParameterException('language');
        } elseif (!isset($attributes['msgStr'])) {
            throw new MissingParameterException('msgStr');
        }

        foreach ($attributes as $key => $value) {
            if ($key === 'dataSet') {
                $translation->setMessage($this->dataSetService->get($value));
            } elseif ($key === 'language') {
                $translation->setLanguage($this->languageRepository->get($value));
            } elseif ($key === 'fuzzy') {
                $translation->setFuzzy($value);
            } else if ($key === 'msgStr') {
                $translation->setMsgStr($value);
            } else if ($key === 'msgStr1') {
                $translation->setMsgStr1($value);
            } else if ($key === 'msgStr2') {
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
     * @deprecated
     */
    public function update($id, $attributes)
    {
        throw new DeprecatedException();
        $translation = $this->get($id);

        foreach ($attributes as $key => $value) {
            if ($key === 'dataSet') {
                $translation->setMessage($this->dataSetService->get($value));
            } elseif ($key === 'language') {
                $translation->setLanguage($this->languageRepository->get($value));
            } elseif ($key === 'fuzzy') {
                $translation->setFuzzy($value);
            } else if ($key === 'msgStr') {
                $translation->setMsgStr($value);
            } else if ($key === 'msgStr1') {
                $translation->setMsgStr1($value);
            } else if ($key === 'msgStr2') {
                $translation->setMsgStr2($value);
            }
        }

        return $translation;
    }
}