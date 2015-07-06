<?php

namespace OpenCoders\Podb\Api;


use Doctrine\ORM\EntityManagerInterface;
use Exception;
use OpenCoders\Podb\AuthenticationService;
use OpenCoders\Podb\Exception\MissingParameterException;
use OpenCoders\Podb\Exception\PodbException;
use OpenCoders\Podb\Persistence\Entity\Language;
use OpenCoders\Podb\Persistence\Entity\Project;
use OpenCoders\Podb\Persistence\Entity\User;
use OpenCoders\Podb\Persistence\Repository\UserRepository;
use OpenCoders\Podb\Security\PasswordSaltGenerator;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class APIv1UserController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var \OpenCoders\Podb\AuthenticationService
     */
    private $authenticationService;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var MessageDigestPasswordEncoder
     */
    private $passwordEncoder;
    /**
     * @var PasswordSaltGenerator
     */
    private $passwordSaltGenerator;

    /**
     * @param UserRepository $userRepository
     * @param AuthenticationService $authenticationService
     * @param UrlGeneratorInterface $urlGenerator
     * @param EntityManagerInterface $entityManager
     * @param MessageDigestPasswordEncoder $passwordEncoder
     * @param PasswordSaltGenerator $passwordSaltGenerator
     */
    function __construct(
        UserRepository $userRepository,
        AuthenticationService $authenticationService,
        UrlGeneratorInterface $urlGenerator,
        EntityManagerInterface $entityManager,
        MessageDigestPasswordEncoder $passwordEncoder,
        PasswordSaltGenerator $passwordSaltGenerator
    )
    {
        $this->userRepository = $userRepository;
        $this->authenticationService = $authenticationService;
        $this->urlGenerator = $urlGenerator;
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->passwordSaltGenerator = $passwordSaltGenerator;
    }

    /**
     * @return JsonResponse
     */
    public function getList()
    {
        $users = $this->userRepository->getList();
        $data = array();

        /** @var User $user */
        foreach ($users as $user) {
            $urlParams = array('userName' => $user->getUsername());
            $data[] = array(
                'id' => $user->getId(),
                'displayName' => $user->getDisplayName(),
                'username' => $user->getUsername(),
                '_links' => array(
                    'self' => $this->urlGenerator->generate(ApiURIs::V1_USER_GET, $urlParams),
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
            $user = $this->userRepository->get($userName);
        } else {
            $user = $this->userRepository->getByName($userName);
        }

        if (!$user instanceof User) {
            throw new Exception("No user found with identifier $userName.", 404);
        }
        $urlParams = array('userName' => $user->getUsername());

        return new JsonResponse(array(
            'id' => $user->getId(),
            'displayName' => $user->getDisplayName(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'active' => $user->getActive(),
            '_links' => array(
                'self' => $this->urlGenerator->generate(ApiURIs::V1_USER_GET, $urlParams),
                'projects' => $this->urlGenerator->generate(ApiURIs::V1_USER_PROJECT_LIST, $urlParams),
                'own_projects' => $this->urlGenerator->generate(ApiURIs::V1_USER_PROJECT_OWN_LIST, $urlParams),
                'languages' => $this->urlGenerator->generate(ApiURIs::V1_USER_LANGUAGE_LIST, $urlParams),
                'translations' => $this->urlGenerator->generate(ApiURIs::V1_USER_TRANSLATION_LIST, $urlParams),
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
            $user = $this->userRepository->get($userName);
        } else {
            $user = $this->userRepository->getByName($userName);
        }

        if (!$user instanceof User) {
            throw new Exception("No user found with identifier $userName.", 404);
        }

        $data = array();
        /** @var Project $project */
        foreach ($user->getContributedProjects() as $project) {
            $urlParams = array(
                'projectName' => $project->getName()
            );
            $data[] =  array(
                'id' => $project->getId(),
                'name' => $project->getName(),
                '_links' => array(
                    'self' => $this->urlGenerator->generate(ApiURIs::V1_PROJECT_GET, $urlParams),
                    'html' => '', // @ToDo: Überlegen, was mit url_html gemeint war
                    'members' => $this->urlGenerator->generate(ApiURIs::V1_PROJECT_CONTRIBUTOR_LIST, $urlParams),
                    'languages' => $this->urlGenerator->generate(ApiURIs::V1_PROJECT_LANGUAGE_LIST, $urlParams)
                )
            );
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
            $user = $this->userRepository->get($userName);
        } else {
            $user = $this->userRepository->getByName($userName);
        }

        if (!$user instanceof User) {
            throw new Exception("No user found with identifier $userName.", 404);
        }

        $data = array();
        /** @var $project Project */
        foreach ($user->getOwnedProjects() as $project) {
            $urlParams = array(
                'projectName' => $project->getName()
            );
            $data[] = array(
                'id' => $project->getId(),
                'name' => $project->getName(),
                '_links' => array(
                    'self' => $this->urlGenerator->generate(ApiURIs::V1_PROJECT_GET, $urlParams),
                    'html' => '', // @ToDo: Überlegen, was mit url_html gemeint war
                    'members' => $this->urlGenerator->generate(ApiURIs::V1_PROJECT_CONTRIBUTOR_LIST, $urlParams),
                    'languages' => $this->urlGenerator->generate(ApiURIs::V1_PROJECT_LANGUAGE_LIST, $urlParams)
                )
            );
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
            $user = $this->userRepository->get($userName);
        } else {
            $user = $this->userRepository->getByName($userName);
        }

        if (!$user instanceof User) {
            throw new Exception("No user found with identifier $userName.", 404);
        }

        $data = array();
        /** @var $language Language */
        foreach ($user->getSupportedLanguages() as $language) {
            $data[] = array(
                'id' => $language->getId(),
                'name' => $language->getLabel(),
                '_links' => array(
                    'self' => $this->urlGenerator->generate(ApiURIs::V1_LANGUAGE_GET, array(
                        'locale' => $language->getLocale()
                    )),
//                    'url_projects' => $apiBaseUrl . '/' . $apiVersion . '/languages/' . $this->getLocale() . '/projects'
                )
            );
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

        $userName = $request->get('userName');
        if (!isset($userName)) {
            throw new MissingParameterException('userName');
        }
        $displayName = $request->get('displayName');
        if (!isset($displayName)) {
            throw new MissingParameterException('displayName');
        }
        $email = $request->get('email');
        if (!isset($email)) {
            throw new MissingParameterException('email');
        }
        $rawPassword = $request->get('password');
        if (!isset($rawPassword)) {
            throw new MissingParameterException('password');
        }

        $attributes = $request->request->all();
        try {
            $user = new User();
            $user->setUsername($userName);
            $user->setDisplayName($displayName);
            $user->setActive(true);// TODO FEATURE konfigurierbar machen
            $user->setEmailValidated(true);// TODO FEATURE konfigurierbar machen
            $user->setValidated(true);// TODO FEATURE konfigurierbar machen
            $user->setEmail($email);

            $salt = $this->passwordSaltGenerator->generate();
            $user->setSalt($salt);
            $password = $this->passwordEncoder->encodePassword($rawPassword, $salt);
            $user->setPassword($password);


            foreach ($attributes as $key => $value) {
                if ($key === 'company') {
                    $user->setCompany($value);
                } else if ($key === 'publicEMail') {
                    $user->setPublicEMail($value);
                } else if ($key === 'supportedLanguages') {
                    $user->setSupportedLanguages($value);
                } else if ($key === 'emailValidated') {
                    $user->setEmailValidated($value);
                }
            }

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), 400);
        };

        $urlParams = array('userName' => $user->getUsername());

        return new JsonResponse(array(
            'id' => $user->getId(),
            'displayName' => $user->getDisplayName(),
            'username' => $user->getUsername(),
            '_links' => array(
                'self' => $this->urlGenerator->generate(ApiURIs::V1_USER_GET, $urlParams),
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
            $user = $this->userRepository->get($id);

            foreach ($attributes as $key => $value) {
                if ($key === 'displayName') {
                    $user->setDisplayName($value);
                } else if ($key === 'email') {
                    $user->setEmail($value);
                } else if ($key === 'password') {
                    $user->setPassword(sha1($value));
                } else if ($key === 'active') {
                    $user->setActive($value);
                } else if ($key === 'company') {
                    $user->setCompany($value);
                } else if ($key === 'publicEMail') {
                    $user->setPublicEMail($value);
                } else if ($key === 'supportedLanguages') {
                    $user->setSupportedLanguages($value);
                } else if ($key === 'emailValidated') {
                    $user->setEmailValidated($value);
                }
            }

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (PodbException $e) {
            // TODO
            throw new Exception($e->getMessage(), 400);
        }

        $urlParams = array('userName' => $user->getUsername());

        return new JsonResponse(array(
            'id' => $user->getId(),
            'displayName' => $user->getDisplayName(),
            'username' => $user->getUsername(),
            '_links' => array(
                'self' => $this->urlGenerator->generate(ApiURIs::V1_USER_GET, $urlParams),
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

        $user = $this->userRepository->get($id);

        $this->entityManager->remove($id);
        $this->entityManager->flush();

        return new JsonResponse(array(
            'success' => true
        ));
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return array
     * @throws MissingParameterException
     * @throws \OpenCoders\Podb\Exception\EmptyParameterException
     */
    public function register(Request $request)
    {
        $userName = $request->get('userName');
        if (!isset($userName)) {
            throw new MissingParameterException('userName');
        }
        $displayName = $request->get('displayName');
        if (!isset($displayName)) {
            throw new MissingParameterException('displayName');
        }
        $email = $request->get('email');
        if (!isset($email)) {
            throw new MissingParameterException('email');
        }
        $rawPassword = $request->get('password');
        if (!isset($rawPassword)) {
            throw new MissingParameterException('password');
        }

        $user = new User();
        $user->setUsername($userName);
        $user->setDisplayName($displayName);
        $user->setActive(true);// TODO FEATURE konfigurierbar machen
        $user->setEmailValidated(true);// TODO FEATURE konfigurierbar machen
        $user->setValidated(true);// TODO FEATURE konfigurierbar machen
        $user->setEmail($email);

        $salt = $this->passwordSaltGenerator->generate();
        $user->setSalt($salt);
        $password = $this->passwordEncoder->encodePassword($rawPassword, $salt);
        $user->setPassword($password);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $urlParams = array('userName' => $user->getUsername());

        return new JsonResponse(array(
            'id' => $user->getId(),
            'displayName' => $user->getDisplayName(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'active' => $user->getActive(),
            '_links' => array(
                'self' => $this->urlGenerator->generate(ApiURIs::V1_USER_GET, $urlParams),
                'projects' => $this->urlGenerator->generate(ApiURIs::V1_USER_PROJECT_LIST, $urlParams),
                'own_projects' => $this->urlGenerator->generate(ApiURIs::V1_USER_PROJECT_OWN_LIST, $urlParams),
                'languages' => $this->urlGenerator->generate(ApiURIs::V1_USER_LANGUAGE_LIST, $urlParams),
                'translations' => $this->urlGenerator->generate(ApiURIs::V1_USER_TRANSLATION_LIST, $urlParams),
            )
        ));
    }

    /**
     * Returns true, if $value is an integer
     *
     * @param $value
     * @return bool
     */
    protected function isId($value)
    {
        return isset($value) && intval($value) != 0;
    }
}