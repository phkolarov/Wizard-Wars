<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('pages/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/public", name="public")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function publicPage(Request $request){
        return $this->render('pages/public.html.twig');
    }

    /**
     * @Security("is_authenticated()")
     * @Route("/registered", name="registered")
     * @param Request $requsest
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registeredPage(Request $requsest){
        return $this->render('pages/game.html.twig');
    }
}
