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
    public function UpdaterViewAction()
    {

        $user = $this->get('security.token_storage')->getToken()->getUser();

//        $necklacesUpdaters = $this->getDoctrine()->getRepository('AppBundle:UsersNecklaces')->findBy(['user' => $user->getId(), 'castle_id' => null]);

        $em = $this->get('doctrine.orm.entity_manager');
        $necklaces = $em->createQuery('SELECT un FROM AppBundle:UsersNecklaces un LEFT JOIN AppBundle:Necklaces n WHERE un.necklace = n.id and n.updater = \'1\'')->getResult();

        $necklacesUpdaters = [];

        foreach ($necklaces as $necklace){

            if($necklace->getNecklace()->getUpdater() == 1){
                $necklacesUpdaters[] = $necklace;
            }
        }


        return $this->render('pages/updates.html.twig', [
            'updaters' => $necklacesUpdaters
        ]);
    }


    /**
     * @Security("is_authenticated()")
     * @Route("/update-updater/{id}", name="update-updater")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateUpdaterAction($id, Request $request){

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $necklacesUpdaters = $this->getDoctrine()->getRepository('AppBundle:UsersNecklaces')->findOneBy(['user' => $user->getId(), 'id' => $id]);

        if($necklacesUpdaters){


            $money = $user->getGold();
            $requestedGOLD = $request->get('price');
            if($money >= ($requestedGOLD)){

                $user->setGold($money - $requestedGOLD);
                $em = $this->getDoctrine()->getManager();
                $level = $necklacesUpdaters->getLevel();
                $necklacesUpdaters->setLevel($level + 1);
                $em->flush();

                return $this->redirectToRoute('updates',['error'=> 'Successfully updated']);

            }else{
                return $this->redirectToRoute('updates',['error'=> 'Not enough money']);
            }


        }else{
            return $this->redirectToRoute('updates',['error'=> 'Necklace not found']);
        }
    }


    /**
     * @Security("is_authenticated()")
     * @Route("/update-lycans", name="update-lycans")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateLycansAction(){

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $lycans = $this->getDoctrine()->getRepository('AppBundle:Lycans')->findBy(['user' => $user->getId()]);
        return $this->render('pages/update-lycans.html.twig',['lycans'=>$lycans]);
    }


    /**
     * @Security("is_authenticated()")
     * @Route("/update-lycan-action/{id}", name="update-lycan-action")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function realiseUpdateLycansAction($id, Request $request){

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $lycan = $this->getDoctrine()->getRepository('AppBundle:Lycans')->findOneBy(['user' => $user->getId(), 'id' => $id]);

        if($lycan){

            $money = $user->getGold();
            $requestedGOLD = $request->get('price');
            if($money >= ($requestedGOLD)){

                $user->setGold($money - $requestedGOLD);
                $em = $this->getDoctrine()->getManager();
                $level = $lycan->getLevel();
                $lycan->setLevel($level + 1);
                $lycan->setAttack( $lycan->getAttack() + $level / 2 + 5);
                $lycan->setHealth( $lycan->getHealth() + $level / 2 + 5);
                $em->flush();

                return $this->redirectToRoute('update-lycans',['error'=> 'Successfully updated']);

            }else{
                return $this->redirectToRoute('update-lycans',['error'=> 'Not enough money']);
            }
            
        }else{
            return $this->redirectToRoute('update-lycans',['error'=> 'Lycan not found']);
        }
    }




    /**
     * @Security("is_authenticated()")
     * @Route("/update-necklaces", name="update-necklaces")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateNecklacesAction(){

    }

    /**
     * @Security("is_authenticated()")
     * @Route("/update-wands", name="update-wands")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateWandsAction(){

    }
}