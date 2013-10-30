<?php

namespace PODB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Project
 * @package PODB\Entity
 * @ORM\Entity
 */
class Project {

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

    protected $createDate;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected $lastUpdateBy;

    protected $lastUpdateDate;
} 