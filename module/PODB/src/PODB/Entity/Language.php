<?php

namespace PODB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Language
 * @package PODB\Entity
 * @ORM\Entity
 */
class Language extends Entity
{

    /**
     * TODO ID ins Entity => Entity braucht spezielle Annotation, damit Doctrine die Entity nicht anlegt
     *
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
     * @ORM\Column(type="string")
     */
    protected $locale;

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