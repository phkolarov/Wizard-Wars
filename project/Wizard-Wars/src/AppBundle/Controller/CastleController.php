<?php
/**
 * Created by PhpStorm.
 * User: mst
 * Date: 19.4.2017 г.
 * Time: 20:55
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class CastleController extends Controller
{


    /**
     * @Security("is_authenticated()")
     * @Route("useWand/{id}", name="useWand")
     * @Method("POST")
     */
    public function useWandAction($id){

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $hasWand = $this->getDoctrine()->getRepository('AppBundle:UsersMagicWands')->findOneBy(['user'=>$user,'magicWand'=> $id]);

        if($hasWand){

            $user->setWand($hasWand->getMagicWand()->getId());
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute("castle",["success"=>"Successfully change your wand"]);
        }else{
            return $this->redirectToRoute("castle",["error"=>"You do not own that wand!"]);
        }
    }

}