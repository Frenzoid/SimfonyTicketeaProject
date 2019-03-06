<?php
/**
 * Created by PhpStorm.
 * User: dwes
 * Date: 12/02/18
 * Time: 16:48
 */

namespace App\Controller\REST;

use App\BLL\UsuarioBLL;
use App\Entity\Usuarios;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class UserRestController extends BaseApiController
{
    /**
     * @Route("/usuarios/{id}.{_format}", name="update_evento",
     *  requirements={"id": "\d+", "_format": "json" },
     *  defaults={"_format": "json"})
     * @IsGranted("ROLE_ADMIN")
     * @Method("PUT")
     */
    public function update(Request $request, Usuarios $user, UsuarioBLL $userBLL)
    {
        $data = $this->getContent($request);
        $producto = $userBLL->actualizar($user, $data);
        return $this->getResponse($producto, Response:: HTTP_OK );
    }

    /**
     * @Route("/usuarios/{id}.{_format}", name="get_usuario",
     * requirements={"id": "\d+","_format": "json"},
     * defaults={"_format": "json"})
     * @IsGranted("ROLE_ADMIN")
     * @Method("GET")
     */
    public function getOne(Usuarios $user, UsuarioBLL $userBLL)
    {
        return $this->getResponse($userBLL->toArray($user));
    }

    /**
     * @Route("/usuarios.{_format}", name="get_usuarios",
     * defaults={"_format": "json"},
     * requirements={"_format": "json"})
     * @IsGranted("ROLE_ADMIN")
     * @Method("GET")
     */
    public function getAll(UsuarioBLL $userBLL)
    {
        $users = $userBLL->getAllRest();
        return $this->getResponse($users);
    }

    /**
     * @Route("/usuarios/{id}.{_format}", name="delete_usuario",
     * requirements={ "id": "\d+", "_format": "json" },
     * defaults={"_format": "json"})
     * @IsGranted("ROLE_ADMIN")
     * @Method("DELETE")
     */
    public function delete(Usuarios $user, UsuarioBLL $userBLL)
    {
        $userBLL->delete($user);

        return $this->getResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/profile.{_format}", name="profile",
     * requirements={"_format": "json"},
     * defaults={"_format": "json"})
     * @Method("GET")
     */
    public function profile(UsuarioBLL $usuarioBLL)
    {
        $user = $usuarioBLL->profile();

        return $this->getResponse($user);
    }

    /**
     * @Route("/profile/password.{_format}", name="cambia_password",
     * requirements={ "_format": "json" },
     * defaults={"_format": "json"})
     * @Method("PATCH")
     */
    public function cambiaPassword(Request $request, UsuarioBLL $userBLL)
    {
        $data = $this->getContent($request);
        if ( is_null ($data['password']) || !isset($data['password']) || empty($data['password']))
            throw new BadRequestHttpException('No se ha recibido el password');

        $user = $userBLL->cambiaPassword($data['password']);

        return $this->getResponse($user);
    }

    /**
     * @Route("/profile/avatar.{_format}", name="cambia_avatar",
     * requirements={
     * "_format": "json"
     * },
     * defaults={"_format": "json"})
     * @Method("PATCH")
     */
    public function cambiaAvatar(Request $request, UsuarioBLL $userBLL)
    {
        $data = $this->getContent($request);
        if (is_null($data['avatar']))
            throw new BadRequestHttpException('No se ha recibido la imagen');
        $avatars_directory = $this->getParameter('avatars_directory');
        $url_avatars_directory = $this->getParameter('url_avatars_directory');
        $user = $userBLL->cambiaAvatar($request, $data['avatar'], $avatars_directory, $url_avatars_directory);
        return $this->getResponse($user);
    }

}
