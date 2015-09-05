<?php

namespace OpenCoders\Podb\Persistence;

use SimpleThings\EntityAudit\AuditReader;
use SimpleThings\EntityAudit\ChangedEntity;
use SimpleThings\EntityAudit\Revision;

class AuditRevisionManager
{
    /**
     * @var AuditReader
     */
    private $auditReader;

    public function __construct($auditReader)
    {
        $this->auditReader = $auditReader;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return Revision[]
     */
    public function getAll($limit = 20, $offset = 0)
    {
        return $this->auditReader->findRevisionHistory($limit, $offset);
    }

    /**
     * @param $className
     * @param $id
     * @return Revision[]
     */
    public function getRevisions($className, $id)
    {
        return $this->auditReader->findRevisions($this->getFQN($className), $id);
    }

    /**
     * @param $className
     * @param $id
     * @return Revision
     */
    public function getCurrentRevision($className, $id)
    {
        return $this->auditReader->findRevision($this->auditReader->getCurrentRevision($this->getFQN($className), $id));
    }

    /**
     * @param $className
     * @param $id
     * @return Revision
     */
    public function getFirstRevision($className, $id)
    {
        $revisions = $this->getRevisions($className, $id);
        return $revisions[count($revisions) - 1];
    }

    /**
     * @param $revisionId
     * @return ChangedEntity[]
     */
    public function getChangedEntitiesByRevision($revisionId)
    {
        return $this->auditReader->findEntitiesChangedAtRevision($revisionId);
    }

    public function getDiff($className, $id, $oldRevisionId, $newRevisionId)
    {
        return $this->auditReader->diff($this->getFQN($className), $id, $oldRevisionId, $newRevisionId);
    }

    /**
     * @param $className
     * @return string
     */
    private function getFQN($className)
    {
        return 'OpenCoders\Podb\Persistence\Entity\\' . ucfirst(strtolower($className));
    }
}
