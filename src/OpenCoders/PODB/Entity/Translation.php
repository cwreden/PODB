<?php

namespace OpenCoders\PODB\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Translation
 * @package OpenCoders\PODB\Entity
 * @ORM\Entity
 */
class Translation extends BaseEntity
{

    /**
     * @var
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="PODataSet")
     */
    protected $poDataSetId;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Language")
     */
    protected $languageId;

    /**
     * @var
     * @ORM\Column(type="string")
     */
    protected $msgStr;

    /**
     * @var
     * @ORM\Column(type="string")
     */
    protected $msgStr1;

    /**
     * @var
     * @ORM\Column(type="string")
     */
    protected $msgStr2;

    /**
     * @var
     * @ORM\Column(type="boolean")
     */
    protected $fuzzy;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected $createdBy;

    /**
     * @var
     * @ORM\Column(type="datetime")
     */
    protected $createDate;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected $lastUpdateBy;

    /**
     * @var
     * @ORM\Column(type="datetime")
     */
    protected $lastUpdateDate;

    /**
     * @param DateTime $createDate
     */
    public function setCreateDate(DateTime $createDate)
    {
        $this->createDate = $createDate ? clone $createDate : null;
    }

    /**
     * @return DateTime|null
     */
    public function getCreateDate()
    {
        return $this->createDate ? clone $this->createDate : null;
    }

    /**
     * @param string $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param boolean $useFuzzy
     */
    public function setFuzzy($useFuzzy)
    {
        $this->fuzzy = (boolean) $useFuzzy;
    }

    /**
     * @return boolean
     */
    public function getFuzzy()
    {
        return (boolean) $this->fuzzy;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $languageId
     */
    public function setLanguageId($languageId)
    {
        $this->languageId = $languageId;
    }

    /**
     * @return string
     */
    public function getLanguageId()
    {
        return $this->languageId;
    }

    /**
     * @param string $lastUpdateBy
     */
    public function setLastUpdateBy($lastUpdateBy)
    {
        $this->lastUpdateBy = $lastUpdateBy;
    }

    /**
     * @return string
     */
    public function getLastUpdateBy()
    {
        return $this->lastUpdateBy;
    }

    /**
     * @param DateTime $lastUpdateDate
     */
    public function setLastUpdateDate(DateTime $lastUpdateDate)
    {
        $this->lastUpdateDate = $lastUpdateDate ? clone $lastUpdateDate : null;
    }

    /**
     * @return DateTime|null
     */
    public function getLastUpdateDate()
    {
        return $this->lastUpdateDate ? clone $this->lastUpdateDate : null;
    }

    /**
     * @param string $msgStr
     */
    public function setMsgStr($msgStr)
    {
        $this->msgStr = $msgStr;
    }

    /**
     * @return string
     */
    public function getMsgStr()
    {
        return $this->msgStr;
    }

    /**
     * @param string $msgStr1
     */
    public function setMsgStr1($msgStr1)
    {
        $this->msgStr1 = $msgStr1;
    }

    /**
     * @return string
     */
    public function getMsgStr1()
    {
        return $this->msgStr1;
    }

    /**
     * @param string $msgStr2
     */
    public function setMsgStr2($msgStr2)
    {
        $this->msgStr2 = $msgStr2;
    }

    /**
     * @return string
     */
    public function getMsgStr2()
    {
        return $this->msgStr2;
    }

    /**
     * @param string $poDataSetId
     */
    public function setPoDataSetId($poDataSetId)
    {
        $this->poDataSetId = $poDataSetId;
    }

    /**
     * @return string
     */
    public function getPoDataSetId()
    {
        return $this->poDataSetId;
    }

    /**
     * @return array
     */
    public function asArray()
    {
        return array(
            'id' => $this->getId(),
            'poDateSetId' => $this->getPoDataSetId(),
            'languageId' => $this->getLanguageId(),
            'msgStr' => $this->getMsgStr(),
            'msgStr1' => $this->getMsgStr1(),
            'msgStr2' => $this->getMsgStr2(),
            'fuzzy' => $this->getFuzzy(),
            'lastUpdatedDate' => $this->getLastUpdateDate(),
            'lastUpdatedBy' => $this->getLastUpdateBy(),
            'createdDate' => $this->getCreateDate(),
            'createdBy' => $this->getCreatedBy(),
        );
    }

    /**
     * @return array
     */
    public function asShortArray()
    {
        return array(
            'id' => $this->getId(),
            'msgStr' => $this->getMsgStr(),
        );
    }

} 