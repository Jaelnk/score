<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;

class LogoutService
{
    private $client;
    private $logger;

    public function __construct(HttpClientInterface $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    public function logout(string $username): string
    {
        try {
            $response = $this->client->request('POST', 'https://172.16.1.236:8443/api/logout', [
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