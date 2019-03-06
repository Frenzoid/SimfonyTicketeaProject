<?php
/**
 * Created by PhpStorm.
 * User: dwes
 * Date: 12/02/18
 * Time: 16:48
 */

namespace App\Controller\REST;

use App\BLL\EventosBLL;
use App\Entity\Eventos;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventosRestController extends BaseApiController
{
    /**
     * @Route("/eventos.{_format}", name="get_eventos",
     * defaults={"_format": "json"},
     * requirements={"_format": "json"}
     * )
     * @Route("/eventos/{patron}/{orden}/{fecha1}/{fecha2}/{fecha3}/{categoria}/{provincia}/{disponibles}", name="get_eventos_ordenados",
     *  requirements={"orden": "fecha|categoria|provincia"}
     * )
     * @Method("GET")
     */
    public function getAll(Request $request, EventosBLL $eventosBLL, $patron = false, $orden = false, $fecha1 = false, $fecha2 = false, $fecha3 = false, $categoria = false, $provincia = false, $disponibles = false)
    {
        $patron = $patron == '' ? false : $patron;
        $fecha1 = $fecha1 == '' ? false : $fecha1;
        $fecha2 = $fecha2 == '' ? false : $fecha2;
        $fecha3 = $fecha3 == '' ? false : $fecha3;
        $categoria = $categoria == '' ? false : $categoria;
        $provincia = $provincia == '' ? false : $provincia;
        $disponibles = $disponibles == '' ? false : $disponibles;

        $eventos = $eventosBLL->buscarAPIRES($patron, $fecha1, $fecha2, $fecha3, $orden, $categoria, $provincia, $disponibles);

        return $this->getResponse($eventos);
    }

    /**
     * @Route("/eventos/usuario/mine.{_format}", name="get_mis_eventos",
     * requirements={"_format": "json"},
     * defaults={"_format": "json"})
     * @Method("GET")
     */
    public function getUserEvents(EventosBLL $eventosBLL)
    {
        return $this->getResponse($eventosBLL->getEventosAPIRes());
    }

    /**
     * @Route("/eventos/usuario/{id}.{_format}", name="get_sus_eventos",
     * requirements={"id": "\d+","_format": "json"},
     * defaults={"_format": "json"})
     * @Method("GET")
     */
    public function getUsersEvents(EventosBLL $eventosBLL, $id)
    {
        return $this->getResponse($eventosBLL->getEventosAPIRes(['autor' => $id]));
    }

    /**
     * @Route("/eventos/{id}.{_format}", name="get_evento",
     * requirements={"id": "\d+", "_format": "json" },
     * defaults={"_format": "json"})
     * @Method("GET")
     */
    public function getOne(Eventos $eventos, EventosBLL $eventosBLL)
    {
        return $this->getResponse($eventosBLL->toArray($eventos));
    }

    /**
     * @Route("/eventos.{_format}", name="post_evento",
     *  defaults={"_format": "json"},
     *  requirements={"_format": "json"}
     * )
     * @Method("POST")
     */
    public function post(Request $request, EventosBLL $eventosBLL) {
        $data = $this->getContent($request);

        $producto = $eventosBLL->nuevo($data);

        return $this->getResponse($producto, Response::HTTP_CREATED );
    }

    /**
     * @Route("/eventos/{id}.{_format}", name="update_evento_rest",
     *  requirements={"id": "\d+", "_format": "json" },
     *  defaults={"_format": "json"})
     * @Method("PUT")
     */
    public function update(Request $request, Eventos $eventos, EventosBLL $eventosBLL)
    {
        $data = $this->getContent($request);
        $producto = $eventosBLL->update($eventos, $data);
        return $this->getResponse($producto, Response:: HTTP_OK );
    }

    /**
     * @Route("/eventos/{id}.{_format}", name="delete_evento",
     * requirements={ "id": "\d+", "_format": "json" },
     * defaults={"_format": "json"})
     * @Method("DELETE")
     */
    public function delete(EventosBLL $eventosBLL, Eventos $eventos)
    {
        $eventosBLL->delete($eventos);
        return $this->getResponse(null, Response:: HTTP_NO_CONTENT );
    }
}