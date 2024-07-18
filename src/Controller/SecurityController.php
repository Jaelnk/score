<?php

namespace App\Controller;

use App\Service\LogoutService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Security;
use Psr\Log\LoggerInterface;

class SecurityController extends AbstractController
{
    private $logoutService;
    private $security;
    private $logger;

    public function __construct(LogoutService $logoutService, Security $security, LoggerInterface $logger)
    {
        $this->logoutService = $logoutService;
        $this->security = $security;
        $this->logger = $logger;
    }

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $this->logger->info('XXXXXXXXXXXXXXXXXXXXXXX User logged in XXXXXXXXXXXXXXXXXXX');
        $this->logger->info('User logged in', ['username' => $lastUsername]);

        if ($error) {
            $this->logger->warning('Failed login attempt', [
                'username' => $lastUsername,
                'error' => $error->getMessage()
            ]);
        } else {
            $this->logger->info('Successful login', ['username' => $lastUsername]);
        }

        return $this->render('security/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): Response
    {
        $user = $this->security->getUser();

        // Log the logout attempt
        $this->logger->info('Logout attempt', [
            'username' => $user ? $user->getUserIdentifier() : 'Unknown user'
        ]);
       

        $this->logger->info('XXXXXXXXXXXXXXXXXXXXXXX LOGOUT ATTEMPT FROM LOGOUT CONTROLLER XXXXXXXXXXXXXXXXXXX');

        // Esto no se ejecutará en realidad, ya que el firewall de Symfony
        // interceptará la petición antes de llegar aquí
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
