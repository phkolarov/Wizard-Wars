<?php
/**
 * Created by PhpStorm.
 * User: mst
 * Date: 19.4.2017 г.
 * Time: 20:55
 */

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class CastleController extends Controller
{

    const CATACOMB_LEVEL = 2;
    /**
     * @Security("is_authenticated()")
     * @Route("castles", name="castle")
     * @return mixed
     */
    public function castlesAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $ownCastles = $this->getDoctrine()->getRepository('AppBundle:Kingodms')->findBy(['ownerId' => $user->getId()]);
        $userNecklaces = $this->getDoctrine()->getRepository('AppBundle:UsersNecklaces')->findBy(['user' => $user]);
        $magicWands = $this->getDoctrine()->getRepository('AppBundle:UsersMagicWands')->findBy(['user' => $user]);


        return $this->render('pages/castle.html.twig', [
            'ownCastles' => $ownCastles,
            'userNecklaces' => $userNecklaces,
            'magicWands' => $magicWands,
            'userWand'=>$user->getWand()
        ]);
    }

    /**
     * @Security("is_authenticated()")
     * @Route("catacombs", name="catacombs")
     * @return mixed
     */
    public function catacombsAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $ownCastles = $this->getDoctrine()->getRepository('AppBundle:Kingodms')->findBy(['ownerId' => $user->getId()]);
        $userNecklaces = $this->getDoctrine()->getRepository('AppBundle:UsersNecklaces')->findBy(['user' => $user]);
        $lycans = $this->getDoctrine()->getRepository('AppBundle:Lycans')->findBy(['user' => $user->getId()]);

        $lycCastles = [];

        foreach ($lycans as $lycan) {

            if (is_numeric($lycan->getCastleId())) {

                $ownCastle = $this->getDoctrine()->getRepository('AppBundle:Kingodms')->findOneBy(['id' => $lycan->getCastleId()]);

                $lycan->castleName = $ownCastle->getCastleName();
            } else {
                $lycan->castleName = "No associated castle";
            };
            $lycCastles[] = $lycan;
        }

       if($user->getLevel() >= self::CATACOMB_LEVEL){

           return $this->render('pages/catacombs.html.twig', [
               'ownCastles' => $ownCastles,
               'userNecklaces' => $userNecklaces,
               'userWand' => $user->getWand(),
               'lycans' => $lycCastles
           ]);
       }else{
           return $this->redirectToRoute("castle",["error"=>"you need level ".self::CATACOMB_LEVEL." level to access the DANGER CATACOMBS"]);
       }
    }

    /**
     * @Security("is_authenticated()")
     * @Route("useWand/{id}", name="useWand")
     * @Method("POST")
     */
    public function useWandAction($id)
    {

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $hasWand = $this->getDoctrine()->getRepository('AppBundle:UsersMagicWands')->findOneBy(['user' => $user, 'magicWand' => $id]);

        if ($hasWand) {

            $user->setWand($hasWand->getMagicWand()->getId());
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute("castle", ["success" => "Successfully change your wand"]);
        } else {
            return $this->redirectToRoute("castle", ["error" => "You do not own that wand!"]);
        }
    }

    /**
     * @Security("is_authenticated()")
     * @Route("setNecklace/{necklaceId}", name="setNecklace")
     * @Method("POST")
     */
    public function useNecklace($necklaceId, Request $request)
    {

        $castleId = $request->get('castleId');
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $hasNecklace = $this->getDoctrine()->getRepository('AppBundle:UsersNecklaces')->findOneBy(['user' => $user, 'id' => $necklaceId]);
        $castle = $this->getDoctrine()->getRepository('AppBundle:Kingodms')->findOneBy(['ownerId' => $user->getId()]);

        if ($hasNecklace && $castle) {

            $hasNecklace->setCastleId($castleId);
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute("castle", ["success" => "Successfully set your necklace"]);
        } else {
            return $this->redirectToRoute("castle", ["error" => "You do not own that necklace or kingdom!"]);
        }
    }


    /**
     * @Security("is_authenticated()")
     * @Route("setLycan/{lycanId}", name="setLycanToCastleGuard")
     * @Method("POST")
     */
    public function setLycan($lycanId, Request $request)
    {

        $castleId = $request->get('castleId');
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $lycan = $this->getDoctrine()->getRepository('AppBundle:Lycans')->findOneBy(['id' => $lycanId]);
        $castle = $this->getDoctrine()->getRepository('AppBundle:Kingodms')->findOneBy(['ownerId' => $user->getId()]);

        if ($lycan && $castle && $castleId != "") {

            $lycan->setCastleId($castleId);
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute("catacombs", ["success" => "Successfully set your necklace"]);
        } else {
            return $this->redirectToRoute("catacombs", ["error" => "You do not own that necklace or kingdom!"]);
        }
    }
}