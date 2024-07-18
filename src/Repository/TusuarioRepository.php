<?php

namespace App\Repository;

use App\Entity\Tusuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tusuario>
 *
 * @method Tusuario|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tusuario|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tusuario[]    findAll()
 * @method Tusuario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TusuarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tusuario::class);
    }

    //    /**
    //     * @return Tusuario[] Returns an array of Tusuario objects
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

    //    public function findOneBySomeField($value): ?Tusuario
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
