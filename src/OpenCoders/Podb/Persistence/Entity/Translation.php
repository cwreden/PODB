<?php

namespace OpenCoders\Podb\Persistence\Entity;

/**
 * Class Translation
 * @package OpenCoders\Podb\Persistence\Entity
 * @Entity(repositoryClass="OpenCoders\Podb\Persistence\Repository\TranslationRepository")
 */
class Translation
{
    const ENTITY_NAME = 'OpenCoders\Podb\Persistence\Entity\Translation';

    // region attributes

    /**
     * @var int
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;

    /**
     * @var Message
     * @ManyToOne(targetEntity="Message", inversedBy="translations")
     * @JoinColumn(name="message_id", referencedColumnName="id")
     */
    protected $message;

    /**
     * @var Language
     * @ManyToOne(targetEntity="Language", inversedBy="translations")
     * @JoinColumn(name="language_id", referencedColumnName="id")
     */
    protected $language;

    /**
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $msgStr;

    /**
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $msgStr1;

    /**
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $msgStr2;

    /**
     * @var boolean
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
     * @param Language $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return Language
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
     * @param Message $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    // endregion
}
