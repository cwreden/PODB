<?php

namespace OpenCoders\Podb\Persistence\Repository;

use OpenCoders\Podb\Exception\DeprecatedException;
use OpenCoders\Podb\Persistence\Entity\Message;

/**
 * Class MessageRepository
 * @package OpenCoders\Podb\Persistence\Repository
 */
class MessageRepository extends EntityRepositoryAbstract
{
    /**
     * @return Message[]
     */
    public function getAll()
    {
        return $this->findAll();
    }

    /**
     * @param $id
     * @return null|Message
     */
    public function get($id)
    {
        return $this->find($id);
    }

    /**
     * @param $attributes
     * @return Message
     * @throws MissingParameterException
     */
    public function create($attributes)
    {
        throw new DeprecatedException();
        $dataSet = new DataSet();

        if (!isset($attributes['category'])) {
            throw new MissingParameterException('category');
        } elseif (!isset($attributes['msgId'])) {
            throw new MissingParameterException('msgId');
        }

        foreach ($attributes as $key => $value) {
            if ($key == 'category') {
                $dataSet->setCategory($this->categoryService->get($value));
            } else if ($key == 'msgId') {
                $dataSet->setMsgId($value);
            }
        }

        $em = $this->getEntityManager();
        $em->persist($dataSet);

        return $dataSet;
    }

    /**
     * Update a DataSet
     *
     * @param $id
     * @param $attributes
     * @return null|Message
     */
    public function update($id, $attributes)
    {
        throw new DeprecatedException();
        $dataSet = $this->get($id);

        foreach ($attributes as $key => $value) {
            if ($key == 'category') {
                $dataSet->setCategory($this->categoryService->get($value));
            } else if ($key == 'msgId') {
                $dataSet->setMsgId($value);
            }
        }

        return $dataSet;
    }
}