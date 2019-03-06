<?php

namespace App\Repository;

use App\Entity\Eventos;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Validator\Constraints\Date;

class EventosRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Eventos::class);
    }

    public function getAll(){

        $qb = $this->createQueryBuilder('p');

        return $qb->getQuery()->getResult();
        // return $qb->getQuery()->getResult();
    }

    public function findByNombre($busqueda, $offset, $limit)
    {
        $qb = $this->createQueryBuilder('p');

        $qb ->join('p.nombre', 'cat')->addSelect('cat')
            ->where($qb->expr()->like('p.name', ':busqueda'))
            ->setParameter('busqueda', '%' . $busqueda . '%')
            ->orderBy('p.id', 'ASC')
            ->setMaxResults( $limit );

        if (!is_null($offset))
            $qb->setFirstResult( $offset );

        return $qb->getQuery()->getResult();
    }

    public function buscar($patron = false, $fecha1 = false, $fecha2 = false, $fecha3 = false,
                           $orden = false, $categoria = false, $provincia = false, $disponibles = false){

        // var_dump($patron);
        $hoy = date("Y-m-d", strtotime("today"));
        $manyana = date('Y-m-d', strtotime(' +1 day'));
        $lunes = date("Y-m-d", strtotime("this Monday"));
        $sabado = date("Y-m-d", strtotime("this Saturday"));
        $domingo = date("Y-m-d", strtotime("this Sunday"));
        $inicioMes = date('Y-m-01');
        $finalMes = date('Y-m-t');

        $qb = $this->createQueryBuilder('e');

        if($patron){
            $qb ->where($qb->expr()->like('e.nombre', ':patron'))
                ->setParameter('patron', '%' . $patron . '%');
        }

        if($fecha1 && $fecha2 != false && $fecha3 != false){
            switch ($fecha1){
            // manyana
            case "M":
                $qb ->where('e.fechaEvento = :manyana')
                    ->setParameter('manyana', $manyana->format('Y-m-d'));
            break;
            // esta semana
            case "S":
                $qb ->where('e.fechaEvento >= :lunes')
                    ->andWhere('e.fechaEvento <= :domingo')
                    ->setParameter('lunes', $lunes)
                    ->setParameter('domingo', $domingo);
            break;
            // este fin de semana
            case "W":
                $qb ->where('e.fechaEvento >= :sabado')
                    ->andWhere('e.fechaEvento <= :sunday')
                    ->setParameter('sabado', $sabado)
                    ->setParameter('domingo', $domingo);
            break;
            // este mes
            case "MH":
                $qb ->where('e.fechaEvento >= :inimes')
                    ->andWhere('e.fechaEvento <= :finimes')
                    ->setParameter('inimes', $inicioMes)
                    ->setParameter('finimes', $finalMes);
            break;
            }
        } else if($fecha2 != false ^ $fecha3 != false){
            $fecha = $fecha2 == true ? $fecha2 : $fecha3;
            $fecha =  date('Y-m-d',date_create_from_format('Y-m-d', $fecha)->getTimestamp());
            // var_dump($fecha);

            $qb ->where('e.fechaEvento = :fecha')
                ->setParameter('fecha', $fecha);
        } else if($fecha2 != false && $fecha3 != false){
            $fecha2 =  date('Y-m-d',date_create_from_format('Y-m-d', $fecha2)->getTimestamp());
            $fecha3 = date('Y-m-d',date_create_from_format('Y-m-d', $fecha3)->getTimestamp());

            $qb ->where('e.fechaEvento >= :fini')
                ->andWhere('e.fechaEvento <= :ffin')
                ->setParameter('fini', $fecha2)
                ->setParameter('ffin', $fecha3);
        }

        if($orden)
        {
            switch ($orden){
                case "categoria":
                    $qb ->orderBy('e.categoria', 'ASC');
                break;
                case "provincia":
                    $qb ->orderBy('e.provincia', 'ASC');
                break;
                case "fecha":
                    $qb ->orderBy('e.fechaEvento', 'ASC');
                break;
            }
        }

        if($provincia){
            $qb ->andWhere('e.provincia = :provincia')
                ->setParameter('provincia', $provincia);
        }

        if($categoria){
            $qb ->andWhere('e.categoria = :categoria')
                ->setParameter('categoria', $categoria);
        }

        if($disponibles){
            $qb ->andWhere('e.fechaVentaInicio <= :hoy')
                ->andWhere('e.fechaVentaFinal >= :hoy')
                ->andWhere('e.numEntradasRes != 0')
                ->setParameter('hoy', $hoy);
        }

        // echo $qb->getQuery()->getDQL();

        return $qb->getQuery()->getResult();
    }
}
