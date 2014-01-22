<?php

namespace OpenCoders\Podb\Api\v1;


use Luracast\Restler\RestException;
use OpenCoders\Podb\Api\AbstractBaseApi;
use OpenCoders\Podb\Api\ApiUrl;
use OpenCoders\Podb\Persistence\Doctrine;

/**
 * Class Audit
 * @package OpenCoders\Podb\Api\v1
 *
 * @protected
 */
class Audit extends AbstractBaseApi {

    private $pageSize = 25;

    /**
     * @param int $page
     *
     * @url GET /revisions
     *
     * @return array
     */
    public function getList($page = 1)
    {
        $data = array();

        $auditReader = $this->getAuditReader();
        $revisions = $auditReader->findRevisionHistory($this->pageSize, $this->pageSize * ($page - 1));

        foreach ($revisions as $revision) {
            $data[] = array_merge(
                array(
                    'id' => $revision->getRev(),
                    'timestamp' => $revision->getTimestamp(),
                    'username' => $revision->getUsername(),
                ),
                $this->getRevisionAPIInformation($revision->getRev(), $revision->getUsername())
            );
        }

        return $data;
    }

    /**
     * @param $rev
     *
     * @url GET /revisions/:rev
     *
     * @throws \Luracast\Restler\RestException
     * @return array
     */
    public function getRevision($rev)
    {
        $auditReader = $this->getAuditReader();
        $revision = $auditReader->findRevision($rev);

        if (!$revision) {
            throw new RestException(404, sprintf('Revision %i not found', $rev));
        }

        $changedEntities = $auditReader->findEntitesChangedAtRevision($rev);

        $changes = array();

        foreach ($changedEntities as $changedEntity) {
            $refClass = new \ReflectionClass($changedEntity->getClassName());
            $className = $refClass->getShortName();
            $changes[] = array_merge(
                array(
                    'id' => $changedEntity->getId()['id'],
                    'className' => $className,
                    'revisionType' => $changedEntity->getRevisionType()
                ),
                $this->getAPIEntityURL($className, $changedEntity->getId()['id'])
            );
        }

        return array_merge(
            array(
                'id' => $revision->getRev(),
                'changes' => $changes
            ),
            $this->getRevisionAPIInformation($revision->getRev(), $revision->getUsername())
        );
    }

    /**
     * @param $className
     * @param $id
     *
     * @url GET /entities/:className/:id
     *
     * @throws \Luracast\Restler\RestException
     * @return array
     */
    public function getEntity($className, $id)
    {
        if (!$this->isId($id)) {
            throw new RestException(400, 'Invalid ID ' . $id);
        }

        $data = array();

        $fqn = $this->getFQN($className);
        $revisions = $this->getAuditReader()->findRevisions($fqn, $id);

        foreach ($revisions as $revision) {
            $data[] = array_merge(
                array(
                    'id' => $revision->getRev(),
                    'timestamp' => $revision->getTimestamp(),
                    'username' => $revision->getUsername(),
                ),
                $this->getRevisionAPIInformation($revision->getRev(), $revision->getUsername()),
                $this->getAPIDetailURL($className, $id, $revision->getRev())
            );
        }


        return $data;
    }

    /**
     * @param $className
     * @param $id
     * @param $rev
     *
     * @url GET /entities/:className/:id/:rev
     *
     * @throws \Luracast\Restler\RestException
     * @return array
     */
    public function getDetail($className, $id, $rev)
    {
        if (!$this->isId($id)) {
            throw new RestException(400, 'Invalid ID ' . $id);
        }

        $fqn = $this->getFQN($className);
        $entity = $this->getAuditReader()->find($fqn, $id, $rev);

        $data = $this->getAuditReader()->getEntityValues($fqn, $entity);
        krsort($data);

        if (isset($data['password'])) {
            $data['password'] = '*****';
        }

        return array_merge(
            array(
                'id' => $id,
                'rev' => $rev,
                'className' => $className,
                'data' => $data,
            ),
            $this->getRevisionAPIInformation($rev, null),
            $this->getAPIEntityURL($className, $id),
            $this->getAPIDetailURL($className, $id, $rev)
        );
    }

    /**
     * @param $className
     * @param $id
     * @param $rev1
     * @param $rev2
     *
     * @url GET /entities/:className/:id/:rev1/diff/:rev2
     *
     * @throws \Luracast\Restler\RestException
     */
    public function diff($className, $id, $rev1, $rev2)
    {
        throw new RestException(501);
    }

    /**
     * @return \SimpleThings\EntityAudit\AuditReader
     */
    private function getAuditReader()
    {
        return Doctrine::getAuditManager()->createAuditReader(Doctrine::getEntityManager());
    }

    /**
     * @param $rev      Int Revision ID
     * @param $username String Username who changed the entity
     *
     * @return array
     */
    private function getRevisionAPIInformation($rev, $username)
    {
        $baseUrl = $this->getBaseURL();

        $info = array(
            'url_revision' => $baseUrl . '/' . $this->apiVersion . '/audit/revisions/' . $rev,
        );

        if ($username) {
            $info['url_user'] = $baseUrl . '/' . $this->apiVersion . '/users/' . $username;
        }

        return $info;
    }

    /**
     * @param $className String Short class name
     * @param $id        Int    Entity ID
     *
     * @return string
     */
    private function getAPIEntityURL($className, $id)
    {
        $baseUrl = $this->getBaseURL();

        return array(
            'url_audit_entity' => $baseUrl . '/' . $this->apiVersion . '/audit/entities/' . $className . '/' . $id
        );
    }

    /**
     * @param $className String  Short class name
     * @param $id        Int     Entity ID
     * @param $rev       Int     Revision ID
     *
     * @return array
     */
    private function getAPIDetailURL($className, $id, $rev)
    {
        $baseUrl = $this->getBaseURL();

        return array(
            'url_audit_detail' => $baseUrl . '/' . $this->apiVersion . '/audit/entities/' . $className . '/' . $id . '/' . $rev
        );
    }

    /**
     * @return string
     */
    private function getBaseURL()
    {
        return ApiUrl::getBaseApiUrl();
    }

    private function getFQN($className)
    {
        return 'OpenCoders\Podb\Persistence\Entity\\' . $className;
    }

} 