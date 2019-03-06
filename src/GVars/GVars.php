<?php
/**
 * Created by PhpStorm.
 * User: frenzoid
 * Date: 3/02/18
 * Time: 17:49
 */

namespace App\GVars;

use App\Entity\Categorias;
use App\Entity\Provincias;
use Doctrine\Common\Persistence\ObjectManager;

class GVars
{
    private $em;

    public function __construct(ObjectManager $em){
        $this->em = $em;
    }

    public function getProvincias(){
        return $this->em->getRepository(Provincias::class)->findAll();
    }

    public function getCategorias(){
        return $this->em->getRepository(Categorias::class)->findAll();
    }

}