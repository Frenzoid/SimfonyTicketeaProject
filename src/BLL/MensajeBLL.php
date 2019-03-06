<?php

namespace App\BLL;


use App\Entity\Facturas;
use App\Entity\Mensajes;
use App\Entity\Usuarios;
use Doctrine\Common\Persistence\ObjectManager;

class MensajeBLL extends BaseBLL
{

    public function getMensajes($emisor, $receptor)
    {
//      return $this->em->getRepository(Mensajes::class)->getUserMesages($emisor, $receptor);
        return $this->em->getRepository(Mensajes::class)->findBy(
            ['emisor'=>[$emisor, $receptor],'receptor'=>[$receptor,$emisor]], ['fecha' => 'ASC']);
    }

    public function getMensajesREST($id)
    {
       // return $this->em->getRepository(Mensajes::class)->getUserMesages($data['emisor'], $data['receptor']);
        return $this->entitiesToArray($this->em->getRepository(Mensajes::class)->findBy(
            ['emisor'=> [$this->getUser()->getId(), $id],'receptor'=> [$this->getUser()->getId(),$id]], ['fecha' => 'ASC']));
    }

    public function guardarMensajes(Mensajes $mensajes)
    {
        $this->em->persist($mensajes);
        $this->em->flush();
    }

    public function toArray($entity)
    {
        if ( is_null ($entity))
            return null;

        if (!($entity instanceof Mensajes))
            throw new \Exception("La entidad no es un Mensajes");

        return [
            'id' => $entity->getId(),
            'mensaje' =>$entity->getMensaje(),
            'emisor' => $entity->getEmisor(),
            'receptor' => $entity->getReceptor(),
            'fecha' => $entity->getFecha()
        ];
    }

    public function nuevo($id, $data)
    {
        $mensajes = new Mensajes();
        $mensajes->setMensaje($data['mensaje']);
        $mensajes->setReceptor($this->em->getRepository(Usuarios::class)->find($id));
        $mensajes->setEmisor($this->getUser());

        return $this->guardaValidando($mensajes);
    }

    public function update(Mensajes $mensajes, array $data)
    {
        $mensajes->setMensaje($data['mensaje']);

        return $this->guardaValidando($mensajes);
    }
}