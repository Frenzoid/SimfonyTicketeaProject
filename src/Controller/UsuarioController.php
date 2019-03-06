<?php
/**
 * Created by PhpStorm.
 * User: frenzoid
 * Date: 9/02/18
 * Time: 18:29
 */

namespace App\Controller;


use App\BLL\UsuarioBLL;
use App\Entity\Roles;
use App\Entity\Usuarios;
use App\Form\UsuarioType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;

class UsuarioController extends Controller
{

    /**
     * @Route("/usuarios/{id}", name="perfil")
     * @Template("usuarios/profile.html.twig")
     */
    public function mostrarUsuario(ObjectManager $em, $id){
        $vars = array('usuario' => $em->getRepository(Usuarios::class)->findOneBy(["id" => $id]));
        return $vars;
    }

    /**
     * @Route("/usuarios", name="usuariosListados")
     * @Template("usuarios/userslisted.html.twig")
     */
    public function listarUsuarios(ObjectManager $em){
        $vars = array('usuario' => $em->getRepository(Usuarios::class)->findAll());
        return $vars;
    }

    private function formUsuario(
        Request $request,
        UsuarioBLL $usuarioBLL,
        Usuarios $usuario,
        $status,
        ObjectManager $em)
    {
        $form = $this->createForm(UsuarioType::class, $usuario);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $file = $usuario->getAvatar();

            var_dump($file);

            if($file != null){

            $fileName = md5(uniqid()) .'.'. $file->guessExtension();

            $file->move($this->getParameter('avatar_dir'), $fileName);

            $usuario->setAvatar(explode('public',$this->getParameter('avatar_dir'))[1] . '/' . $fileName);

            }else
                $usuario->setAvatar('/serverimg/defaultavatar.jpg');

            if ($status == '1')
                $usuario->setRole($em->getRepository(Roles::class)->find('ROLE_COMPRADOR'));
            else if($status == '2' && !$this->isGranted(['ROLE_ADMIN']))
                $usuario->setRole($usuarioBLL->getUsuarios(['id' => $usuario->getId()])[0]->getRole());

            var_dump($usuario->getRole());

            $usuarioBLL->guardaUsuario($usuario);


            switch ($status){
                case'1':
                    return $this->redirectToRoute('login');
                break;
                case'2':
                    if($this->getUser()->getId() == $usuario->getId())
                        return $this->redirect('/usuarios/' . $usuario->getId());
                    else
                        return $this->redirectToRoute('usuariosListados');
                    break;
                case'3':
                    return $this->redirectToRoute('usuariosListados');
                break;
            }
        }

        return $this->render(
            'security/register.html.twig',
            [
                'form' => $form->createView(),
                'status' => $status
            ]
        );
    }

    /**
     * @Route("/registro", name="registro_pag")
     */
    public function registro(Request $request, UsuarioBLL $usuarioBLL, ObjectManager $em)
    {
        $usuarios = new Usuarios();

        return $this->formUsuario($request, $usuarioBLL, $usuarios, '1', $em);
    }


    /**
     * @Route("/admgest/nuevousuario", name="nuevoUsuario")
     * @Method({"GET", "POST"})
     */
    public function nuevo(Request $request, UsuarioBLL $usuarioBLL, ObjectManager $em)
    {
        $usuarios = new Usuarios();

        return $this->formUsuario($request, $usuarioBLL, $usuarios, '3', $em);
    }

    /**
     * @Route("/usuarios/{id}/edit", name="editarUsuario")
     * @Method({"GET", "POST"})
     */
    public function editar(Request $request, UsuarioBLL $usuarioBLL, Usuarios $usuarios, $id, ObjectManager $em){
        if($this->getUser()->getId() == $id || $this->isGranted(['ROLE_ADMIN'])) {

            try{
                $usuarios->setAvatar(new File($this->getParameter('pwd') . $usuarios->getAvatar()));
            }catch (\Exception $exception){

            }

            return $this->formUsuario($request, $usuarioBLL, $usuarios, '2', $em);
        }
        else
            return $this->redirectToRoute('usuariosListados');
    }

    /**
     * @Route("/usuarios/{id}/delete", name="eliminarUsuario")
     * @Method("GET")
     */
    public function eliminar(UsuarioBLL $usuarioBLL, $id){
        $usuario = $usuarioBLL->getUsuarios(['id' => $id])[0];
        $avatar = $usuario->getAvatar();

        if($this->getUser()->getId() == $id || $this->isGranted(['ROLE_ADMIN'])) {
            if (strpos($avatar, 'serverimg') === false) {
                try{
                    unlink($this->getParameter('pwd') . $avatar);
                }catch (\Exception $exception){

                }
            }

            $usuarioBLL->eliminaUsuario($id);
        }

        return $this->redirectToRoute('usuariosListados');
    }

}