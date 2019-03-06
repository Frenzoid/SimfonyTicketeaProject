<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventosRepository")
 */
class Eventos
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
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * @param mixed $idCreador
     */
    public function setIdCreador($idCreador): void
    {
        $this->idCreador = $idCreador;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return mixed
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param mixed $categoria
     */
    public function setCategoria($categoria): void
    {
        $this->categoria = $categoria;
    }

    /**
     * @return mixed
     */
    public function getPoster()
    {
        return $this->poster;
    }

    /**
     * @param mixed $poster
     */
    public function setPoster($poster): void
    {
        $this->poster = $poster;
    }

    /**
     * @return mixed
     */
    public function getEnlaceExterno()
    {
        return $this->enlaceExterno;
    }

    /**
     * @param mixed $enlaceExterno
     */
    public function setEnlaceExterno($enlaceExterno): void
    {
        $this->enlaceExterno = $enlaceExterno;
    }

    /**
     * @return mixed
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * @param mixed $provincia
     */
    public function setProvincia($provincia): void
    {
        $this->provincia = $provincia;
    }

    /**
     * @return mixed
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     */
    public function setDireccion($direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * @return mixed
     */
    public function getFechaVentaInicio()
    {
        return $this->fechaVentaInicio;
    }

    /**
     * @param mixed $fechaVentaInicio
     */
    public function setFechaVentaInicio($fechaVentaInicio): void
    {
        $this->fechaVentaInicio = $fechaVentaInicio;
    }

    /**
     * @return mixed
     */
    public function getFechaVentaFinal()
    {
        return $this->fechaVentaFinal;
    }

    /**
     * @param mixed $fechaVentaFinal
     */
    public function setFechaVentaFinal($fechaVentaFinal): void
    {
        $this->fechaVentaFinal = $fechaVentaFinal;
    }

    /**
     * @return mixed
     */
    public function getFechaEvento()
    {
        return $this->fechaEvento;
    }

    /**
     * @param mixed $fechaEvento
     */
    public function setFechaEvento($fechaEvento): void
    {
        $this->fechaEvento = $fechaEvento;
    }

    /**
     * @return mixed
     */
    public function getNumEntradasTot()
    {
        return $this->numEntradasTot;
    }

    /**
     * @param mixed $numEntradasTot
     */
    public function setNumEntradasTot($numEntradasTot): void
    {
        $this->numEntradasTot = $numEntradasTot;
    }

    /**
     * @return mixed
     */
    public function getNumEntradasRes()
    {
        return $this->numEntradasRes;
    }

    /**
     * @param mixed $numEntradasRes
     */
    public function setNumEntradasRes($numEntradasRes): void
    {
        $this->numEntradasRes = $numEntradasRes;
    }

    /**
     * @return mixed
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * @param mixed $precio
     */
    public function setPrecio($precio): void
    {
        $this->precio = $precio;
    }

    /**
     * @param mixed $autor
     * @return Eventos
     */
    public function setAutor($autor)
    {
        $this->autor = $autor;
        return $this;
    }

    // add your own fields



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuarios")
     */
    private $autor;

    /**
     * @ORM\column(type="string", length=100, nullable=false)
     * @Assert\NotBlank(message="Falta el nombre del evento.")
     */
    private $nombre;

    /**
     * @ORM\column(type="string", length=100)
     * @Assert\NotBlank(message="Falta la descripción.")
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorias")
     * @Assert\NotBlank(message="Falta seleccionar la categoria")
     */
    private $categoria;

    /**
     * @ORM\column(type="string", length=100)
     */
    private $poster;

    /**
     * @ORM\column(type="string", length=100, nullable=true)
     */
    private $enlaceExterno;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Provincias")
     * @Assert\NotBlank(message="Debes seleccionar una provincia.")
     */
    private $provincia;

    /**
     * @ORM\column(type="string", length=100)
     * @Assert\NotBlank(message="Se requiere una direccion.")
     */
    private $direccion;

    /**
     * @ORM\column(type="date")
     * @Assert\NotBlank(message="Falta la fecha de inicio de venta de entradas.")
     */
    private $fechaVentaInicio;

    /**
     * @ORM\column(type="date")
     * @Assert\NotBlank(message="Falta la fecha final de venta de entradas.")
     */
    private $fechaVentaFinal;

    /**
     * @ORM\column(type="date")
     * @Assert\NotBlank(message="Falta la fecha del evento.")
     */
    private $fechaEvento;

    /**
     * @ORM\column(type="integer")
     * @Assert\NotBlank(message="Falta el numero de entradas.")
     */
    private $numEntradasTot;

    /**
     * @ORM\column(type="integer", nullable=true)
     */
    private $numEntradasRes;

    /**
     * @ORM\Column(type="decimal", precision=9, scale=2)
     * @Assert\NotBlank(message="No puedes dejar el precio vacío")
     * @Assert\Type("double", message="El precio introducido no es correcto")
     */
    private $precio;


}
