<?php

namespace OpenCoders\Podb\Persistence\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Message
 * @package OpenCoders\Podb\Persistence\Entity
 * @Entity(repositoryClass="OpenCoders\Podb\Persistence\Repository\MessageRepository")
 */
class Message
{

    // region attributes
    const ENTITY_NAME = 'OpenCoders\Podb\Persistence\Entity\Message';

    /**
     * @var int
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $msgId;

    /**
     * @var Project
     * @ManyToOne(targetEntity="Project", inversedBy="messages")
     * @JoinColumn(name="project_id", referencedColumnName="id")
     */
    protected $project;

    /**
     * @var Domain
     * @ManyToOne(targetEntity="Domain", inversedBy="messages")
     * @JoinColumn(name="domain_id", referencedColumnName="id")
     */
    protected $domain;

    /**
     * @var Translation[]|ArrayCollection
     * @OneToMany(targetEntity="Translation", mappedBy="message")
     */
    protected $translations;

    // endregion

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    // region getter and setter

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getMsgId()
    {
        return $this->msgId;
    }

    /**
     * @param string $msgId
     */
    public function setMsgId($msgId)
    {
        $this->msgId = $msgId;
    }

    /**
     * @return Domain
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param Domain $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * @return ArrayCollection|Translation[]
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * @param ArrayCollection|Translation[] $translations
     */
    public function setTranslations($translations)
    {
        $this->translations = $translations;
    }

    /**
     * @return Domain
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param Project $project
     */
    public function setProject($project)
    {
        $this->project = $project;
    }

    // endregion
}
