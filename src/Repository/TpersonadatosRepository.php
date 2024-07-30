<?php

namespace App\Repository;

use App\Entity\Tpersonadatos;
use App\Entity\Tusuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Psr\Log\LoggerInterface;

class TpersonadatosRepository extends ServiceEntityRepository
{
    private $httpClient;
    private $logger;

    public function __construct(ManagerRegistry $registry, HttpClientInterface $httpClient, LoggerInterface $logger)
    {
        parent::__construct($registry, Tpersonadatos::class);
        $this->httpClient = $httpClient;
        $this->logger = $logger;
    }

    public function fetchUserAddresses(string $identificacion): array
    {
        try {
            $response = $this->httpClient->request('POST', 'http://localhost:8086/api/listado/personas', [
                'json' => [
                    'identificacion' => $identificacion
                ],
            ]);

            $responseData = $response->toArray();
            $this->logger->info('Respuesta de la API: ' . json_encode($responseData));

            if ($responseData['CodigoResultado'] !== '000') {
                $this->logger->warning('Solicitud fallida: Código de resultado incorrecto');
                throw new \Exception('Invalid response code');
            }

            $this->logger->info('Lista de direcciones exitosa para identificacion: ' . $identificacion);

            return $responseData;
        
        } catch (\Exception $e) {
            $this->logger->error('Error durante la solicitud: ' . $e->getMessage(), ['exception' => $e]);
            throw new \Exception('An error occurred during the request: ' . $e->getMessage());
        }
    }
}
