<?php

namespace OpenCoders\Podb\Persistence\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use OpenCoders\Podb\Exception\EmptyParameterException;
use OpenCoders\Podb\Exception\PodbException;

/**
 * Class User
 * @package OpenCoders\Podb\Persistence\Entity
 * @Entity(repositoryClass="OpenCoders\Podb\Persistence\Repository\UserRepository")
 * @Table(
 *      name="user",
 *      uniqueConstraints={@UniqueConstraint(name="user_unique",columns={"username", "email"})}
 * )
 */
class User extends AbstractBaseEntity
{

    /**
     * @var string EntityClassName (FQN)
     */
    protected $entityName = 'OpenCoders\Podb\Persistence\Entity\User';

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
     * @ManyToMany(targetEntity="Project", mappedBy="users")
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

    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    /**
     * @param mixed $email
     *
     * @throws \OpenCoders\Podb\Exception\PodbException
     *
     * @return void
     */
    public function setEmail($email)
    {
        if ($email == null || $email == '') {
            throw new EmptyParameterException('EMail not allowed to be empty.');
        }
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
     *
     * @throws \OpenCoders\Podb\Exception\PodbException
     *
     * @return void
     */
    public function setUsername($username)
    {
        if ($username == null || $username == '') {
            throw new EmptyParameterException('Username not allowed to be empty.');
        }
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
     *
     * @throws \OpenCoders\Podb\Exception\PodbException
     *
     * @return void
     */
    public function setPassword($password)
    {
        if ($password == null || $password == '') {
            throw new EmptyParameterException('Password not allowed to be empty.');
        }
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
     * @return void
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

    /**
     * @param $apiVersion
     * @return array
     */
    public function getAPIInformation($apiVersion)
    {
        $baseUrl = $this->getBaseAPIUrl();

        return array(
            'url_user' => $baseUrl . '/' . $apiVersion . '/users/' . $this->getUsername(),
            'url_projects' => $baseUrl . '/' . $apiVersion . '/users/' . $this->getUsername() . '/projects',
            'url_languages' => $baseUrl . '/' . $apiVersion . '/users/' . $this->getUsername() . '/languages',
            'url_translations' => $baseUrl . '/' . $apiVersion . '/users/' . $this->getUsername() . '/translations'
        );
    }

    public function update($data)
    {
        if ($data == null) {
            throw new PodbException('There is nothing to update.');
        }
        foreach ($data as $key => $value) {
            if ($key == 'displayName') {
                $this->setDisplayName($value);
            } else if ($key == 'email') {
                $this->setEmail($value);
            } else if ($key == 'password') {
                $this->setPassword(sha1($value));
            } else if ($key == 'state') {
                $this->setState($value);
            }
        }
        $this->setLastUpdateDate(new DateTime());
    }

    public function addProject(Project $project)
    {
        $project->addUser($this);
        $this->projects->add($project);
    }

    public function removeProject(Project $project)
    {
        $project->removeUser($this);
        $this->projects->removeElement($project);
    }

    /**
     * @param string $pass
     * @return bool
     */
    public function checkPassword($pass)
    {
        return $this->password == $pass;
    }
}