<?php

namespace PODB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class PODomain
 * @package PODB\Entity
 * @ORM\Entity
 */
class PODomain {

    /**
     * @var
     * @ORM\Id
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
     * @ORM\ManyToOne(targetEntity="Project")
     */
    protected $projectId;

    protected $createdBy;

    protected $createDate;

    protected $lastUpdateBy;

    protected $lastUpdateDate;
} 