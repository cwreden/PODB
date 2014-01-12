<?php

namespace OpenCoders\Podb\Persistence\Entity;

use DateTime;
use OpenCoders\Podb\Exception\NothingToUpdatePodbException;

/**
 * Class Project
 * @package OpenCoders\Podb\Persistence\Entity
 * @Entity(repositoryClass="OpenCoders\Podb\Persistence\Repository\ProjectRepository")
 * @Table(
 *      name="project",
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
     * @ManyToMany(targetEntity="User", mappedBy="projects")
     */
    protected $users;

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
     * @param string $userId
     */
    public function setCreatedBy($userId)
    {
        $this->createdBy = $userId;
    }

    /**
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
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
     * @param string $userId
     */
    public function setLastUpdateBy($userId)
    {
        $this->lastUpdateBy = $userId;
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
    public function setLastUpdateDate(DateTime $lastUpdateDate = null)
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
            'users' => $this->getUsers(),
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
            }
        }
    }
}