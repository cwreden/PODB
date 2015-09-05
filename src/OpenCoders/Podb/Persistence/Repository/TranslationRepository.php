<?php

namespace OpenCoders\Podb\Persistence\Repository;

use Doctrine\ORM\EntityRepository;
use OpenCoders\Podb\Persistence\Entity\Language;
use OpenCoders\Podb\Persistence\Entity\Project;
use OpenCoders\Podb\Persistence\Entity\Translation;

class TranslationRepository extends EntityRepository
{

    /**
     * @param Project $project
     * @param Language $language
     * @return \OpenCoders\Podb\Persistence\Entity\Translation[]
     */
    public function getListByProjectAndLanguage(Project $project, Language $language)
    {
        // TODO

        $query = $this->createQueryBuilder('t');
        $query->select('t.id')
            ->leftJoin('t.language', 'l')
            ->leftJoin('t.message', 'm')
            ->leftJoin('m.project', 'p')
            ->where('l.id = :languageId')
            ->andWhere('p.id = :projectId')
            ->setParameter('languageId', $language->getId())
            ->setParameter('projectId', $project->getId());

        $result = $query->getQuery()->execute();
        $entities = array();
        foreach ($result as $row) {
            $entity = $this->find($row['id']);
            if (!$entity instanceof Translation) {
                continue;
            }
            $entities[] = $entity;
        }

        return $entities;
    }

    /**
     * @param $id
     * @return null|Translation
     */
    public function get($id)
    {
        return $this->find($id);
    }
}
