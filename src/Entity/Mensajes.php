<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\MensajesRepository")
 */
class Mensajes
{


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getEmisor()
    {
        return $this->emisor;
    }

    /**
     * @param mixed $emisor
     * @return Mensajes
     */
    public function setEmisor($emisor)
    {
        $this->emisor = $emisor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReceptor()
    {
        return $this->receptor;
    }

    /**
     * @param mixed $receptor
     * @return Mensajes
     */
    public function setReceptor($receptor)
    {
        $this->receptor = $receptor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     * @return Mensajes
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * @param mixed $mensaje
     * @return Mensajes
     */
    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
        return $this;
    }

    // add your own fields

    public function __construct()
    {
        $this->fecha = new \DateTime();
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuarios")
     * @Assert\NotBlank(message="No se ha especificado el usuario emisor")
     */
    private $emisor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuarios")
     * @Assert\NotBlank(message="No se ha especificado el usuario receptor")
     */
    private $receptor;

    /**
     * @ORM\column(type="date")
     */
    private $fecha;

    /**
     * @ORM\column(type="text", length=10000)
     * @Assert\NotBlank(message="No se ha especificado el mensaje")
     */
    private $mensaje;
}
