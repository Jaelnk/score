<?php

namespace App\Repository;

use App\Entity\Tcatalogo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tcatalogo>
 *
 * @method Tcatalogo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tcatalogo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tcatalogo[]    findAll()
 * @method Tcatalogo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TcatalogoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tcatalogo::class);
    }

    public function getCatalogo($catalogo, $estadoActivoCat)
    {
        return $this->createQueryBuilder('tc')
            ->where('tc.idCatalogoPadre = :catalogo')
            ->andWhere('tc.idEstado = :estado')
            ->setParameter('catalogo', $catalogo)
            ->setParameter('estado', $estadoActivoCat);
    }
}
