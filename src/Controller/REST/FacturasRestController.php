<?php
/**
 * Created by PhpStorm.
 * User: frenzoid
 * Date: 24/02/18
 * Time: 13:23
 */

namespace App\Controller\REST;

use App\BLL\EventosBLL;
use App\BLL\FacturasBLL;
use App\Entity\Eventos;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FacturasRestController extends BaseApiController
{

    /**
     * @Route("/tickets/mine.{_format}", name="get_mis_tickets",
     * requirements={"_format": "json" },
     * defaults={"_format": "json"})
     * @IsGranted("ROLE_COMPRADOR")
     * @Method("GET")
     */
    public function getMine(FacturasBLL $facturasBLL)
    {
        return $this->getResponse($facturasBLL->getFacturasRest());
    }

    /**
     * @Route("/tickets/events/{id}.{_format}", name="get_tickets_de_evento_lol",
     * requirements={"id": "\d+", "_format": "json" },
     * defaults={"_format": "json"})
     * @IsGranted("ROLE_GESTOR")
     * @Method("GET")
     */
    public function getTicketsFromEvent(FacturasBLL $facturasBLL, $id)
    {
        return $this->getResponse($facturasBLL->getFacturasRest(['eventoId' => $id]));
    }

    /**
     * @Route("/tickets/events/{id}.{_format}", name="facturar_ticket_rest",
     * requirements={"id": "\d+", "_format": "json" },
     * defaults={"_format": "json"})
     * @IsGranted("ROLE_COMPRADOR")
     * @Method("POST")
     */
    public function facturarEvento(FacturasBLL $facturasBLL, $id, Request $request)
    {
        $data = $this->getContent($request);
        return $this->getResponse($facturasBLL->nuevo($id, $data));
    }



}