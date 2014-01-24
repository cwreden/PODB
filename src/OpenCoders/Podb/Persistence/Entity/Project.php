<?php

namespace OpenCoders\Podb\Persistence\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use OpenCoders\Podb\Exception\NothingToUpdatePodbException;

/**
 * Class Project
 * @package OpenCoders\Podb\Persistence\Entity
 * @Entity(repositoryClass="OpenCoders\Podb\Persistence\Repository\ProjectRepository")
 * @Table(
 *      name="Project",
 *      uniqueConstraints={@UniqueConstraint(name="project_unique",columns={"name"})}
 * )
 */
class Project extends AbstractBaseEntity
{

    /**
     * @var
     * @ID
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;

    /**
     * @var
     * @Column(type="string")
     */
    protected $name;

    /**
     * @var
     * @ManyToOne(targetEntity="Language")
     */
    protected $default_language;

    /**
     * @var
     * @ManyToMany(targetEntity="User", inversedBy="projects")
     * @JoinTable(name="users_projects")
     */
    protected $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

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
     * @param String[] $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }

    /**
     * @return String[]
     */
    public function getUsers()
    {
        return $this->users;
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
//            'users' => $this->getUsers(),
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
            'url' => $apiBaseUrl . "/" . $apiVersion . "/projects/" . $this->getName(),
            'url_html' => '', // @ToDo: Überlegen, was mit url_html gemeint war
            'url_members' => $apiBaseUrl . "/" . $apiVersion . "/projects/" . $this->getName() . "/members",
            'url_domains' => $apiBaseUrl . "/" . $apiVersion . "/projects/" . $this->getName() . "/domains",
            'url_languages' => $apiBaseUrl . "/" . $apiVersion . "/projects/" . $this->getName() . "/languages"
        );
    }

    /**
     * Updates the project model by given data
     * @param array $data
     *
     * @throws \OpenCoders\Podb\Exception\NothingToUpdatePodbException
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

    public function addUser($user)
    {
        $this->users->add($user);
    }

    public function removeUser($user)
    {
        $this->users->removeElement($user);
    }
}