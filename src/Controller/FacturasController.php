<?php
/**
 * Created by PhpStorm.
 * User: frenzoid
 * Date: 11/02/18
 * Time: 15:58
 */

namespace App\Controller;


use App\BLL\EventosBLL;
use App\BLL\FacturasBLL;
use App\Entity\Eventos;
use App\Entity\Facturas;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class FacturasController extends Controller
{
    /**
     * @Route("/tramites/{id}", name="facturar", methods={"POST"})
     */
    public function tramitar(Request $request, $id, EventosBLL $eventosBLL, FacturasBLL $facturasBLL)
    {
        $params = [];

        foreach ($request->request->keys() as $key){
            $params[$key] = !empty($request->request->get($key)) ? $request->request->get($key) : false;
        }

        $evento = $eventosBLL->getEventos(['id' => $id])[0];

        if($evento->getNumEntradasRes() < $params['entradas']){
            return $this->render(
                'eventos/detalles.html.twig',
                [
                    'errores' => 'No hay tantas entradas.',
                    'evento' => $evento
                ]
            );
        }else{

            $factura = new Facturas();
            $factura->setCantidad($params['entradas']);
            $factura->setUsuarioId($this->getUser());
            $factura->setEventoId($evento);
            $factura->setBarcode(md5(strtotime('now')));

            $evento->setNumEntradasRes($evento->getNumEntradasTot() - $params['entradas']);
            $eventosBLL->guardaEventos($evento);
            $facturasBLL->guardarFactura($factura);
            return $this->redirectToRoute('facturas');
        }
    }

    /**
     * @Route("/tramites/", name="facturas")
     * @Template("tramites/tramites.html.twig")
     */
    public function facturas(FacturasBLL $facturasBLL){
         return ['facturas' => $facturasBLL->getFacturas(['usuarioId' => $this->getUser()->getId()])];
    }
}