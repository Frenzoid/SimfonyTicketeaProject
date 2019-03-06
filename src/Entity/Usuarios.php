<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsuariosRepository")
 */
class Usuarios implements UserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    // add your own fields
    public function __construct()
    {
        $this->fechaAlta = new \DateTime();
    }

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

    /**
     * @param mixed $nombre
     * @return Usuarios
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPasswd()
    {
        return $this->passwd;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Usuarios
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }


    /**
     * @param mixed $passwd
     * @return Usuarios
     */
    public function setPasswd($passwd)
    {
        $this->passwd = $passwd;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     * @return Usuarios
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFechaAlta()
    {
        return $this->fechaAlta;
    }

    /**
     * @param mixed $fechaAlta
     * @return Usuarios
     */
    public function setFechaAlta($fechaAlta)
    {
        $this->fechaAlta = $fechaAlta;
        return $this;
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
     * @return Usuarios
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;
        return $this;
    }


    /**
     * @param mixed $role
     * @return Usuarios
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }


    /**
     * @param mixed $lang
     * @return Usuarios
     */
    public function getUsername()
    {
        return $this->nombre;
    }


    /**
     * @ORM\column(type="string", length=100)
     * @Assert\NotBlank(message="No puedes dejar el campo nombre vacío")
     */
    private $nombre;

    /**
     * @ORM\column(type="string", length=100)
     * @Assert\NotBlank(message="No puedes dejar el campo email vacío")
     */
    private $email;

    /**
     * @ORM\column(type="string", length=100)
     * @Assert\NotBlank(message="No puedes dejar el campo contraseña vacío")
     */
    private $passwd;

    /**
     * @ORM\column(type="string", length=100)
     */
    private $avatar;

    /**
     * @ORM\column(type="string", length=100, nullable=false)
     */
    private $role;

    /**
     * @ORM\column(type="date")
     */
    private $fechaAlta;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Provincias")
     * @Assert\NotBlank(message="No puedes dejar el campo provincia vacío")
     */
    private $provincia;

    public function getPassword()
    {
        return $this->passwd;
    }

    /**
     * @ORM\column(type="string", length=100)
     */

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return array($this->role);
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize(array(
                $this->id,
                $this->nombre,
                $this->passwd)
        );
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->nombre,
            $this->passwd
            ) = unserialize($serialized);
    }
}
