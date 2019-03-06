<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Template("security/login.html.twig")
     */
    public function login(Request $request, AuthenticationUtils $authUtils)
    {
        if ($this->isGranted(['ROLE_COMPRADOR']))
            return $this->redirectToRoute('portada');

        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        return array(
            'last_username' => $lastUsername,
            'error' => $error,
        );
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){
        return $this->redirectToRoute('portada');
    }
}