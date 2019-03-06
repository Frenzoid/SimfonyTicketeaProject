<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProvinciasRepository")
 */
class Provincias
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
    public function getNombre()
    {
        return $this->nombre;
    }


    // add your own fields

    /**
     * @ORM\column(type="string", length=100)
     */
    private $nombre;

    public function __toString()
    {
       return $this->nombre;
    }

}
