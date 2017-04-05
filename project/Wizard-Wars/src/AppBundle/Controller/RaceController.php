<?php
/**
 * Created by PhpStorm.
 * User: mst
 * Date: 5.4.2017 г.
 * Time: 21:32
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RaceController extends Controller
{


    /**
     * @Route("/choosing_race", name="choosing_race")
     * @Method("POST")
     */
    public function chooseRaceAction(Request $request){

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {


            $type = $request->get('type');
            $race = $this->getDoctrine()->getRepository('AppBundle:Race')->findBy(["name"=>$type]);
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $user->setChoosedRace(1);
            $user->setRace($race[0]);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $response = new Response();
            $response->setContent(json_encode(array(
                'success' => "choosed",
            )));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }
    }

}