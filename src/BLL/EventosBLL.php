<?php

namespace App\BLL;


use App\Entity\Categorias;
use App\Entity\Eventos;
use App\Entity\Provincias;
use App\Entity\Usuarios;
use App\BLL\BaseBLL;
use Couchbase\Exception;
use Doctrine\Common\Persistence\ObjectManager;

class EventosBLL extends BaseBLL
{

    public function getEventos(array $busqueda = null)
    {
        return $this->em->getRepository(Eventos::class)->findBy($busqueda);
    }

    public function getEventosAPIRes(array $busqueda = null)
    {
        $busqu = ($busqueda == null ? array('autor' => $this->getUser()->getId()) : $busqueda);
        //var_dump($busqu);
        return $this->entitiesToArray($this->em->getRepository(Eventos::class)->findBy($busqu));
    }

    public function buscar($patron = false, $fecha1 = false, $fecha2 = false, $fecha3 = false,
                           $orden = false, $categoria = false, $provincia = false, $disponibles = false){
        return $this->em->getRepository(Eventos::class)->buscar($patron, $fecha1, $fecha2, $fecha3,
                            $orden, $categoria, $provincia, $disponibles);
    }

    public function buscarAPIRES($patron = false, $fecha1 = false, $fecha2 = false, $fecha3 = false,
                           $orden = false, $categoria = false, $provincia = false, $disponibles = false){
        $events = $this->em->getRepository(Eventos::class)->buscar($patron, $fecha1, $fecha2, $fecha3,
            $orden, $categoria, $provincia, $disponibles);

        return $this->entitiesToArray($events);
    }

    public function getAll()
    {
        return $this->em->getRepository(Eventos::class)->getAll();
    }

    public function eliminaEventos($id)
    {
        $eventos = $this->em->getRepository(Eventos::class)->find($id);

        $this->em->remove($eventos);
        $this->em->flush();
    }

    public function guardaEventos(Eventos $eventos)
    {
        $this->em->persist($eventos);
        $this->em->flush();
    }

    public function toArray($entity)
    {
        if ( is_null ($entity))
            return null;

        if (!($entity instanceof Eventos))
            throw new \Exception("La entidad no es un Evento");

        return [
            'id' => $entity->getId(),
            'autor' =>$entity->getAutor(),
            'fechaEvento' => $entity->getFechaEvento(),
            'fechaVentaInicio' => $entity->getFechaVentaInicio(),
            'fechaVentaFinal' => $entity->getFechaVentafinal(),
            'numEntradasRes' => $entity->getNumEntradasRes(),
            'numEntradasTot' => $entity->getNumEntradasTot(),
            'categoria' => $entity->getCategoria(),
            'provincia' => $entity->getProvincia(),
            'poster' => $entity->getPoster(),
            'enlaceExterno' => $entity->getEnlaceExterno(),
            'direccion' => $entity->getDireccion(),
            'nombre' => $entity->getNombre()
        ];
    }

    public function nuevo(array $data)
    {
        $evento = new Eventos();
        $evento->setNombre($data['nombre']);
        $evento->setAutor($this->em->getRepository(Usuarios::class)->find($data['autor']));
        $evento->setFechaEvento(new \DateTime($data['fechaEvento']));
        $evento->setFechaVentaFinal(new \DateTime($data['fechaVentaFinal']));
        $evento->setFechaVentaInicio(new \DateTime($data['fechaVentaInicio']));
        $evento->setNumEntradasTot($data['numEntradasTot']);
        $evento->setNumEntradasRes($data['numEntradasRes']);
        $evento->setDescripcion($data['descripcion']);
        $evento->setCategoria($this->em->getRepository(Categorias::class)->find($data['categoria']));
        $evento->setProvincia($this->em->getRepository(Provincias::class)->find($data['provincia']));
        $evento->setPoster($data['poster']);
        $evento->setEnlaceExterno($data['enlaceExterno']);
        $evento->setDireccion($data['direccion']);
        $evento->setPrecio($data['precio']);
        $evento->setAutor($this->getUser());

        return $this->guardaValidando($evento);
    }

    public function update(Eventos $evento, array $data)
    {
        $evento->setNombre($data['nombre']);
        $evento->setFechaEvento(new \DateTime($data['fechaEvento']));
        $evento->setFechaVentaFinal(new \DateTime($data['fechaVentaFinal']));
        $evento->setFechaVentaInicio(new \DateTime($data['fechaVentaInicio']));
        $evento->setNumEntradasTot($data['numEntradasTot']);
        $evento->setDescripcion($data['descripcion']);
        $evento->setNumEntradasRes($data['numEntradasRes']);
        $evento->setCategoria($this->em->getRepository(Categorias::class)->find($data['categoria']));
        $evento->setProvincia($this->em->getRepository(Provincias::class)->find($data['provincia']));
        $evento->setPoster($data['poster']);
        $evento->setEnlaceExterno($data['enlaceExterno']);
        $evento->setDireccion($data['direccion']);
        $evento->setPrecio($data['precio']);

        return $this->guardaValidando($evento);
    }
}