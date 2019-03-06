<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RolesRepository")
 */
class Roles
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $id;

    // add your own fields
    public function __toString()
    {
       return $this->id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Roles
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

}
