<?php

namespace OpenCoders\Podb\Persistence\Entity;


/**
 * Class Credential
 * @package OpenCoders\Podb\Persistence\Entity
 * @Entity(repositoryClass="OpenCoders\Podb\Persistence\Repository\CredentialRepository")
 */
class Credential
{
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
     * @Column(type="string", nullable=false)
     */
    private $password;

    /**
     * @var string
     * @Column(type="string", nullable=false)
     */
    private $salt;

    /**
     * @var User
     * @ManyToOne(targetEntity="User", inversedBy="credentials")
     * @JoinColumn(name="credential_id", referencedColumnName="id")
     */
    protected $user;

    // endregion

    // region getter and setter

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param mixed $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    // endregion

}
