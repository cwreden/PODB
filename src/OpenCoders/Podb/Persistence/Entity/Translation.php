<?php

namespace OpenCoders\Podb\Persistence\Entity;


/**
 * Class Translation
 * @package OpenCoders\Podb\Persistence\Entity
 * @Entity(repositoryClass="OpenCoders\Podb\Persistence\Repository\TranslationRepository")
 */
class Translation extends AbstractBaseEntity
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
     * @ManyToOne(targetEntity="DataSet", inversedBy="dataSets")
     * @JoinColumn(name="dataSet_id", referencedColumnName="id")
     */
    protected $dataSet;

    /**
     * @var
     * @ManyToOne(targetEntity="Language")
     * @JoinColumn(name="language_id", referencedColumnName="id")
     * @Column(nullable=false)
     */
    protected $language;

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

    // endregion

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
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
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
     * @param string $dataSet
     */
    public function setDataSet($dataSet)
    {
        $this->dataSet = $dataSet;
    }

    /**
     * @return string
     */
    public function getDataSet()
    {
        return $this->dataSet;
    }

    // endregion

    /**
     * @return array
     */
    public function asArray()
    {
        return array(
            'id' => $this->getId(),
//            'dateSetId' => $this->getDataSet(),
//            'languageId' => $this->getLanguage(),
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

    /**
     * @param string $apiVersion
     * @return array
     */
    public function getApiInformation($apiVersion)
    {
        $apiBaseUrl = $this->getBaseApiUrl();
        return array(
            'url' => $apiBaseUrl . '/' . $apiVersion . '/datasets/' . $this->getId()
        );
    }

} 