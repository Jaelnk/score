<?php

// src/EventListener/DoctrineSessionListener.php
namespace App\EventListener;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class DoctrineSessionListener implements EventSubscriberInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        // Obtener la conexión de Doctrine
        $connection = $this->entityManager->getConnection();

        // Configurar los parámetros de sesión
        $this->configureSession($connection);
    }

    private function configureSession(Connection $connection): void
    {
        $connection->executeStatement("ALTER SESSION SET NLS_TIME_FORMAT = 'HH24:MI:SS'");
        $connection->executeStatement("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI:SS'");
        $connection->executeStatement("ALTER SESSION SET NLS_TIMESTAMP_FORMAT = 'YYYY-MM-DD HH24:MI:SS'");
        $connection->executeStatement("ALTER SESSION SET NLS_TIMESTAMP_TZ_FORMAT = 'YYYY-MM-DD HH24:MI:SS TZH:TZM'");
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}
