<?php

namespace App\Repository;

use App\Entity\Facturas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class FacturasRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Facturas::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('f')
            ->where('f.something = :value')->setParameter('value', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
