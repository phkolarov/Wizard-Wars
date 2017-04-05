<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Race;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class HomeController extends Controller
{
    /**
     * @Security("is_authenticated()")
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $helper = $this->get('security.authentication_utils');

        return $this->render(
            'pages/index.html.twig',
            array(
                'last_username' => $helper->getLastUsername(),
                'error'         => $helper->getLastAuthenticationError(),
            )
        );
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

    /**
     * @Security("is_authenticated()")
     * @Route("/choose_race", name="choose_race")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function chooseRace(Request $request){

        $user = $this->get('security.token_storage')->getToken()->getUser();

        if($user->getChoosedRace() != 1){
            return $this->render('pages/choose_race.html.twig');
        }else{
           return $this->redirectToRoute('homepage');
        }
    }


    /**
     * @param Request $request
     * @Route("/save_race", name="save_race")
     * Method("POST")
     */
    public function saveRace(Request $request){


        var_dump(123);
//        $user = $this->get('security.context')->getToken()->getUser();
//        $race =$request-$this->get("race");
//
//        $currentRace = Race::where('name', $race)->first();
//
//        $user->race = $currentRace->id;



    }

}
