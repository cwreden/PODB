<?php

namespace PODB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Translation
 * @package PODB\Entity
 * @ORM\Entity
 */
class Translation {

    /**
     * @var
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="PODataSet")
     */
    protected $poDataSetId;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Language")
     */
    protected $languageId;

    /**
     * @var
     * @ORM\Column(type="string")
     */
    protected $msgStr;

    /**
     * @var
     * @ORM\Column(type="string")
     */
    protected $msgStr1;

    /**
     * @var
     * @ORM\Column(type="string")
     */
    protected $msgStr2;

    /**
     * @var
     * @ORM\Column(type="boolean")
     */
    protected $fuzzy;

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