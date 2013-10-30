<?php

namespace PODB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Language
 * @package PODB\Entity
 * @ORM\Entity
 */
class Language {

    /**
     * @var
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type"integer")
     */
    protected $id;

    /**
     * @var
     * @ORM\Column(type="string")
     */
    protected $Name;

    /**
     * @var
     * @ORM\Column(type="string")
     */
    protected $locale;

    protected $createdBy;

    protected $createDate;

    protected $lastUpdateBy;

    protected $lastUpdateDate;
} 