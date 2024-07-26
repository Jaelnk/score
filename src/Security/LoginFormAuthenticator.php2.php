<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    private RouterInterface $router;
    private HttpClientInterface $httpClient;

    public const LOGIN_ROUTE = 'app_login';

    public function __construct(RouterInterface $router, HttpClientInterface $httpClient)
    {
        $this->router = $router;
        $this->httpClient = $httpClient;
    }

    public function authenticate(Request $request): Passport
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        error_log('Username: ' . $username);

        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $username);

        error_log('ANTES XXXXXXXXXXXXXXXXXUsername exitoSSSSSSSSSSSSSAAAAAAA: ' . $username);

        try {
            $response = $this->httpClient->request('POST', 'https://172.16.1.236:8443/api/loging/authenticate', [
                'json' => [
                    'usuario' => $username,
                    'clave' => $password,
                ],
            ]);

            $responseData = $response->toArray();

            if ($responseData['CodigoResultado'] !== '000') {
                throw new AuthenticationException('Invalid credentials');
            }
            
            error_log('XXXXXXXXXXXXXXXXXUsername exitoSSSSSSSSSSSSSAAAAAAA: ' . $username);
            error_log('XXXXXXXXXXXXXXXXX TOKEN exitoSSSSSSSSSSSSSAAAAAAA: ' . $request->request->get('_csrf_token'));

            return new Passport(
                new UserBadge($username),
                new PasswordCredentials($password),
                [
                    new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
                    new RememberMeBadge(),
                ]
            );
        } catch (\Exception $e) {
            error_log('XXXXXXXXXXXXXXXXX ERRORRRRRRRRRRRR: ' . $e->getMessage());
            throw new AuthenticationException('An error occurred during authentication');
        }
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        error_log('XXXXXXXXXXXXXXXXXXXXXXonAuthenticationSuccessXXXXXXXXXXXX');
        // error_log('Request Info: ' . print_r($request->request->all(), true));
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }
        return new RedirectResponse(
            $this->router->generate('app_tpersonainfo_index')
        );
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->router->generate(self::LOGIN_ROUTE);
    }
}
