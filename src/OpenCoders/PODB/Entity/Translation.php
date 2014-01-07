<?php

namespace OpenCoders\PODB\Entity;

use DateTime;

/**
 * Class Translation
 * @package OpenCoders\PODB\Entity
 * @Entity
 */
class Translation
{

    /**
     * @var
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;

    /**
     * @var
     * @ManyToOne(targetEntity="DataSet")
     */
    protected $dataSetId;

    /**
     * @var
     * @ManyToOne(targetEntity="Language")
     */
    protected $languageId;

    /**
     * @var
     * @Column(type="string")
     */
    protected $msgStr;

    /**
     * @var
     * @Column(type="string")
     */
    protected $msgStr1;

    /**
     * @var
     * @Column(type="string")
     */
    protected $msgStr2;

    /**
     * @var
     * @Column(type="boolean")
     */
    protected $fuzzy;

    /**
     * @var
     * @ManyToOne(targetEntity="User")
     */
    protected $createdBy;

    /**
     * @var
     * @Column(type="datetime")
     */
    protected $createDate;

    /**
     * @var
     * @ManyToOne(targetEntity="User")
     */
    protected $lastUpdateBy;

    /**
     * @var
     * @Column(type="datetime")
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
     * @param string $dataSetId
     */
    public function setDataSetId($dataSetId)
    {
        $this->dataSetId = $dataSetId;
    }

    /**
     * @return string
     */
    public function getDataSetId()
    {
        return $this->dataSetId;
    }

    /**
     * @return array
     */
    public function asArray()
    {
        return array(
            'id' => $this->getId(),
            'dateSetId' => $this->getDataSetId(),
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