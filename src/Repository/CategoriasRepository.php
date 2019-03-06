<?php

namespace App\Repository;

use App\Entity\Categorias;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CategoriasRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Categorias::class);
    }

    public function findByNombre($busqueda)
    {
        $qb = $this->createQueryBuilder('c');

        $qb ->where($qb->expr()->like('c.nombre', ':busqueda'))
            ->setParameter('busqueda', '%' . $busqueda . '%');

        $qb->orderBy('c.nombre', 'ASC');

        return $qb->getQuery()->getResult();
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('c')
            ->where('c.something = :value')->setParameter('value', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
