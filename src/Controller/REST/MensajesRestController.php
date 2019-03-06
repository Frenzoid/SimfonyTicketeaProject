<?php
/**
 * Created by PhpStorm.
 * User: frenzoid
 * Date: 24/02/18
 * Time: 13:23
 */

namespace App\Controller\REST;

use App\BLL\EventosBLL;
use App\BLL\MensajeBLL;
use App\Entity\Eventos;
use App\Entity\Mensajes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MensajesRestController extends BaseApiController
{

    /**
     * @Route("/mensajes/conv/{id}.{_format}", name="get_mensajes_rest",
     * requirements={"id": "\d+", "_format": "json" },
     * defaults={"_format": "json"})
     * @IsGranted("ROLE_COMPRADOR")
     * @Method("GET")
     */
    public function getConversation(MensajeBLL $mensajeBLL, $id)
    {
        return $this->getResponse($mensajeBLL->getMensajesREST($id));
    }

    /**
     * @Route("/mensajes/{id}.{_format}", name="post_mensaje_rest",
     * requirements={"id": "\d+", "_format": "json" },
     * defaults={"_format": "json"})
     * @IsGranted("ROLE_COMPRADOR")
     * @Method("POST")
     */
    public function post(Request $request, MensajeBLL $mensajeBLL, $id) {
        $data = $this->getContent($request);
        $producto = $mensajeBLL->nuevo($id, $data);
        return $this->getResponse($producto, Response::HTTP_CREATED );
    }

    /**
     * @Route("/mensajes/{id}.{_format}", name="update_mensaje_rest",
     *  requirements={"id": "\d+", "_format": "json" },
     *  defaults={"_format": "json"})
     * @IsGranted("ROLE_COMPRADOR")
     * @Method("PUT")
     */
    public function update(Request $request, Mensajes $mensajes, MensajeBLL $mensajeBLL)
    {
        $data = $this->getContent($request);
        $producto = $mensajeBLL->update($mensajes, $data);
        return $this->getResponse($producto, Response:: HTTP_OK );
    }

    /**
     * @Route("/mensajes/{id}.{_format}", name="delete_mensaje_rest",
     * requirements={ "id": "\d+", "_format": "json" },
     * defaults={"_format": "json"})
     * @IsGranted("ROLE_COMPRADOR")
     * @Method("DELETE")
     */
    public function delete(EventosBLL $eventosBLL, Eventos $eventos)
    {
        $eventosBLL->delete($eventos);
        return $this->getResponse(null, Response:: HTTP_NO_CONTENT );
    }

}