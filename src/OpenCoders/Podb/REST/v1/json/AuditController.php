<?php

namespace OpenCoders\Podb\REST\v1\json;


use OpenCoders\Podb\Service\AuditService;
use SimpleThings\EntityAudit\Revision;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AuditController
{

    /**
     * @var AuditService
     */
    private $auditService;

    function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getList(Request $request)
    {
        $limit = 20;
        $offset = 0;
        if ($request->get('limit') !== null) {
            $limit = (int) $request->get('limit');
        }
        if ($request->get('offset') !== null) {
            $offset = (int) $request->get('offset');
        }
        $revisions = $this->auditService->getAll($limit, $offset);
        $data = array();

        foreach ($revisions as $revision) {
            $changedEntities = $this->auditService->getChangedEntitiesByRevision($revision->getRev());
            $entities = array();

            foreach ($changedEntities as $changedEntity) {
                $entities[] = array(
                    'id' => $changedEntity->getId(),
                    'class' => $changedEntity->getClassName(),
                    'revisionType' => $changedEntity->getRevisionType(),
                );
            }

            $data[] = array(
                'id' => $revision->getRev(),
                'timestamp' => $revision->getTimestamp(),
                'username' => $revision->getUsername(),
                'entities' => $entities
            );
        }

        return new JsonResponse($data);
    }

    /**
     * @param $className
     * @param $id
     * @return JsonResponse
     */
    public function getEntityRevisions($className, $id)
    {
        $revisions = $this->auditService->getRevisions($className, $id);
        $data = array();
        /** @var Revision $revision */
        foreach ($revisions as $revision) {
            $data[] = array(
                'id' => $revision->getRev(),
                'timestamp' => $revision->getTimestamp(),
                'username' => $revision->getUsername(),
            );
        }
        return new JsonResponse($data);
    }

    /**
     * @param $className
     * @param $id
     * @return JsonResponse
     */
    public function getCurrentRevision($className, $id)
    {
        $revision = $this->auditService->getCurrentRevision($className, $id);
        return new JsonResponse(array(
            'id' => $revision->getRev(),
            'timestamp' => $revision->getTimestamp(),
            'username' => $revision->getUsername(),
        ));
    }

    /**
     * @param $className
     * @param $id
     * @return JsonResponse
     */
    public function getFirstRevision($className, $id)
    {
        $revision = $this->auditService->getFirstRevision($className, $id);
        return new JsonResponse(array(
            'id' => $revision->getRev(),
            'timestamp' => $revision->getTimestamp(),
            'username' => $revision->getUsername(),
        ));
    }

    /**
     * @param $className
     * @param $id
     * @param $oldRevisionId
     * @param $newRevisionId
     * @return JsonResponse
     */
    public function getDiff($className, $id, $oldRevisionId, $newRevisionId)
    {
        $diff = $this->auditService->getDiff($className, $id, $oldRevisionId, $newRevisionId);
        if (isset($diff['password'])) {
            $diff['password'] = 'N/A';
        }
        return new JsonResponse($diff);
    }
}
