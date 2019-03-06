<?php
/**
 * Created by PhpStorm.
 * User: frenzoid
 * Date: 28/01/18
 * Time: 17:59
 */

namespace App\Controller;

use App\BLL\EventosBLL;
use App\Entity\Eventos;
use App\Form\EventoType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EventosController extends Controller
{


    /**
    * @Route("/", name="portada")
    * @Template("eventos/portada.html.twig")
    */
    public function desplegarEventos(EventosBLL $eventosBLL, ObjectManager $em)
    {
        // $vars = array('eventos' => $eventosBLL->getAll());
        $vars = array('eventos' => $em->getRepository(Eventos::class)->findAll());
        return $vars;
    }

    /**
     * @Route("/eventos", name="eventosFiltrados", methods={"POST"})
     * @Template("eventos/eventosListados.html.twig")
     */
    public function eventosFiltrados(EventosBLL $eventosBLL, Request $request){
        $params = [];

        foreach ($request->request->keys() as $key){
            // echo $key . "->" .  $request->request->get($key);
            $params[$key] = !empty($request->request->get($key)) ? $request->request->get($key) : false;
        }


        $params['disponibles'] = (isset($params['disponibles']) && !empty($params['disponibles'])) ? true : false;

        return ['eventos' => $eventosBLL->buscar($params['patron'], $params['fecha1'], $params['fecha2'], $params['fecha3'],
            $params['orden'], $params['categoria'], $params['provincia'], $params['disponibles'])];
    }


    /**
     * @Route("/eventos/{id}/listado", name="eventosUsuario")
     * @Template("eventos/eventosListados.html.twig")
     */
    public function eventodelUsuario(EventosBLL $eventosBLL, ObjectManager $em, $id)
    {
        // $vars = array('eventos' => $eventosBLL->getAll());
        $vars = array('eventos' => $em->getRepository(Eventos::class)->findBy(['autor' => $id]));
        return $vars;
    }

    /**
     * @Route("/eventos/{id}", name="detallesEvento")
     * @Template("eventos/detalles.html.twig")
     */
    public function detallesEvento(EventosBLL $eventosBLL, ObjectManager $em, $id)
    {
        // $vars = array('eventos' => $eventosBLL->getAll());
        $vars = array('evento' => $em->getRepository(Eventos::class)->findOneBy(["id" => $id]));
        return $vars;
    }

    /**
     * @Route("/{id}", name="eventosPortadaUsuario", requirements={"id"="^(0|[1-9][0-9]*)$"})
     * @Template("eventos/portada.html.twig")
     */
    public function eventosPortadaUsuario(EventosBLL $eventosBLL, ObjectManager $em, $id)
    {
        // $vars = array('eventos' => $eventosBLL->getAll());
        $vars = array('eventos' => $em->getRepository(Eventos::class)->findBy(['autor' => $id]));
        return $vars;
    }

    private function formEvento(
        Request $request,
        EventosBLL $eventosBLL,
        Eventos $eventos,
        $status)
    {
        $form = $this->createForm(EventoType::class, $eventos);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $file = $eventos->getPoster();

            if($file != null){

                var_dump($file);
                $fileName = md5(uniqid()).'.'.$file->guessExtension();

                $file->move($this->getParameter('poster_dir'), $fileName);

                $eventos->setPoster(explode('public',$this->getParameter('poster_dir'))[1] . '/' . $fileName);

            }else
                $eventos->setPoster('/serverimg/defaultposter.png.jpg');

            $eventos->setNumEntradasRes($eventos->getNumEntradasTot());
            $eventosBLL->guardaEventos($eventos);

            return $this->redirect('/eventos/'.$this->getUser()->getId().'/listado');

        }


        return $this->render(
            'eventos/nuevoEvento.html.twig',
            [
                'form' => $form->createView(),
                'status' => $status
            ]
        );
    }


    /**
     * @Route("/evegest", name="nuevoEvento")
     * @Method({"GET", "POST"})
     */
    public function nuevo(Request $request, EventosBLL $eventosBLL)
    {
        $evento = new Eventos();

        $evento->setAutor($this->getUser());

        return $this->formEvento($request, $eventosBLL, $evento, '2');
    }

    /**
     * @Route("/evegest/{id}/edit", name="editarEvento")
     * @Method({"GET", "POST"})
     */
    public function editar(Request $request, EventosBLL $eventosBLL, Eventos $evento, $id){
        if($this->getUser()->getId() == $id || $this->isGranted(['ROLE_GESTOR'])) {

            try{
                $evento->setPoster(new File($this->getParameter('pwd') . $evento->getPoster()));
            }catch (\Exception $exception){

            }

            return $this->formEvento($request, $eventosBLL, $evento, '1');
        }
        else
            return $this->redirect('/eventos/'.$this->getUser()->getId().'/listado');
    }

    /**
     * @Route("/evegest/{id}/delete", name="eliminarEvento")
     * @Method("GET")
     */
    public function eliminar(EventosBLL $eventosBLL, $id){
        $evento = $eventosBLL->getEventos(['id' => $id])[0];
        $poster = $evento->getPoster();

        if($this->getUser()->getId() == $id || $this->isGranted(['ROLE_ADMIN'])) {
            if (strpos($poster, 'serverimg') === false) {
                try{
                    unlink($this->getParameter('pwd') . $poster);
                }catch (\Exception $exception){

                }
            }

            $eventosBLL->eliminaEventos($id);
        }

        return $this->redirect('/eventos/'.$this->getUser()->getId().'/listado');
    }
}