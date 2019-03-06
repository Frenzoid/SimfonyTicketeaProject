<?php
/**
 * Created by PhpStorm.
 * User: frenzoid
 * Date: 11/02/18
 * Time: 18:01
 */

namespace App\Controller;


use App\BLL\MensajeBLL;
use App\BLL\UsuarioBLL;
use App\Entity\Mensajes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MensajesController extends Controller
{

    /**
     * @Route("/mensajes/{id}", name="chat", methods={"POST", "GET"})
     * @Template("chat/chat.html.twig")
     */
    public function chat(Request $request, $id, MensajeBLL $mensajeBLL, UsuarioBLL $usuarioBLL)
    {
        $params = [];

        foreach ($request->request->keys() as $key){
            $params[$key] = !empty($request->request->get($key)) ? $request->request->get($key) : false;
        }

        $enchat = $usuarioBLL->getUsuarios(['id' => $id])[0];

        if(count($params) != 0) {
            $mensaje = new Mensajes();
            $mensaje->setEmisor($this->getUser());
            $mensaje->setReceptor($enchat);
            $mensaje->setMensaje($params['mensaje']);
            $mensajeBLL->guardarMensajes($mensaje);
        }

        $mensajes = $mensajeBLL->getMensajes($id, $this->getUser()->getId());
        return ['usuarios' => $usuarioBLL->getAllUsuarios(), 'enchat' => $enchat, 'mensajes' => $mensajes];
    }

    /**
     * @Route("/mensajes/", name="mensajes")
     * @Template("chat/chat.html.twig")
     */
    public function mensjes(MensajeBLL $mensajeBLL, UsuarioBLL $usuarioBLL){
        return ['usuarios' => $usuarioBLL->getAllUsuarios()];
    }

}