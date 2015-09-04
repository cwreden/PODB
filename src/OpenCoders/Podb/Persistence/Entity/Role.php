<?php

namespace OpenCoders\Podb\Persistence\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Role
 * @package OpenCoders\Podb\Persistence\Entity
 * @Entity(repositoryClass="OpenCoders\Podb\Persistence\Repository\RoleRepository")
 */
class Role
{
    const ENTITY_NAME = 'OpenCoders\Podb\Persistence\Entity\Role';

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
    private $name;

    /**
     * @var string
     * @Column(type="string", nullable=false)
     */
    private $type;

    /**
     * @var User[]|ArrayCollection
     * @ManyToMany(targetEntity="User", mappedBy="roles")
     * @JoinTable(name="users_languages")
     */
    private $users;


    // endregion

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return ArrayCollection|User[]
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param ArrayCollection|User[] $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    // endregion

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
