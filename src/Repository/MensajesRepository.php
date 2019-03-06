<?php

namespace App\Repository;

use App\Entity\Mensajes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class MensajesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Mensajes::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('m')
            ->where('m.something = :value')->setParameter('value', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function getUserMesages($usr1, $usr2){

        $qb = $this->createQueryBuilder('p')
//        $qb->creat("SELECT * FROM 'mensajes' WHERE emisor_id = :usr1 AND receptor_id = :usr2 OR emisor_id = :usr2 AND receptor_id = :usr1")
        ->where('p.emisor = :usr1')
        ->andWhere('p.receptor = :usr2')
        ->orWhere('p.emisor = :usr2')
        ->andWhere('p.receptor = :usr1')

        ->setParameter('usr1', $usr1)
        ->setParameter('usr2', $usr2)
        ->orderBy('p.fecha', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
