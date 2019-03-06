<?php

namespace App\BLL;


use App\Entity\Eventos;
use App\Entity\Facturas;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Tests\Templating\Fixture\FooBundle\Action\FooAction;

class FacturasBLL extends BaseBLL
{

    public function toArray($entity)
    {
        if ( is_null ($entity))
            return null;

        if (!($entity instanceof Facturas))
            throw new \Exception("La entidad no es una Factura");

        return [
            'id' => $entity->getId(),
            'usuarioId' => $entity->getUsuarioId(),
            'eventoId' => $entity->getEventoId(),
            'fechaCompra' => $entity->getFechaCompra(),
            'cantidad' => $entity->getCantidad(),
            'barcode' => $entity->getBarcode()
        ];
    }

    public function getFacturas(array $busqueda = null)
    {
        return $this->em->getRepository(Facturas::class)->findBy($busqueda);
    }

    public function getFacturasRest(array $busqueda = null){

        $busqueda = $busqueda == null ? ['usuarioId' => $this->getUser()->getId()] : $busqueda;

        $facturas = $this->em->getRepository(Facturas::class)->findBy($busqueda);

        return $this->entitiesToArray($facturas);
    }

    public function guardarFactura(Facturas $facturas)
    {
        $this->em->persist($facturas);
        $this->em->flush();
    }

    public function nuevo($id, $data)
    {
        $factura = new Facturas();
        $factura->setBarcode(md5(strtotime('now')));
        $factura->setEventoId($this->em->getRepository(Eventos::class)->findOneBy(['id' => $id]));
        $factura->setUsuarioId($this->getUser());
        $factura->setCantidad($data['cantidad']);

        return $this->guardaValidando($factura);
    }
}