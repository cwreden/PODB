<?php

namespace OpenCoders\Podb\REST\v1\json;


use OpenCoders\Podb\AuthenticationService;
use OpenCoders\Podb\Exception\AlreadyAuthenticatedException;
use OpenCoders\Podb\Exception\MissingParameterException;
use OpenCoders\Podb\REST\v1\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AuthenticationController extends BaseController
{
    /**
     * @var \OpenCoders\Podb\AuthenticationService
     */
    private $authenticationService;

    function __construct($app, AuthenticationService $authenticationService)
    {
        parent::__construct($app);
        $this->authenticationService = $authenticationService;
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
        } else if (!$request->request->has('password')) {
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
     * @return JsonResponse
     */
    public function logout()
    {
        $this->authenticationService->logout();
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
     */
    public function unlock(Request $request)
    {
        $this->authenticationService->ensureSession();

        if (!$request->request->has('password')) {
            throw new MissingParameterException('password');
        }

        $this->authenticationService->unlockSession($request->request->get('password'));
        return array(
            'success' => true
        );
    }
} 