<?php

namespace OpenCoders\Podb\REST\v1\json;

use OpenCoders\Podb\AuthenticationService;
use OpenCoders\Podb\Exception\AlreadyAuthenticatedException;
use OpenCoders\Podb\Exception\MissingParameterException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class AuthenticationController
 * @package OpenCoders\Podb\REST\v1\json
 * @deprecated silex security
 */
class AuthenticationController
{
    /**
     * @var \OpenCoders\Podb\AuthenticationService
     */
    private $authenticationService;
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @param AuthenticationService $authenticationService
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(AuthenticationService $authenticationService, TokenStorageInterface $tokenStorage)
    {
        $this->authenticationService = $authenticationService;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param Request $request
     *
     * @throws \OpenCoders\Podb\Exception\AlreadyAuthenticatedException
     * @throws \OpenCoders\Podb\Exception\MissingParameterException
     *
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        if ($this->authenticationService->isAuthenticated()) {
            throw new AlreadyAuthenticatedException();
        }

        if (!$request->request->has('username')) {
            throw new MissingParameterException('username');
        } elseif (!$request->request->has('password')) {
            throw new MissingParameterException('password');
        }

        $username = $request->request->get('username');
        $password = $request->request->get('password');

        $user = $this->authenticationService->authenticateUser($username, $password);

        return new JsonResponse(array(
            'success' => true,
            'displayName' => $user->getDisplayName()
        ));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $this->authenticationService->logout();
        $this->tokenStorage->setToken(null);
        $request->getSession()->invalidate();
        return new JsonResponse(array(
            'success' => true
        ));
    }

    /**
     *
     * @return JsonResponse
     */
    public function isLoggedIn()
    {
        $responseData = array(
            'isLoggedIn' => $this->authenticationService->isAuthenticated()
        );
        if ($responseData['isLoggedIn']) {
            $currentUser = $this->authenticationService->getCurrentUser();
            $responseData['username'] = $currentUser->getUsername();
            $responseData['displayName'] = $currentUser->getDisplayName();
        }

        return new JsonResponse($responseData);
    }

    /**
     * @url POST /lock
     *
     */
    public function lock()
    {
        $this->authenticationService->lockSession();
        return array(
            'success' => true
        );
    }

    /**
     * @url POST /unlock
     * @param Request $request
     * @return array
     * @throws MissingParameterException
     * @throws \OpenCoders\Podb\Exception\AuthenticationRequiredException
     * @throws \OpenCoders\Podb\Exception\InvalidUsernamePasswordCombinationException
     */
    public function unlock(Request $request)
    {
        if (!$request->request->has('password')) {
            throw new MissingParameterException('password');
        }

        $this->authenticationService->unlockSession($request->request->get('password'));
        return array(
            'success' => true
        );
    }
}
