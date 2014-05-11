<?php

namespace OpenCoders\Podb\REST\v1\json;


use Exception;
use OpenCoders\Podb\Exception\PodbException;
use OpenCoders\Podb\Persistence\Entity\Language;
use OpenCoders\Podb\Persistence\Entity\Project;
use OpenCoders\Podb\Persistence\Entity\User;
use OpenCoders\Podb\REST\v1\BaseController;
use OpenCoders\Podb\Service\AuthenticationService;
use OpenCoders\Podb\Service\UserService;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController extends BaseController
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    function __construct(Application $app, UserService $userService, AuthenticationService $authenticationService)
    {
        parent::__construct($app);
        $this->userService = $userService;
        $this->authenticationService = $authenticationService;
    }

    /**
     * @return JsonResponse
     */
    public function getList()
    {
        $users = $this->userService->getList();
        $urlGenerator = $this->getUrlGenerator();
        $data = array();

        /** @var User $user */
        foreach ($users as $user) {
            $urlParams = array('userName' => $user->getUsername());
            $data[] = array(
                'id' => $user->getId(),
                'displayname' => $user->getDisplayName(),
                'username' => $user->getUsername(),
                '_links' => array(
                    'self' => $urlGenerator->generate('rest.v1.json.user.get', $urlParams),
                )
            );
        }

        return new JsonResponse($data);
    }

    /**
     * @param $userName
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function get($userName)
    {
        if ($this->isId($userName)) {
            $user = $this->userService->get($userName);
        } else {
            $user = $this->userService->getByName($userName);
        }

        if ($user == null) {
            throw new Exception("No user found with identifier $userName.", 404);
        }
        $urlGenerator = $this->getUrlGenerator();
        $urlParams = array('userName' => $user->getUsername());

        return new JsonResponse(array(
            'id' => $user->getId(),
            'displayname' => $user->getDisplayName(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'active' => $user->getActive(),
            '_links' => array(
                'self' => $urlGenerator->generate('rest.v1.json.user.get', $urlParams),
                'projects' => $urlGenerator->generate('rest.v1.json.user.project.list', $urlParams),
                'own_projects' => $urlGenerator->generate('rest.v1.json.user.own.project.list', $urlParams),
                'languages' => $urlGenerator->generate('rest.v1.json.user.language.list', $urlParams),
                'translations' => $urlGenerator->generate('rest.v1.json.user.translation.list', $urlParams),
            )
        ));
    }

    /**
     * Returns an array of related projects by the given user
     *
     * @param string|int $userName Username or ID of the user
     *
     * @throws \Exception
     * @return JsonResponse
     */
    public function getProjects($userName)
    {
        if ($this->isId($userName)) {
            $user = $this->userService->get($userName);
        } else {
            $user = $this->userService->getByName($userName);
        }

        if ($user == null) {
            throw new Exception("No user found with identifier $userName.", 404);
        }

        $data = array();
        /** @var Project $project */
        foreach ($user->getContributedProjects() as $project) {
            $data[] = $project->asShortArrayWithAPIInformation($this->apiVersion);
        }

        return new JsonResponse($data);
    }

    /**
     * Returns an array of projects owned by the user
     *
     * @param string|int $userName Username or ID of the user
     *
     * @throws \Exception
     * @return JsonResponse
     */
    public function getOwnedProjects($userName)
    {
        if ($this->isId($userName)) {
            $user = $this->userService->get($userName);
        } else {
            $user = $this->userService->getByName($userName);
        }

        if ($user == null) {
            throw new Exception("No user found with identifier $userName.", 404);
        }

        $data = array();
        /** @var $project Project */
        foreach ($user->getOwnedProjects() as $project) {
            $data[] = $project->asShortArrayWithAPIInformation($this->apiVersion);
        }

        return new JsonResponse($data);
    }

    /**
     * Returns an array with related languages of this user
     *
     * @param string|int $userName Username or ID of the user
     *
     * @throws \Exception
     * @return JsonResponse
     */
    public function getLanguages($userName)
    {
        if ($this->isId($userName)) {
            $user = $this->userService->get($userName);
        } else {
            $user = $this->userService->getByName($userName);
        }

        if ($user == null) {
            throw new Exception("No user found with identifier $userName.", 404);
        }

        $data = array();
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
     * @throws \Exception
     * @return JsonResponse
     */
    public function getTranslations($userName)
    {

        throw new Exception(501);
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
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @throws \Exception
     * @return JsonResponse
     */
    public function post(Request $request)
    {
        $this->authenticationService->ensureSession();
        $attributes = $request->request->all();
        try {
            $user = $this->userService->create($attributes);
            $this->userService->flush();
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), 400);
        };

        $urlGenerator = $this->getUrlGenerator();
        $urlParams = array('userName' => $user->getUsername());

        return new JsonResponse(array(
            'id' => $user->getId(),
            'displayname' => $user->getDisplayName(),
            'username' => $user->getUsername(),
            '_links' => array(
                'self' => $urlGenerator->generate('rest.v1.json.user.get', $urlParams),
            )
        ));
    }

    /**
     * Updates a User Object
     *
     * @param int $id
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @throws \Exception
     *
     * @return bool
     */
    public function put($id, Request $request)
    {
        $this->authenticationService->ensureSession();
        if (!$this->isId($id)) {
            throw new Exception('Invalid ID ' . $id, 400);
        }

        $attributes = $request->request->all();
        try {
            $user = $this->userService->update($id, $attributes);
            $this->userService->flush();
        } catch (PodbException $e) {
            // TODO
            throw new Exception($e->getMessage(), 400);
        }

        $urlGenerator = $this->getUrlGenerator();
        $urlParams = array('userName' => $user->getUsername());

        return new JsonResponse(array(
            'id' => $user->getId(),
            'displayname' => $user->getDisplayName(),
            'username' => $user->getUsername(),
            '_links' => array(
                'self' => $urlGenerator->generate('rest.v1.json.user.get', $urlParams),
            )
        ));
    }

    /**
     * Deletes the User by ID
     *
     * @param int $id
     *
     * @throws \Exception
     * @return array
     */
    public function delete($id)
    {
        $this->authenticationService->ensureSession();
        if (!$this->isId($id)) {
            throw new Exception('Invalid ID ' . $id, 400);
        }

        $this->userService->remove($id);
        $this->userService->flush();

        return new JsonResponse(array(
            'success' => true
        ));
    }

} 