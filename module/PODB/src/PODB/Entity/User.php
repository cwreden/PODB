<?php

namespace PODB\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use ZfcUser\Entity\UserInterface;

/**
 * Class User
 * @package PODB\Entity
 * @ORM\Entity
 */
class User extends BaseEntity implements UserInterface
{

    /**
     * @var
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var
     * @ORM\Column(type="string")
     */
    private $username;

    /**
     * @var
     * @ORM\Column(type="string")
     */
    private $displayName;

    /**
     * @var
     * @ORM\Column(type="integer")
     */
    private $state;

    /**
     * @var
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @var
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="Project", inversedBy="users")
     * @ORM\JoinTable(name="users_projects")
     */
    private $projects;

    /**
     * @var
     * @ORM\Column(type="datetime")
     */
    protected $createDate;

    /**
     * @var
     * @ORM\Column(type="datetime")
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
            'username' => $this->getUsername(),
            'displayname' => $this->getDisplayName()
        );
    }
}