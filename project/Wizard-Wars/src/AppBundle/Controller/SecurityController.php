<?php
/**
 * Created by PhpStorm.
 * User: mst
 * Date: 30.3.2017 г.
 * Time: 21:29
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $helper = $this->get('security.authentication_utils');

        return $this->render(
            'pages/login.html.twig',
            array(
                'last_username' => $helper->getLastUsername(),
                'error'         => $helper->getLastAuthenticationError(),
            )
        );
    }

    /**
     * @Route("/login_check", name="security_login_check")
     */
    public function loginCheckAction()
    {

    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {

    }
}