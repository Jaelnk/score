<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class LogoutService
{
    private $client;
    private $logger;
    private $params;

    public function __construct(HttpClientInterface $client, LoggerInterface $logger, ParameterBagInterface $params)
    {
        $this->client = $client;
        $this->logger = $logger;
        $this->params = $params;
    }

    public function logout(string $username): string
    {
        $apiBaseUrl = $this->params->get('api_base_url');

        try {
            $response = $this->client->request('POST', "$apiBaseUrl/api/logout", [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'usuario' => $username,
                ],
            ]);

            $statusCode = $response->getStatusCode();
            $content = $response->getContent();

            if ($statusCode === Response::HTTP_OK) {
                $this->logger->info('Logout exitoso para el usuario: ' . $username);
                return "Logout exitoso";
            } else {
                $this->logger->warning('Error en el logout para el usuario: ' . $username . '. Código de estado: ' . $statusCode);
                return "Error en el logout: " . $content;
            }
        } catch (\Exception $e) {
            $this->logger->error('Excepción durante el logout para el usuario: ' . $username . '. Mensaje: ' . $e->getMessage());
            return "Error en el logout: " . $e->getMessage();
        }
    }
}