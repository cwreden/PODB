<?php

namespace OpenCoders\Podb\Service;


use Doctrine\ORM\EntityManager;
use OpenCoders\Podb\Exception\MissingParameterException;
use OpenCoders\Podb\Persistence\Entity\Category;
use OpenCoders\Podb\Persistence\Repository\ProjectRepository;

/**
 * Class CategoryService
 * @package OpenCoders\Podb\Service
 * @deprecated
 */
class CategoryService extends BaseEntityService
{
    /**
     * @var string EntityClassName (FQN)
     */
    const ENTITY_NAME = 'OpenCoders\Podb\Persistence\Entity\Category';

    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    function __construct(EntityManager $entityManager, ProjectRepository $projectRepository)
    {
        parent::__construct($entityManager, self::ENTITY_NAME);
        $this->projectRepository = $projectRepository;
    }

    /**
     * @return Category[]
     */
    public function getAll()
    {
        $repository = $this->getRepository();
        return $repository->findAll();
    }

    /**
     * @param $id
     * @return null|Category
     */
    public function get($id)
    {
        $repository = $this->getRepository();
        return $repository->find($id);
    }

    /**
     * @param $name
     * @return null|Category
     */
    public function getByName($name)
    {
        $repository = $this->getRepository();
        return $repository->findOneBy(
            array(
                'name' => $name
            )
        );
    }

    /**
     * @param $attributes
     * @throws \OpenCoders\Podb\Exception\MissingParameterException
     * @return Category
     */
    public function create($attributes)
    {
        $category = new Category();

        if (!isset($attributes['project'])) {
            throw new MissingParameterException('project');
        }

        foreach ($attributes as $key => $value) {
            if ($key === 'name') {
                $category->setName($value);
            } elseif ($key === 'description') {
                $category->setDescription($value);
            } elseif ($key === 'category') {
                $category->setCategory($value);
            } elseif ($key === 'project') {
                $category->setProject($this->projectRepository->get($value));
            }
        }

        $em = $this->getEntityManager();
        $em->persist($category);

        return $category;
    }

    /**
     * Update user
     *
     * @param $id
     * @param $attributes
     * @return null|Category
     */
    public function update($id, $attributes)
    {
        $category = $this->get($id);

        foreach ($attributes as $key => $value) {
            if ($key === 'name') {
                $category->setName($value);
            } elseif ($key === 'description') {
                $category->setDescription($value);
            } elseif ($key === 'category') {
                $category->setCategory($value);
            } elseif ($key === 'project') {
                $category->setProject($this->projectRepository->get($value));
            }
        }

        return $category;
    }
} 