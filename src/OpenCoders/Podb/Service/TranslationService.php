<?php

namespace OpenCoders\Podb\Service;


use Doctrine\ORM\EntityManager;
use OpenCoders\Podb\Exception\MissingParameterException;
use OpenCoders\Podb\Persistence\Entity\Translation;
use OpenCoders\Podb\Persistence\Repository\LanguageRepository;

class TranslationService extends BaseEntityService
{
    /**
     * @var string EntityClassName (FQN)
     */
    const ENTITY_NAME = 'OpenCoders\Podb\Persistence\Entity\Translation';

    /**
     * @var DataSetService
     */
    private $dataSetService;

    /**
     * @var LanguageRepository
     */
    private $languageRepository;

    function __construct(EntityManager $entityManager, DataSetService $dataSetService, LanguageRepository $languageRepository)
    {
        parent::__construct($entityManager, self::ENTITY_NAME);
        $this->dataSetService = $dataSetService;
        $this->languageRepository = $languageRepository;
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
     * @throws \OpenCoders\Podb\Exception\MissingParameterException
     * @return Translation
     */
    public function create($attributes)
    {
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
     */
    public function update($id, $attributes)
    {
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