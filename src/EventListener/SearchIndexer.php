<?php

namespace App\EventListener;

use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class SearchIndexer
{
    protected $requestStack;
    protected $tokenStorage;

    public function __construct(RequestStack $requestStack, TokenStorageInterface $tokenStorage)
    {
        $this->requestStack = $requestStack;
        $this->tokenStorage = $tokenStorage;
    }

    // the listener methods receive an argument which gives you access to
    // both the entity object of the event and the entity manager itself
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        $entity->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Guayaquil')));


        if ($this->tokenStorage->getToken() == null) {
            $entity->setCreatedBy('system');
            $entity->setCreatedIp($this->getIp());
            $entity->setCreatedPublicIp($this->obtenerIPPublica());
            $entity->setCreatedBrowser('app');
        } elseif ($this->tokenStorage->getToken()->getUser() != 'anon.') {
            $entity->setCreatedBy($this->tokenStorage->getToken()->getUser()->getNombreUsuario());
            $entity->setCreatedIp($this->getIp());
            $entity->setCreatedPublicIp($this->obtenerIPPublica());
            $entity->setCreatedBrowser($this->requestStack->getCurrentRequest()
                ->server->get('HTTP_USER_AGENT'));
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        $entity->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Guayaquil')));
        if ($this->tokenStorage->getToken() == null) {
            $entity->setUpdatedBy('system');
            $entity->setUpdatedIp($this->getIp());
            $entity->setUpdatedPublicIp('127.0.0.1');
            $entity->setUpdatedBrowser('app');
        } elseif ($this->tokenStorage->getToken()->getUser() != 'anon.') {
            $entity->setUpdatedBy($this->tokenStorage->getToken()->getUser()->getNombreUsuario());
            $entity->setUpdatedIp($this->getIp());
            $entity->setUpdatedPublicIp($this->obtenerIPPublica());
            $entity->setUpdatedBrowser($this->requestStack->getCurrentRequest()
                ->server->get('HTTP_USER_AGENT'));
        }
    }

    private function obtenerIPPublica()
    {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://api.ipify.org/');
        $ipPublica = $response->getContent();

        return $ipPublica;
    }

    public function getIp()
    {
        if (getenv("HTTP_CLIENT_IP")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
            if (strstr($ip, ',')) {
                $tmp = explode(',', $ip);
                $ip = trim($tmp[0]);
            }
        } else {
            $ip = getenv("REMOTE_ADDR");
        }

        return $ip;
    }
}
