<?php

namespace PODB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class PODomain
 * @package PODB\Entity
 * @ORM\Entity
 */
class PODomain extends BaseEntity
{

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

    /**
     * @param mixed $createDate
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;
    }

    /**
     * @return mixed
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * @param mixed $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $lastUpdateBy
     */
    public function setLastUpdateBy($lastUpdateBy)
    {
        $this->lastUpdateBy = $lastUpdateBy;
    }

    /**
     * @return mixed
     */
    public function getLastUpdateBy()
    {
        return $this->lastUpdateBy;
    }

    /**
     * @param mixed $lastUpdateDate
     */
    public function setLastUpdateDate($lastUpdateDate)
    {
        $this->lastUpdateDate = $lastUpdateDate;
    }

    /**
     * @return mixed
     */
    public function getLastUpdateDate()
    {
        return $this->lastUpdateDate;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $projectId
     */
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
    }

    /**
     * @return mixed
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    public function asArray()
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName()
        );
    }
} 