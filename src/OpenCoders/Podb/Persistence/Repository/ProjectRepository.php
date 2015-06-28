<?php

namespace OpenCoders\Podb\Persistence\Repository;

use Doctrine\ORM\EntityRepository;
use OpenCoders\Podb\Exception\DeprecatedException;
use OpenCoders\Podb\Persistence\Entity\Project;

class ProjectRepository extends EntityRepositoryAbstract
{

    /**
     * @return Project[]
     */
    public function getAll()
    {
        return $this->findAll();
    }

    /**
     * @param $id
     * @return null|Project
     */
    public function get($id)
    {
        return $this->find($id);
    }

    /**
     * @param $name
     * @return null|Project
     */
    public function getByName($name)
    {
        return $this->findOneBy(
            array(
                'name' => $name
            )
        );
    }

    /**
     * @param $attributes
     * @return Project
     * @throws MissingParameterException
     */
    public function create($attributes)
    {
        throw new DeprecatedException();
        $project = new Project();

        if (!isset($attributes['default_language'])) {
            throw new MissingParameterException('default_language');
        } elseif (!isset($attributes['owner'])) {
            throw new MissingParameterException('owner');
        }

        foreach ($attributes as $key => $value) {
            if ($key === 'name') {
                $project->setName($value);
            } else if ($key === 'description') {
                $project->setDescription($value);
            } else if ($key === 'private') {
                $project->setPrivate($value);
            } else if ($key === 'blog') {
                $project->setUrl(sha1($value));
            } elseif ($key === 'owner') {
                $project->setOwner($value);
            } elseif ($key === 'contributors') {
                // TODO
//                $project->setContributors($value);
            } elseif ($key === 'default_language') {
                $project->setDefaultLanguage($this->languageRepository->get($value));
            }
        }

        $em = $this->getEntityManager();
        $em->persist($project);

        return $project;
    }

    /**
     * Update user
     *
     * @param $id
     * @param $attributes
     * @return null|Project
     */
    public function update($id, $attributes)
    {
        throw new DeprecatedException();
        $project = $this->get($id);

        foreach ($attributes as $key => $value) {
            if ($key === 'name') {
//                $project->setName($value);
            } else if ($key === 'description') {
                $project->setDescription($value);
            } else if ($key === 'private') {
                $project->setPrivate($value);
            } else if ($key === 'blog') {
                $project->setUrl(sha1($value));
            } elseif ($key === 'default_language') {
                $project->setDefaultLanguage($this->languageRepository->get($value));
            }
        }

        return $project;
    }
}