<?php
/**
 * Created by PhpStorm.
 * User: mst
 * Date: 22.4.2017 г.
 * Time: 13:26
 */

namespace AppBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UpdatesController extends Controller
{


    /**
     *
     * @Security("is_authenticated()")
     * @Route("/updates", name="updates")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function UpdaterView(){

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $necklacesUpdaters = $this->getDoctrine()->getRepository('AppBundle:UsersNecklaces')->findBy(['user' => $user->getId(), 'castle_id' => null]);


        return $this->render('pages/updates.html.twig',[
            'updaters' => $necklacesUpdaters
        ]);
    }


}