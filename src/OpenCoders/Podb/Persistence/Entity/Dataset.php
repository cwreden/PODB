<?php

namespace OpenCoders\Podb\Persistence\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use OpenCoders\Podb\Exception\PodbException;

/**
 * Class DataSet
 * @package OpenCoders\Podb\Persistence\Entity
 * @Entity(repositoryClass="OpenCoders\Podb\Persistence\Repository\DataSetRepository")
 */
class DataSet extends AbstractBaseEntity
{
    // region attributes

    /**
     * @var
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;

    /**
     * @var
     * @ManyToOne(targetEntity="Category")
     * @JoinColumn(name="category_id", referencedColumnName="id")
     * @Column(nullable=false)
     */
    protected $category;

    /**
     * @var
     * @Column(type="string", nullable=false)
     */
    protected $msgId;

    /**
     * @var
     * @OneToMany(targetEntity="Translation", mappedBy="dataSet")
     */
    protected $dataSets;

    // endregion

    function __construct()
    {
        $this->dataSets = new ArrayCollection();
    }

    // region getter and setter

    /**
     * @throws \Exception
     */
    public function getCreateDate()
    {
        throw new \Exception('Not implemented!');
    }

    /**
     * @throws \Exception
     */
    public function getCreatedBy()
    {
        throw new \Exception('Not implemented!');
    }

    /**
     * @param string $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @throws \Exception
     */
    public function getLastUpdateBy()
    {
        throw new \Exception('Not implemented!');
    }

    /**
     * @throws \Exception
     */
    public function getLastUpdateDate()
    {
        throw new \Exception('Not implemented!');
    }

    /**
     * @param string $msgId
     */
    public function setMsgId($msgId)
    {
        $this->msgId = $msgId;
    }

    /**
     * @return string
     */
    public function getMsgId()
    {
        return $this->msgId;
    }

    // endregion

    /**
     * @return array
     */
    public function asArray()
    {
        return array(
            'id' => $this->getId(),
//            'categoryId' => $this->getCategoryId(),
            'msgId' => $this->getMsgId(),
//            'lastUpdatedDate' => $this->getLastUpdateDate(),
//            'lastUpdatedBy' => $this->getLastUpdateBy(),
//            'createdDate' => $this->getCreateDate(),
//            'createdBy' => $this->getCreatedBy(),
        );
    }

    /**
     * @return array
     */
    public function asShortArray()
    {
        return array(
            'id' => $this->getId(),
            'msgId' => $this->getMsgId(),
        );
    }

    public function getAPIInformation($apiVersion)
    {
        $apiBaseUrl = $this->getBaseAPIUrl();

        return array(
            '_links' => array(
                'self' => $apiBaseUrl . '/' . $apiVersion . '/datasets/' . $this->getId(),
                'translations' => $apiBaseUrl . '/' . $apiVersion . '/datasets/' . $this->getId() . '/translations',
            )
        );
    }

    public function update($data)
    {
        if ($data == null) {
            throw new PodbException('There is nothing to update.');
        }
        foreach ($data as $key => $value) {
            if ($key == 'msgId') {
                $this->setMsgId($value);
            }
        }
    }
}