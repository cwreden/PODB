<?php

namespace OpenCoders\Podb\Api\v1;

use Luracast\Restler\RestException;
use OpenCoders\Podb\Api\AbstractBaseApi;
use OpenCoders\Podb\Persistence\Entity\Language;
use OpenCoders\Podb\Persistence\Entity\Project;
use OpenCoders\Podb\Persistence\Entity\User;
use OpenCoders\Podb\Exception\PodbException;
use OpenCoders\Podb\Api\ApiUrl;

class Users extends AbstractBaseApi
{
    /**
     * @var string EntityClassName (FQN)
     */
    protected $entityName = 'OpenCoders\Podb\Persistence\Entity\User';

    /**
     * Returns an array of shortened user information arrays
     *
     * @url GET /users
     *
     * @return array
     */
    public function getList()
    {
        $data = array();

        $repository = $this->getRepository();
        $users = $repository->findAll();

        /** @var User $user */
        foreach ($users as $user) {
            $data[] = $user->asShortArrayWithAPIInformation($this->apiVersion);
        }

        return $data;
    }

    /**
     * Returns a array with specific user information
     *
     * @param string|int $userName Username or ID of the user
     *
     * @url GET /users/:userName
     *
     * @throws RestException
     *
     * @return array
     */
    public function get($userName)
    {
        $user = $this->getUser($userName);

        if ($user == null) {
            throw new RestException(404, "No user found with identifier $userName.");
        }
        return $user->asArrayWithAPIInformation($this->apiVersion);
    }

    /**
     * Returns an array of related projects of the user
     *
     * @param string|int $userName Username or ID of the user
     *
     * @url GET /users/:userName/projects
     *
     * @throws \Luracast\Restler\RestException
     *
     * @return array
     */
    public function getProjects($userName)
    {
        $data = array();

        $user = $this->getUser($userName);

        if ($user == null) {
            throw new RestException(404);
        }

        /** @var $project Project */
        foreach ($user->getContributedProjects() as $project) {
            $data[] = $project->asShortArrayWithAPIInformation($this->apiVersion);
        }

        return $data;
    }

    /**
     * Returns an array of projects owned by the user
     *
     * @param string|int $userName Username or ID of the user
     *
     * @url GET /users/:userName/own/projects
     *
     * @throws RestException
     *
     * @return array
     */
    public function getOwnedProjects($userName)
    {
        $data = array();

        $user = $this->getUser($userName);

        if ($user == null) {
            throw new RestException(404);
        }

        /** @var $project Project */
        foreach ($user->getOwnedProjects() as $project) {
            $data[] = $project->asShortArrayWithAPIInformation($this->apiVersion);
        }

        return $data;
    }

    /**
     * Returns an array with related languages of this user
     *
     * @param string|int $userName Username or ID of the user
     *
     * @url GET /users/:userName/languages
     *
     * @throws \Luracast\Restler\RestException
     *
     * @return array
     */
    public function getLanguages($userName)
    {
        $data = array();
        $user = $this->getUser($userName);

        if ($user == null) {
            throw new RestException(404);
        }

        /** @var $language Language */
        foreach ($user->getSupportedLanguages() as $language) {
            $data[] = $language->asShortArrayWithAPIInformation($this->apiVersion);
        }

        return $data;
    }

