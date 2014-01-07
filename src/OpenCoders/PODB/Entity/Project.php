<?php

namespace OpenCoders\PODB\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Project
 * @package OpenCoders\PODB\Entity
 * @ORM\Entity
 */
class Project extends BaseEntity
{

    /**
     * @var
     * @ORM\ID
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Language")
     */
    protected $default_language;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="User", mappedBy="projects")
     */
    protected $users;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected $createdBy;

    /**
     * @var
     * @ORM\Column(type="datetime")
     */
    protected $createDate;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected $lastUpdateBy;

    /**
     * @var
     * @ORM\Column(type="datetime")
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
} 