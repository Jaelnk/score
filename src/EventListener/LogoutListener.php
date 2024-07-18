<?php

namespace App\EventListener;

use App\Service\LogoutService;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Psr\Log\LoggerInterface;

class LogoutListener
{
    private $logoutService;
    private $logger;

    public function __construct(LogoutService $logoutService, LoggerInterface $logger)
    {
        $this->logoutService = $logoutService;
        $this->logger = $logger;
    }

    public function onLogout(LogoutEvent $event): void
    {
        $user = $event->getToken()->getUser();

        if ($user) {
            $username = $user->getUserIdentifier();
            $this->logger->info('XXXXXXXXXXXXXXXXXXXXXXX LOGOUT ATTEMPT XXXXXXXXXXXXXXXXXXX', ['username' => $username]);

            $result = $this->logoutService->logout($username);
            
            $this->logger->info('User logged out', [
                'username' => $username,
                'result' => $result
            ]);

            // Puedes agregar un mensaje flash aquí si lo deseas
            $event->getRequest()->getSession()->getFlashBag()->add('notice', $result);
        } else {
            $this->logger->warning('Logout attempted with no authenticated user');
        }
    }
}