    /**
     * Returns an array with related translations of this user
     *
     * @param string|int $userName Username or ID of the user
     *
     * @url GET /users/:userName/translations
     *
     * @throws \Luracast\Restler\RestException
     *
     * @return array
     */
    public function getTranslations($userName)
    {

        throw new RestException(501);
        $baseUrl = ApiUrl::getBaseApiUrl();

        return array(
            array(
                'id' => 123456789,
                'language' => 'en_US',
                'msg_str' => 'test',
                'msg_str1' => '',
                'msg_str2' => '',
                'fuzzy' => true,
                'created_at' => 12345678,
                'modified_at' => 12345678,
                'url_dataset' => $baseUrl . "/{$this->apiVersion}/datasets/123456789",
                'url_created_by' => $baseUrl . "/{$this->apiVersion}/users/dax",
                'url_modified_by' => $baseUrl . "/{$this->apiVersion}/users/dax",
            ),
            array(
                'id' => 123456789,
                'language' => 'en_US',
                'msg_str' => 'test',
                'msg_str1' => '',
                'msg_str2' => '',
                'fuzzy' => true,
                'created_at' => 12345678,
                'modified_at' => 12345678,
                'url_dataset' => $baseUrl . "/{$this->apiVersion}/datasets/123456789",
                'url_created_by' => $baseUrl . "/{$this->apiVersion}/users/dax",
                'url_modified_by' => $baseUrl . "/{$this->apiVersion}/users/dax",
            ),
            array(
                'id' => 123456789,
                'language' => 'en_US',
                'msg_str' => 'test',
                'msg_str1' => '',
                'msg_str2' => '',
                'fuzzy' => true,
                'created_at' => 12345678,
                'modified_at' => 12345678,
                'url_dataset' => $baseUrl . "/{$this->apiVersion}/datasets/123456789",
                'url_created_by' => $baseUrl . "/{$this->apiVersion}/users/dax",
                'url_modified_by' => $baseUrl . "/{$this->apiVersion}/users/dax",
            ),
            array(
                'id' => 123456789,
                'language' => 'en_US',
                'msg_str' => 'test',
                'msg_str1' => '',
                'msg_str2' => '',
                'fuzzy' => true,
                'created_at' => 12345678,
                'modified_at' => 12345678,
                'url_dataset' => $baseUrl . "/{$this->apiVersion}/datasets/123456789",
                'url_created_by' => $baseUrl . "/{$this->apiVersion}/users/dax",
                'url_modified_by' => $baseUrl . "/{$this->apiVersion}/users/dax",
            ),
        );
    }

    /**
     * Creates a new user object by given data
     *
     * @param array $request_data
     *
     * @url POST /users
     * @protected
     * @status 201
     *
     * @throws \Luracast\Restler\RestException
     *
     * @return array
     */
    public function post(array $request_data = NULL)
    {
        try {
            $user = new User($request_data);
            $em = $this->getEntityManager();
            $em->persist($user);
            $em->flush();
        } catch (\Exception $e) {
            throw new RestException(400, $e->getMessage());
        };

        return $user->asArrayWithAPIInformation($this->apiVersion);
    }

    /**
     * Updates a User Object
     *
     * @param int $id
     * @param array $request_data
     *
     * @url PUT /users/:id
     * @protected
     *
     * @throws RestException
     *
     * @return bool
     */
    public function put($id, array $request_data = array())
    {
        if (!$this->isId($id)) {
            throw new RestException(400, 'Invalid ID ' . $id);
        }

        /** @var $user User */
        $user = $this->getUser($id);

        try {
            $user->update($request_data);
            $em = $this->getEntityManager();
            $em->persist($user);
            $em->flush();
        } catch (PodbException $e) {
            throw new RestException(400, $e->getMessage());
        }

        return $user->asArrayWithAPIInformation($this->apiVersion);
    }

    /**
     * Deletes the User by ID
     *
     * @param int $id
     *
     * @url DELETE /users/:id
     * @protected
     *
     * @throws \Luracast\Restler\RestException
     *
     * @return array
     */
    public function delete($id)
    {
        if (!$this->isId($id)) {
            throw new RestException(400, 'Invalid ID ' . $id);
        }

        $em = $this->getEntityManager();
        $user = $em->getPartialReference($this->entityName, array('id' => $id));
        $em->remove($user);
        $em->flush();

        return array(
            'success' => true
        );
    }

    /**
     * @param array $request_data
     *
     * @throws \Luracast\Restler\RestException
     * @url POST /user/register
     *
     * @return array
     */
    public function register(array $request_data = NULL)
    {
        try {
            $user = new User($request_data);
            $em = $this->getEntityManager();
            $em->persist($user);
            $em->flush();
        } catch (PodbException $e){
            throw new RestException(400, $e->getMessage());
        };

        return array(
           'success' => true
        );
    }

    /**
     * Returns the User Object
     *
     * @param string|int $userName Username or ID of the user
     *
     * @return User
     */
    private function getUser($userName)
    {
        $repository = $this->getRepository();
        /**
         * @var $user User
         */
        if ($this->isId($userName)) {
            $user = $repository->find($userName);
        } else {
            $user = $repository->findOneBy(
                array(
                    'username' => $userName
                )
            );
        }
        return $user;
    }

} 