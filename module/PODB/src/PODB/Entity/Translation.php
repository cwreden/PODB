<?php

namespace PODB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Translation
 * @package PODB\Entity
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

    protected $createDate;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected $lastUpdateBy;

    protected $lastUpdateDate;

    /**
     * @param mixed $createDate
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;
    }

    /**
     * @return mixed
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * @param mixed $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param mixed $fuzzy
     */
    public function setFuzzy($fuzzy)
    {
        $this->fuzzy = $fuzzy;
    }

    /**
     * @return mixed
     */
    public function getFuzzy()
    {
        return $this->fuzzy;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $languageId
     */
    public function setLanguageId($languageId)
    {
        $this->languageId = $languageId;
    }

    /**
     * @return mixed
     */
    public function getLanguageId()
    {
        return $this->languageId;
    }

    /**
     * @param mixed $lastUpdateBy
     */
    public function setLastUpdateBy($lastUpdateBy)
    {
        $this->lastUpdateBy = $lastUpdateBy;
    }

    /**
     * @return mixed
     */
    public function getLastUpdateBy()
    {
        return $this->lastUpdateBy;
    }

    /**
     * @param mixed $lastUpdateDate
     */
    public function setLastUpdateDate($lastUpdateDate)
    {
        $this->lastUpdateDate = $lastUpdateDate;
    }

    /**
     * @return mixed
     */
    public function getLastUpdateDate()
    {
        return $this->lastUpdateDate;
    }

    /**
     * @param mixed $msgStr
     */
    public function setMsgStr($msgStr)
    {
        $this->msgStr = $msgStr;
    }

    /**
     * @return mixed
     */
    public function getMsgStr()
    {
        return $this->msgStr;
    }

    /**
     * @param mixed $msgStr1
     */
    public function setMsgStr1($msgStr1)
    {
        $this->msgStr1 = $msgStr1;
    }

    /**
     * @return mixed
     */
    public function getMsgStr1()
    {
        return $this->msgStr1;
    }

    /**
     * @param mixed $msgStr2
     */
    public function setMsgStr2($msgStr2)
    {
        $this->msgStr2 = $msgStr2;
    }

    /**
     * @return mixed
     */
    public function getMsgStr2()
    {
        return $this->msgStr2;
    }

    /**
     * @param mixed $poDataSetId
     */
    public function setPoDataSetId($poDataSetId)
    {
        $this->poDataSetId = $poDataSetId;
    }

    /**
     * @return mixed
     */
    public function getPoDataSetId()
    {
        return $this->poDataSetId;
    }

    public function asArray()
    {
        return array(
            'id' => $this->getId(),
            'poDateSetId' => $this->getPoDataSetId(),
            'languageId' => $this->getLanguageId(),
            'msgStr' => $this->getMsgStr(),
            'msgStr1' => $this->getMsgStr1(),
            'msgStr2' => $this->getMsgStr2(),
            'fuzzy' => $this->getFuzzy()
        );
    }

} 