<?php

namespace OpenCoders\Podb\Persistence\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use OpenCoders\Podb\Exception\EmptyParameterException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 * @package OpenCoders\Podb\Persistence\Entity
 * @Entity(repositoryClass="OpenCoders\Podb\Persistence\Repository\UserRepository")
 */
class User implements UserInterface
{
    const ENTITY_NAME = 'OpenCoders\Podb\Persistence\Entity\User';

    // region attributes

    /**
     * @var int
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @Column(type="string")
     */
    private $username;

    /**
     * @var string
     * @Column(type="string")
     */
    private $displayName;

    /**
     * @var boolean
     * @Column(type="boolean", nullable=false)
     */
    private $active = false;

    /**
     * @var string
     * @Column(type="string", unique=true, nullable=false)
     */
    private $email;

    /**
     * @var boolean
     * @Column(type="boolean", nullable=false)
     */
    private $emailValidated = false;

    /**
     * @var boolean
     * @Column(type="boolean", nullable=false)
     */
    private $validated = false;

    /**
     * @var Project[]|ArrayCollection
     * @OneToMany(targetEntity="Project", mappedBy="owner")
     */
    private $ownedProjects;

    /**
     * @var Project[]|ArrayCollection
     * @ManyToMany(targetEntity="Project", inversedBy="contributors")
     * @JoinTable(name="users_projects")
     */
    private $contributedProjects;

    /**
     * @var Language[]|ArrayCollection
     * @ManyToMany(targetEntity="Language", inversedBy="supportedBy")
     * @JoinTable(name="users_languages")
     */
    private $supportedLanguages;

    /**
     * @var string
     * @Column(type="string", nullable=false)
     */
    private $password;

    /**
     * @var string
     * @Column(type="string", nullable=false)
     */
    private $salt;

    /**
     * @var string
     * @Column(type="string", nullable=true)
     */
    private $publicEMail;

    /**
     * @var string
     * @Column(type="string", nullable=true)
     */
    private $company;

    /**
     * @var Role[]|ArrayCollection
     * @ManyToMany(targetEntity="Role", inversedBy="users")
     * @JoinTable(name="users_roles")
     */
    private $roles;

    // endregion

    /**
     *
     */
    public function __construct()
    {
        $this->ownedProjects = new ArrayCollection();
        $this->contributedProjects = new ArrayCollection();
        $this->supportedLanguages = new ArrayCollection();
        $this->roles = new ArrayCollection();
    }

    // region getter and setter

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @throws EmptyParameterException
     */
    public function setUsername($username)
    {
        if ($username === null || $username === '') {
            throw new EmptyParameterException('Username not allowed to be empty.');
        }
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @throws EmptyParameterException
     */
    public function setPassword($password)
    {
        if ($password === null || $password === '') {
            throw new EmptyParameterException('Password not allowed to be empty.');
        }
        $this->password = $password;
    }

    /**
     * @return boolean
     */
    public function isValidated()
    {
        return $this->validated;
    }

    /**
     * @param boolean $validated
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;
    }

    /**
     * @param ArrayCollection $ownedProjects
     */
    public function setOwnedProjects($ownedProjects)
    {
        $this->ownedProjects = $ownedProjects;
    }

    /**
     * @return ArrayCollection
     */
    public function getOwnedProjects()
    {
        return $this->ownedProjects;
    }

    /**
     * @param boolean $emailValidated
     */
    public function setEmailValidated($emailValidated)
    {
        $this->emailValidated = $emailValidated;
    }

    /**
     * @return boolean
     */
    public function getEmailValidated()
    {
        return $this->emailValidated;
    }

    /**
     * @param string $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param string $publicEMail
     */
    public function setPublicEMail($publicEMail)
    {
        $this->publicEMail = $publicEMail;
    }

    /**
     * @return string
     */
    public function getPublicEMail()
    {
        return $this->publicEMail;
    }

    /**
     * @param string $email
     *
     * @throws EmptyParameterException
     *
     * @return void
     */
    public function setEmail($email)
    {
        if ($email === null || $email === '') {
            throw new EmptyParameterException('EMail not allowed to be empty.');
        }
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection
     */
    public function getContributedProjects()
    {
        return $this->contributedProjects;
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
     *
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
     *
     * @return int
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @throws \Exception
     *
     */
    public function getCreatedBy()
    {
        throw new \Exception('Not implemented!');
    }

    /**
     * @throws \Exception
     *
     */
    public function getLastUpdatedBy()
    {
        throw new \Exception('Not implemented!');
    }

    /**
     * @throws \Exception
     *
     */
    public function getCreateDate()
    {
        throw new \Exception('Not implemented!');
    }

    /**
     * @throws \Exception
     *
     */
    public function getLastUpdateDate()
    {
        throw new \Exception('Not implemented!');
    }

    /**
     * @param Language[]|ArrayCollection $supportedLanguages
     */
    public function setSupportedLanguages($supportedLanguages)
    {
        if (!$supportedLanguages instanceof ArrayCollection && !is_array($supportedLanguages)) {
            $supportedLanguages = null;
        }
        $this->supportedLanguages = $supportedLanguages;
    }

    /**
     * Returns supported languages of this user
     *
     * @return ArrayCollection
     */
    public function getSupportedLanguages()
    {
        return $this->supportedLanguages;
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    // endregion

    /**
     * Returns true if given password is equal with stored password
     *
     * @param $password string
     *
     * @return bool
     * @deprecated
     */
    public function checkPassword($password)
    {
        return $this->password === sha1($password);
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
        // Hint nothing to do
    }
}