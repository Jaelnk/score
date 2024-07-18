<?php

namespace App\Repository;

use App\Entity\Tpersona;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tpersona>
 *
 * @method Tpersona|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tpersona|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tpersona[]    findAll()
 * @method Tpersona[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TpersonaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tpersona::class);
    }

    //    /**
    //     * @return Tpersona[] Returns an array of Tpersona objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Tpersona
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
