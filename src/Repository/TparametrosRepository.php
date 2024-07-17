<?php

namespace App\Repository;

use App\Entity\Tparametros;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tparametros>
 */
class TparametrosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tparametros::class);
    }

    public function getAllParameter()
    {
        $paramArray = array();
        foreach ($this->findAll() as $param) {
            if ($param->getCargarMemoria() == 1) {
                if ($param->getValorNum()) {
                    $paramArray[$param->getIdParametro()] = $param->getValorNum();
                } elseif ($param->getValorDate()) {
                    $paramArray[$param->getIdParametro()] = $param->getValorDate();
                } elseif ($param->getValorText()) {
                    $paramArray[$param->getIdParametro()] = $param->getValorText();
                }
            }
        }
        return $paramArray;
    }
}
