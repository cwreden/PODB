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
     * @Column(type="string", unique=true, nullable=false)
     */
    private $username;

    /**
     * @var
     * @Column(type="string")
     */
    private $displayName;

    /**
     * @var
     * @Column(type="boolean", nullable=false, options={"default" = 0})
     */
    private $active;

    /**
     * @var
     * @Column(type="string", unique=true, nullable=false)
     */
    private $email;

    /**
     * @var
     * @Column(type="string", nullable=false)
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
     * @ManyToMany(targetEntity="Language", inversedBy="supportedBy")
     * @JoinTable(name="users_languages")
     */
    private $supportedLanguages;

    /**
     * @var
     * @Column(type="string", nullable=true)
     */
    private $gravatarEMail;

    /**
     * @var
     * @Column(type="string", nullable=true)
     */
    private $publicEMail;

    /**
     * @var
     * @Column(type="string", nullable=true)
     */
    private $company;

    /**
     *
     */
    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    /**
     * @param mixed $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param string $entityName
     */
    public function setEntityName($entityName)
    {
        $this->entityName = $entityName;
    }

    /**
     * @return string
     */
    public function getEntityName()
    {
        return $this->entityName;
    }

    /**
     * @param mixed $gravatarEMail
     */
    public function setGravatarEMail($gravatarEMail)
    {
        $this->gravatarEMail = $gravatarEMail;
    }

    /**
     * @return mixed
     */
    public function getGravatarEMail()
    {
        return $this->gravatarEMail;
    }

    /**
     * @param mixed $publicEMail
     */
    public function setPublicEMail($publicEMail)
    {
        $this->publicEMail = $publicEMail;
    }

    /**
     * @return mixed
     */
    public function getPublicEMail()
    {
        return $this->publicEMail;
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
     * Get active.
     *
     * @return int
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set active.
     *
     * @param int $active
     * @return int
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return User
     */
    public function getCreatedBy()
    {
        throw new \Exception('Not implemented!');
    }

    /**
     * @return User
     */
    public function getLastUpdatedBy()
    {
        throw new \Exception('Not implemented!');
    }

    /**
     * @return DateTime|null
     */
    public function getCreateDate()
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
     * @param mixed $supportedLanguages
     */
    public function setSupportedLanguages($supportedLanguages)
    {
        $this->supportedLanguages = $supportedLanguages;
    }

    /**
     * @return mixed
     */
    public function getSupportedLanguages()
    {
        return $this->supportedLanguages;
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
            'active' => $this->getActive(),
//            'createDate' => $this->getCreateDate(),
//            'lastUpdateDate' => $this->getLastUpdateDate(),
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
            } else if ($key == 'active') {
                $this->setActive($value);
            }
        }
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