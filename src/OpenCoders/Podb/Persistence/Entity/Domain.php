<?php

namespace OpenCoders\Podb\Persistence\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Domain
 * @package OpenCoders\Podb\Persistence\Entity
 * @Entity(repositoryClass="OpenCoders\Podb\Persistence\Repository\DomainRepository")
 */
class Domain extends AbstractBaseEntity
{

    // region attributes

    /**
     * @var int
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     * @Column(type="string", unique=true, nullable=false)
     */
    protected $name;

    /**
     * @var string
     * @Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @var Project
     * @ManyToOne(targetEntity="Project", inversedBy="domains")
     * @JoinColumn(name="project_id", referencedColumnName="id")
     */
    protected $project;

    /**
     * @var Message[]|ArrayCollection
     * @OneToMany(targetEntity="Message", mappedBy="domain")
     */
    protected $messages;

    // endregion

    /**
     * @throws \Exception
     */
    public function getCreateDate()
    {
        throw new \Exception('Not implemented!');
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @throws \Exception
     */
    public function getCreatedBy()
    {
        throw new \Exception('Not implemented!');
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @throws \Exception
     */
    public function getLastUpdateBy()
    {
        throw new \Exception('Not implemented!');
    }

    /**
     * @throws \Exception
     */
    public function getLastUpdateDate()
    {
        throw new \Exception('Not implemented!');
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $project
     */
    public function setProjectId($project)
    {
        $this->project = $project;
    }

    /**
     * @return string
     */
    public function getProjectId()
    {
        return $this->project;
    }

    /**
     * @return array
     */
    public function asArray()
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription()
//            'lastUpdatedDate' => $this->getLastUpdateDate(),
//            'lastUpdatedBy' => $this->getLastUpdateBy(),
//            'createdDate' => $this->getCreateDate(),
//            'createdBy' => $this->getCreatedBy(),
        );
    }

    /**
     *
     * @return array
     */
    public function asShortArray()
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
        );
    }

    public function getAPIInformation($apiVersion)
    {
        $apiBaseUrl = $this->getBaseApiUrl();
        return array(
            '_links' => array(
                'self' => $apiBaseUrl . "/" . $apiVersion . "/domains/" . $this->getId(),
                'project' => $apiBaseUrl . "/" . $apiVersion . "/projects/" . $this->getProjectId(),
                'domains' => $apiBaseUrl . "/" . $apiVersion . "/domains/" . $this->getId() . '/datasets'
            )
        );
    }

    /**
     *
     *
     * @param array $data
     *
     * @return Domain
     */
    public function update($data = null)
    {
        if (is_array($data) && !empty($data)) {
            foreach ($data as $key => $value) {
                if ($key == 'name') {
                    $this->setName($value);
                } else if ($key == 'projectId') {
                    $this->setProjectId($value);
                } else if ($key == 'description') {
                    $this->setDescription($value);
                }
            }
        }

        return $this;
    }
} 