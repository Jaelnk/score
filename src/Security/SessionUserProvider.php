<?php

namespace App\Security;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\InMemoryUser;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class SessionUserProvider implements UserProviderInterface
{
    private LoggerInterface $logger;
    private RequestStack $requestStack;

    public function __construct(LoggerInterface $logger, RequestStack $requestStack)
    {
        $this->logger = $logger;
        $this->requestStack = $requestStack;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $session = $this->requestStack->getCurrentRequest()->getSession();
        $userData = $session->get('user_data');

        if (!$userData || $userData['Usuario'] !== $identifier) {
            throw new UserNotFoundException();
        }

        return new InMemoryUser($identifier, null, ['ROLE_USER']);
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return InMemoryUser::class === $class || is_subclass_of($class, InMemoryUser::class);
    }
}