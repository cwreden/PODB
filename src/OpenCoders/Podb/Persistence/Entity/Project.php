<?php

namespace OpenCoders\Podb\Persistence\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use OpenCoders\Podb\Exception\NothingToUpdatePodbException;

/**
 * Class Project
 * @package OpenCoders\Podb\Persistence\Entity
 * @Entity(repositoryClass="OpenCoders\Podb\Persistence\Repository\ProjectRepository")
 */
class Project
{
    // region attributes
    const ENTITY_NAME = 'OpenCoders\Podb\Persistence\Entity\Project';

    /**
     * @var int
     * @ID
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     * @Column(type="string", unique=true, nullable=false)
     */
    protected $name;

    /**
     * @var
     * @ManyToOne(targetEntity="Language", inversedBy="projects")
     * @JoinColumn(name="default_language_id", referencedColumnName="id")
     */
    protected $defaultLanguage;

    /**
     * @var User
     * @ManyToOne(targetEntity="User", inversedBy="ownedProjects")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $owner;

    /**
     * @var User[]|ArrayCollection
     * @ManyToMany(targetEntity="User", mappedBy="contributedProjects")
     * @JoinTable(name="users_projects")
     */
    protected $contributors;

    /**
     * @var Message[]|ArrayCollection
     * @OneToMany(targetEntity="Message", mappedBy="project")
     */
    protected $messages;

    /**
     * @var boolean
     * @Column(type="boolean", nullable=false, options={"default" = 0})
     */
    protected $private = false;

    /**
     * @var string
     * @Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * Project web page
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    private $url;

    /**
     * @var Domain[]|ArrayCollection
     * @OneToMany(targetEntity="Domain", mappedBy="project")
     */
    protected $domains;

    // endregion

    public function __construct()
    {
        $this->contributors = new ArrayCollection();
    }

    // region Getter & Setter

    /**
     * @param mixed $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

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
     * @param string $defaultLanguageId
     */
    public function setDefaultLanguage($defaultLanguageId)
    {
        $this->defaultLanguage = $defaultLanguageId;
    }

    /**
     * @return Language
     */
    public function getDefaultLanguage()
    {
        return $this->defaultLanguage;
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
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @throws \Exception
     */
    public function getContributors()
    {
        return $this->contributors;
    }

    /**
     * @param mixed $private
     */
    public function setPrivate($private)
    {
        $this->private = $private;
    }

    /**
     * @return bool
     */
    public function getPrivate()
    {
        return $this->private;
    }

    // endregion
}
