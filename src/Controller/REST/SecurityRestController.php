<?php
/**
 * Created by PhpStorm.
 * User: frenzoid
 * Date: 24/02/18
 * Time: 22:15
 */

namespace App\Controller\REST;


use App\BLL\UsuarioBLL;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class SecurityRestController extends BaseApiController
{

    /**
     * @Route("/auth/login")
     */
    public function getTokenAction()
    {
        return new Response('', Response:: HTTP_UNAUTHORIZED );
    }

    /**
     * @Route("/auth/register.{_format}", name="register",
     * requirements={"_format": "json"},
     * defaults={"_format": "json"})
     * @Method("POST")
     */
    public function register(Request $request, UsuarioBLL $usuarioBLL)
    {
        $data = $this->getContent($request);
        $user = $usuarioBLL->nuevo($data);

        return $this->getResponse($user, Response:: HTTP_CREATED );
    }

    /**
     * @Route("/auth/login/google")
     */
    public function googleLogin(Request $request, UsuarioBLL $userBLL)
    {
        $data = $this->getContent($request);

        if ( is_null ($data['access_token'])
            || !isset($data['access_token'])
            || empty($data['access_token']))
            throw new BadRequestHttpException('No se ha recibido el token de google');

        $googleJwt = json_decode ( file_get_contents (
            "https://www.googleapis.com/plus/v1/people/me?access_token=" .
            $data['access_token']));

        $token = $userBLL->getTokenByEmail($googleJwt->emails[0]->value);

        return $this->getResponse(['token' => $token]);
    }


}