<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\InMemoryUser;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\HttpFoundation\RequestStack;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private UrlGeneratorInterface $urlGenerator;
    private HttpClientInterface $httpClient;
    private LoggerInterface $logger;

    private RequestStack $requestStack;

    public function __construct(UrlGeneratorInterface $urlGenerator, HttpClientInterface $httpClient, LoggerInterface $logger, RequestStack $requestStack)
    {
        $this->urlGenerator = $urlGenerator;
        $this->httpClient = $httpClient;
        $this->logger = $logger;
        $this->requestStack = $requestStack;
    }

    public function authenticate(Request $request): Passport
    {
        $username = $request->request->get('username', '');
        $password = $request->request->get('password', '');

        $request->getSession()->set(Security::LAST_USERNAME, $username);

        $this->logger->info('Intento de autenticación para el usuario: ' . $username);

        try {
            $response = $this->httpClient->request('POST', 'http://172.16.1.190:8080/api/loging/authenticate', [
                'json' => [
                    'usuario' => $username,
                    'clave' => $password,
                ],
            ]);

            $responseData = $response->toArray();
            $this->logger->info('Respuesta de la API: ' . json_encode($responseData));

            if ($responseData['CodigoResultado'] !== '000') {
                $this->logger->warning('Autenticación fallida: Código de resultado incorrecto');
                throw new AuthenticationException('Invalid credentials');
            }

            $this->logger->info('Autenticación exitosa para el usuario: ' . $username);

            return new SelfValidatingPassport(
                new UserBadge($username, function($userIdentifier) use ($responseData) {
                    $this->logger->info('Creando usuario en memoria para: ' . $userIdentifier);
                    
                    // Almacenar información adicional del usuario en la sesión
                    $this->requestStack->getSession()->set('user_data', $responseData);
                    
                    return new InMemoryUser($userIdentifier, null, ['ROLE_USER']);
                }),
                [
                    new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
                ]
            );
        } catch (\Exception $e) {
            $this->logger->error('Error durante la autenticación: ' . $e->getMessage(), ['exception' => $e]);
            throw new AuthenticationException('An error occurred during authentication: ' . $e->getMessage());
        }
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $this->logger->info('onAuthenticationSuccess llamado para el usuario: ' . $token->getUserIdentifier());
        
        // Asegurarse de que la información del usuario esté en la sesión
        if (!$request->getSession()->has('user_data')) {
            $request->getSession()->set('user_data', [
                'username' => $token->getUserIdentifier(),
                'roles' => $token->getRoleNames(),
            ]);
        }
        
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate('app_solicitud_index'));
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }

    public function supports(Request $request): bool
    {
        return $request->isMethod('POST') && $this->getLoginUrl($request) === $request->getPathInfo();
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        $url = $this->getLoginUrl($request);
        return new RedirectResponse($url);
    }
}