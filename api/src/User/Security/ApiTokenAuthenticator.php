<?php

namespace App\User\Security;

use App\User\Repository\ApiTokenRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class ApiTokenAuthenticator extends AbstractGuardAuthenticator
{
    private ApiTokenRepository $apiTokens;

    public function __construct(ApiTokenRepository $apiTokens)
    {
        $this->apiTokens = $apiTokens;
    }

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('X-API-TOKEN');
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return null;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = [
            'code' => 'api_token_required',
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);

    }

    public function getCredentials(Request $request)
    {
        return $request->headers->get('X-API-TOKEN');
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $this->apiTokens->findUserByToken($credentials);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
