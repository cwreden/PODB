<?php

namespace OpenCoders\Podb\Persistence\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use OpenCoders\Podb\Exception\NothingToUpdatePodbException;

/**
 * Class Project
 * @package OpenCoders\Podb\Persistence\Entity
 * @Entity(repositoryClass="OpenCoders\Podb\Persistence\Repository\ProjectRepository")
 */
class Project extends AbstractBaseEntity
{
    // region attributes

    /**
     * @var
     * @ID
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;

    /**
     * @var
     * @Column(type="string", unique=true, nullable=false)
     */
    protected $name;

    /**
     * @var
     * @ManyToOne(targetEntity="Language", inversedBy="projects")
     * @JoinColumn(name="default_language_id", referencedColumnName="id")
     */
    protected $default_language;

    /**
     * @var
     * @ManyToOne(targetEntity="User", inversedBy="ownedProjects")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $owner;

    /**
     * @var
     * @ManyToMany(targetEntity="User", mappedBy="contributedProjects")
     * @JoinTable(name="users_projects")
     */
    protected $contributors;

    /**
     * @var
     * @Column(type="boolean", nullable=false, options={"default" = 0})
     */
    protected $private = false;

    /**
     * @var
     * @Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * Project web page
     *
     * @var
     * @Column(type="string", nullable=true)
     */
    private $url;

    /**
     * @var
     * @OneToMany(targetEntity="Category", mappedBy="project")
     */
    protected $categories;

    // endregion

    function __construct()
    {
        $this->contributors = new ArrayCollection();
        $this->categories = new ArrayCollection();
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
     * @return mixed
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
        $this->default_language = $defaultLanguageId;
    }

    /**
     * @return string
     */
    public function getDefaultLanguage()
    {
        return $this->default_language;
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

    /**
     * @return array
     */
    public function asArray()
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'defaultLanguage' => $this->getDefaultLanguage(),
            'active' => $this->getPrivate(),
            'description' => $this->getDescription(),
            'url_blog' => $this->getUrl()
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
            'name' => $this->getName(),
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
            '_links' => array(
                'self' => $apiBaseUrl . "/" . $apiVersion . "/projects/" . $this->getName(),
                'html' => '', // @ToDo: Überlegen, was mit url_html gemeint war
                'members' => $apiBaseUrl . "/" . $apiVersion . "/projects/" . $this->getName() . "/members",
                'languages' => $apiBaseUrl . "/" . $apiVersion . "/projects/" . $this->getName() . "/languages"
            )
        );
    }

    // endregion

    /**
     * Updates the project model by given data
     *
     * @deprecated
     *
     * @param array $data
     *
     * @throws NothingToUpdatePodbException
     *
     * @returns void
     */
    public function update($data = null)
    {
        if ($data == null) {
            throw new NothingToUpdatePodbException('There is nothing to update.');
        }

        foreach ($data as $key => $value) {
            if ($key == 'name') {
                $this->setName($value);
            } else if ($key == 'users') {
            }
        }
    }
}