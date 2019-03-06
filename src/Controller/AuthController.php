<?php
/**
 * Created by PhpStorm.
 * User: frenzoid
 * Date: 14/02/18
 * Time: 17:41
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends Controller
{
    /**
     * @Route("/auth/login")
     */
    public function getTokenAction()
    {
        // The security layer will intercept this request
        return new Response('', Response::HTTP_UNAUTHORIZED);
    }
}