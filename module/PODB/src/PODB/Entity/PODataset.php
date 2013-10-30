<?php

namespace PODB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class PODataSet
 * @package PODB\Entity
 * @ORM\Entity
 *
 * ID, DomainID, msgID, ..., createdBy, createDate, lastUpdateBy, lastUpdateDate
 */
class PODataSet {

    /**
     * @var
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="PODomain")
     */
    protected $domainId;

    /**
     * @var
     * @ORM\Column(type="string")
     */
    protected $msgId;


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