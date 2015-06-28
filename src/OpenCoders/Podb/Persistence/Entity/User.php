<?php

namespace OpenCoders\Podb\Persistence\Entity;

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
    // region attributes

    /**
     * @var string EntityClassName (FQN)
     */
    protected $entityName = 'OpenCoders\Podb\Persistence\Entity\User';

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
    private $displayName;

    /**
     * @var boolean
     * @Column(type="boolean", nullable=false)
     */
    private $active = 0;

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
     * @var Credential[]|ArrayCollection
     * @OneToMany(targetEntity="Credential", mappedBy="user")
     */
    private $credentials;

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

    // endregion

    /**
     * @param array|null $data TODO refactor: no set attributes at instancing
     */
    public function __construct($data = array())
    {
        $this->ownedProjects = new ArrayCollection();
        $this->contributedProjects = new ArrayCollection();
        $this->supportedLanguages = new ArrayCollection();
        $this->credentials = new ArrayCollection();

        if (isset($data['username'])) {
            $this->setUsername($data['username']);
        }
        $this->setBulk($data);
    }

    // region getter and setter

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
     * @param string $gravatarEMail
     */
    public function setGravatarEMail($gravatarEMail)
    {
        $this->gravatarEMail = $gravatarEMail;
    }

    /**
     * @return string
     */
    public function getGravatarEMail()
    {
        return $this->gravatarEMail;
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
        if ($email == null || $email == '') {
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
     * @param string $username
     *
     * @throws EmptyParameterException
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
     * @param string $password
     *
     * @throws EmptyParameterException
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
     * @param ArrayCollection|string $supportedLanguages
     */
    public function setSupportedLanguages($supportedLanguages)
    {
        if ($supportedLanguages instanceof ArrayCollection) {
            $this->supportedLanguages = $supportedLanguages;
        } else if ($supportedLanguages == null) {
            $this->supportedLanguages = null;
        } else if (is_string($supportedLanguages) && $supportedLanguages !== '') {

            $supportedLanguageIds = explode(',', $supportedLanguages);
            $supportedLanguages = new ArrayCollection();
            foreach ($supportedLanguageIds as $languageId) {
                $language = $this->getEntityManager()->getRepository(
                    'OpenCoders\Podb\Persistence\Entity\Language'
                )->find($languageId);
                if ($language) {
                    $supportedLanguages->add($language);
                }
            }
            $this->supportedLanguages = $supportedLanguages;
        }
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
     * @return Credential[]|ArrayCollection
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * @param Credential[]|ArrayCollection $credentials
     */
    public function setCredentials($credentials)
    {
        $this->credentials = $credentials;
    }


    // endregion

    /**
     * Returns all user data as an array
     *
     * @return array
     */
    public function asArray()
    {
        $data = $this->asShortArray();

        $data['email'] = $this->getEmail();
        $data['active'] = $this->getActive();

        return $data;
    }

    /**
     *
     *
     * @return array
     */
    public function asShortArray()
    {
        return array(
            'id' => $this->getId(),
            'displayname' => $this->getDisplayName(),
            'username' => $this->getUsername(),
        );
    }

    /**
     * Returns an array with API Information (urls) about this user
     *
     * @param $apiVersion
     *
     * @return array
     */
    public function getAPIInformation($apiVersion)
    {
        $urlToUser = $this->getBaseAPIUrl() . '/' . $apiVersion . '/users/' . $this->getUsername();

        return array(
            '_links' => array(
                'self' => $urlToUser,
                'projects' => $urlToUser . '/projects',
                'own_projects' => $urlToUser . '/own/projects',
                'languages' => $urlToUser . '/languages',
                'translations' => $urlToUser . '/translations'
            )
        );
    }

    /**
     * Updates a User by given data
     *
     * @deprecated
     * @param array $data
     *
     * @throws PodbException
     *
     * @return void
     */
    public function update($data)
    {
        if ($data == null) {
            throw new PodbException('There is nothing to update.');
        }
        $this->setBulk($data);
    }

    /**
     * Returns true if given password is equal with stored password
     *
     * @param $password string
     *
     * @return bool
     */
    public function checkPassword($password)
    {
        return $this->password == sha1($password);
    }

    /**
     * Updates this user by given data
     *
     * @deprecated
     * @param array $data
     *
     * @return void
     */
    private function setBulk($data)
    {
        foreach ($data as $key => $value) {
            if ($key == 'displayName') {
                $this->setDisplayName($value);
            } else if ($key == 'email') {
                $this->setEmail($value);
            } else if ($key == 'password') {
                $this->setPassword(sha1($value));
            } else if ($key == 'active') {
                $this->setActive($value);
            } else if ($key == 'gravatarEMail') {
                $this->setGravatarEMail($value);
            } else if ($key == 'company') {
                $this->setCompany($value);
            } else if ($key == 'publicEMail') {
                $this->setPublicEMail($value);
            } else if ($key == 'supportedLanguages') {
                $this->setSupportedLanguages($value);
            } else if ($key == 'emailValidated') {
                $this->setEmailValidated($value);
            }
        }
    }
}