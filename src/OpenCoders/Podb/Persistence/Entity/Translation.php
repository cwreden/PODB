<?php

namespace OpenCoders\Podb\Persistence\Entity;

use DateTime;

/**
 * Class Translation
 * @package OpenCoders\Podb\Persistence\Entity
 * @Entity(repositoryClass="OpenCoders\Podb\Persistence\Repository\TranslationRepository")
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
     * @Column(type="string", nullable=false)
     */
    protected $msgStr;

    /**
     * @var
     * @Column(type="string", nullable=true)
     */
    protected $msgStr1;

    /**
     * @var
     * @Column(type="string", nullable=true)
     */
    protected $msgStr2;

    /**
     * @var
     * @Column(type="boolean", nullable=false, options={"default" = 0})
     */
    protected $fuzzy = false;

    /**
     * @return DateTime|null
     */
    public function getCreateDate()
    {
        throw new \Exception('Not implemented!');
    }

    /**
     * @return string
     */
    public function getCreatedBy()
    {
        throw new \Exception('Not implemented!');
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
     * @return string
     */
    public function getLastUpdateBy()
    {
        throw new \Exception('Not implemented!');
    }

    /**
     * @return DateTime|null
     */
    public function getLastUpdateDate()
    {
        throw new \Exception('Not implemented!');
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
            'msgStr' => $this->getMsgStr(),
        );
    }

} 