<?php
/**
 * Created by PhpStorm.
 * User: nida.sharar
 * Date: 05/11/2018
 * Time: 15:31.
 */

namespace App\Security;

use App\Utils\JWTManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class JWTAuthenticator extends AbstractGuardAuthenticator
{
    public function getCredentials(Request $request)
    {
        // TODO: Implement getCredentials() method.
        $extractor = new JWTManager('Bearer', 'Authorization');

        $token = $extractor->extract($request);

        if (!$token) {
            return;
        }

        return $token;
    }

    public function onAuthenticationSuccess(
    Request $request,
    TokenInterface $token,
    $providerKey
  ) {
        // TODO: Implement onAuthenticationSuccess() method.
    }

    public function onAuthenticationFailure(
    Request $request,
    AuthenticationException $exception
  ) {
        // TODO: Implement onAuthenticationFailure() method.
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        // TODO: Implement getUser() method.
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        // TODO: Implement checkCredentials() method.
    }

    public function start(
    Request $request,
    AuthenticationException $authException = null
  ) {
        // TODO: Implement start() method.
    }

    public function supports(Request $request)
    {
        // TODO: Implement supports() method.
    }

    public function supportsRememberMe()
    {
        // TODO: Implement supportsRememberMe() method.
    }
}
