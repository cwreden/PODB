<?php

namespace OpenCoders\PODB\Entity;

use DateTime;

/**
 * Class User
 * @package OpenCoders\PODB\Entity
 * @Entity(repositoryClass="OpenCoders\PODB\Repository\UserRepository")
 */
class User
{

    /**
     * @var
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    private $id;

    /**
     * @var
     * @Column(type="string")
     */
    private $username;

    /**
     * @var
     * @Column(type="string")
     */
    private $displayName;

    /**
     * @var
     * @Column(type="integer")
     */
    private $state;

    /**
     * @var
     * @Column(type="string")
     */
    private $email;

    /**
     * @var
     * @Column(type="string")
     */
    private $password;

    /**
     * @var
     * @ManyToMany(targetEntity="Project", inversedBy="users")
     * @JoinTable(name="users_projects")
     */
    private $projects;

    /**
     * @var
     * @Column(type="datetime")
     */
    protected $createDate;

    /**
     * @var
     * @Column(type="datetime")
     */
    protected $lastUpdateDate;

    /**
     * @param mixed $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $id
     * @return void
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
     * @param string $username
     * @return void
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $password
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $projects
     */
    public function setProjects($projects)
    {
        $this->projects = $projects;
    }

    /**
     * @return mixed
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * Get displayName.
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * Set displayName.
     *
     * @param string $displayName
     * @return UserInterface
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

    /**
     * Get state.
     *
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set state.
     *
     * @param int $state
     * @return UserInterface
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return DateTime|null
     */
    public function getCreateDate()
    {
        return $this->createDate ? clone $this->createDate : null;
    }

    /**
     * @param DateTime $createDate
     */
    public function setCreateDate(DateTime $createDate = null)
    {
        $this->createDate = $createDate ? clone $createDate : null;
    }

    /**
     * @return DateTime|null
     */
    public function getLastUpdateDate()
    {
        return $this->lastUpdateDate ? clone $this->lastUpdateDate : null;
    }

    /**
     * @param DateTime $lastUpdateDate
     */
    public function setLastUpdateDate(DateTime $lastUpdateDate = null)
    {
        $this->lastUpdateDate = $lastUpdateDate ? clone $lastUpdateDate : null;
    }

    /**
     * Returns all user data as an array
     *
     * @return array
     */
    public function asArray()
    {
        return array(
            'id' => $this->getId(),
            'displayname' => $this->getDisplayName(),
            'username' => $this->getUsername(),
            'email' => $this->getEmail(),
            'state' => $this->getState(),
            'createDate' => $this->getCreateDate(),
            'lastUpdateDate' => $this->getLastUpdateDate(),
        );
    }

    /**
     * @return array
     */
    public function asShortArray()
    {
        return array(
            'id' => $this->getId(),
            'displayname' => $this->getDisplayName(),
        );
    }
}