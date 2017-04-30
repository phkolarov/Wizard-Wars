<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Race;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class HomeController extends Controller
{
    /**
     * @Security("is_authenticated()")
     * @Route("/kingdom",options={"expose"=true}, name="own-kingdom")
     */
    public function indexAction(Request $request)
    {
        $helper = $this->get('security.authentication_utils');
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $magicType = "red";

        if($user->getRace()->getName() == "BlueWizard"){
            $magicType = "blue";
        }


        $allBuildings = [];
        $defBuildings = $this->getDoctrine()->getRepository("AppBundle:Buildings")->findBy(["default"=> '1']);
        $userBuildings = $this->getDoctrine()->getRepository('AppBundle:UsersBuildings')->findBy(['user'=>$user]);
        $em = $this->getDoctrine()->getManager();

        foreach ($defBuildings as $defBuilding){
            $allBuildings[] = $defBuilding;
        }

        foreach ($userBuildings as $userBuilding){
            $building = $userBuilding->getBuilding();

            $now = date("Y-m-d H:i:s");
            $builtTime = $userBuilding->getTimeToBuild()->format('Y-m-d H:i:s');

            $today_time = strtotime($now);
            $expire_time = strtotime($builtTime);

            if($expire_time < $today_time && $userBuilding->getIsBuilt() == 0 && $building->getDefault() == 0){
                $userBuilding->setIsBuilt(1);
                $em->flush();
                $allBuildings[] = $building;
            }elseif ($expire_time < $today_time && $userBuilding->getIsBuilt() == 1  && $building->getDefault()  == 0){
                $allBuildings[] = $building;
            }
        }


        $jsonContent = json_encode($allBuildings);

        return $this->render(
            'pages/index.html.twig',
            array(
                'last_username' => $helper->getLastUsername(),
                'error'         => $helper->getLastAuthenticationError(),
                'buildings' => $jsonContent,
                'magicType'=>$magicType
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
