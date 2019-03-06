<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\FacturasRepository")
 */
class Facturas
{
    public function __construct()
    {
        $this->fechaCompra = new \DateTime();
    }
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
    public function getUsuarioId()
    {
        return $this->usuarioId;
    }

    /**
     * @param mixed $usuarioId
     */
    public function setUsuarioId($usuarioId): void
    {
        $this->usuarioId = $usuarioId;
    }

    /**
     * @return mixed
     */
    public function getEventoId()
    {
        return $this->eventoId;
    }

    /**
     * @param mixed $eventoId
     */
    public function setEventoId($eventoId): void
    {
        $this->eventoId = $eventoId;
    }

    /**
     * @return mixed
     */
    public function getFechaCompra()
    {
        return $this->fechaCompra;
    }

    /**
     * @param mixed $fechaCompra
     */
    public function setFechaCompra($fechaCompra): void
    {
        $this->fechaCompra = $fechaCompra;
    }

    /**
     * @return mixed
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     */
    public function setCantidad($cantidad): void
    {
        $this->cantidad = $cantidad;
    }

    /**
     * @return mixed
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * @param mixed $barcode
     */
    public function setBarcode($barcode): void
    {
        $this->barcode = $barcode;
    }


    // add your own fields

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuarios")
     * @Assert\NotBlank(message="No se ha especificado el usuario")
     */
    private $usuarioId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Eventos")
     * @Assert\NotBlank(message="No se ha especificado el evento")
     */
    private $eventoId;

    /**
     * @ORM\column(type="date")
     */
    private $fechaCompra;

    /**
     * @ORM\column(type="integer")
     * @Assert\NotBlank(message="No se ha especificado la cantidad")
     */
    private $cantidad;

    /**
     * @ORM\column(type="string", length=100)
     * @Assert\NotBlank(message="No se ha generado el codigo de barra")
     */
    private $barcode;

}
