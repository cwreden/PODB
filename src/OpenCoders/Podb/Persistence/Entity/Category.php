<?php

namespace OpenCoders\Podb\Persistence\Entity;

/**
 * Class Category
 * @package OpenCoders\Podb\Persistence\Entity
 * @Entity(repositoryClass="OpenCoders\Podb\Persistence\Repository\CategoryRepository")
 */
class Category extends AbstractBaseEntity
{

    // region attributes

    /**
     * @var
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;

    /**
     * @var
     * @Column(type="string", unique=true, nullable=false)
     */
    protected $name;

    /**
     * @var
     * @ManyToOne(targetEntity="Project")
     * @Column(nullable=false)
     */
    protected $project;

    /**
     * @var
     * @ManyToOne(targetEntity="Category")
     */
    protected $category;

    /**
     * @var
     * @Column(type="text", nullable=true)
     */
    protected $description;

    // endregion attributes

    // region getter and setter

    public function asArray()
    {
        $data = $this->asShortArray();
        $data['description'] = $this->getDescription();
        $data['project'] = $this->getProject();
        $data['category'] = $this->getCategory();

        return $data;
    }

    public function asShortArray()
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
        );
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
    public function getName()
    {
        return $this->name;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param mixed $project
     */
    public function setProject($project)
    {
        $this->project = $project;
    }

    // endregion getter and setter

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }
}