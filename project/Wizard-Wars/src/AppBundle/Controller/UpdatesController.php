<?php

namespace AppBundle\Controller;


use AppBundle\Entity\UsersNecklaces;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\DateTime;

class UpdatesController extends Controller
{


    const BASE_UPDATE_TIME = 2;
    const LYCAN_PRICE = 50;

    /**
     *
     * @Security("is_authenticated()")
     * @Route("/updates", options={"expose"=true}, name="updates")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function UpdaterViewAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->get('doctrine.orm.entity_manager');
        $necklacesUpdaters = $this->getDoctrine()->getRepository('AppBundle:UsersNecklaces')->getUpdaterNecklaces($user, $em);

        return $this->render('pages/updates.html.twig', [
            'updaters' => $necklacesUpdaters
        ]);
    }


    /**
     * @Security("is_authenticated()")
     * @Route("/update-necklace-action/{id}", name="update-necklace-action")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateNecklaceAction($id, Request $request)
    {

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $necklacesUpdaters = $this->getDoctrine()->getRepository('AppBundle:UsersNecklaces')->findOneBy(['user' => $user->getId(), 'id' => $id]);

        if ($necklacesUpdaters) {


            $money = $user->getGold();
            $requestedGOLD = $request->get('price');
            if ($money >= ($requestedGOLD)) {

                $user->setGold($money - $requestedGOLD);
                $em = $this->getDoctrine()->getManager();
                $level = $necklacesUpdaters->getLevel();
                $necklacesUpdaters->setLevel($level + 1);
                $em->flush();
                //$referer = $request->headers->get('referer');
                //var_dump($referer);
                return $this->redirectToRoute('updates', ['success' => 'Successfully updated']);

            } else {
                return $this->redirectToRoute('updates', ['error' => 'Not enough money']);
            }


        } else {
            return $this->redirectToRoute('updates', ['error' => 'Necklace not found']);
        }
    }


    /**
     * @Security("is_authenticated()")
     * @Route("/update-lycans", name="update-lycans")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateLycansAction()
    {

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $lycans = $this->getDoctrine()->getRepository('AppBundle:Lycans')->findBy(['user' => $user->getId()]);
        return $this->render('pages/update-lycans.html.twig', ['lycans' => $lycans]);
    }


    /**
     * @Security("is_authenticated()")
     * @Route("/update-lycan-action/{id}", name="update-lycan-action")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function realiseUpdateLycansAction($id, Request $request)
    {

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $lycan = $this->getDoctrine()->getRepository('AppBundle:Lycans')->findOneBy(['user' => $user->getId(), 'id' => $id]);
        $lycanEntity = $this->getDoctrine()->getRepository('AppBundle:Lycan')->findOneBy(['id' => 1]);

        if ($lycan) {

            $money = $user->getGold();
            $requestedGOLD = $request->get('price');
            if ($money >= ($requestedGOLD)) {

                $em = $this->getDoctrine()->getManager();
                $user->setGold($money - $requestedGOLD);
                $level = $lycan->getLevel();
                $lycan->setLevel($level + 1);
                $lycan->setAttack($lycanEntity->getAttack() * ($level + 1));
                $lycan->setHealth($lycanEntity->getHealth() * ($level + 1));
                $em->flush();

                return $this->redirectToRoute('update-lycans', ['error' => 'Successfully updated']);

            } else {
                return $this->redirectToRoute('update-lycans', ['error' => 'Not enough money']);
            }

        } else {
            return $this->redirectToRoute('update-lycans', ['error' => 'Lycan not found']);
        }
    }


    /**
     * @Security("is_authenticated()")
     * @Route("/update-necklace", name="update-necklace")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateNecklacesAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->get('doctrine.orm.entity_manager');

        $normalNecklaces = $this->getDoctrine()->getRepository('AppBundle:UsersNecklaces')->getNormalNecklaces($user, $em);


        return $this->render('pages/update-necklaces.html.twig', ['necklaces' => $normalNecklaces]);
    }

    /**
     * @Security("is_authenticated()")
     * @Route("/update-magic-wands", name="update-magic-wands")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateWandsAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $magicWands = $this->getDoctrine()->getRepository('AppBundle:UsersMagicWands')->findBy(['user' => $user]);


        return $this->render('pages/update-wands.html.twig', [
            'magicWands' => $magicWands,
            'userWand' => $user->getWand()
        ]);
    }


    /**
     * @Security("is_authenticated()")
     * @Route("/set-wand-update/{id}", name="set-wand-update")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function setUpdateAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $magicWands = $this->getDoctrine()->getRepository('AppBundle:UsersMagicWands')->findOneBy(['user' => $user, 'magicWand' => $id]);

        if ($magicWands) {
            $money = $user->getGold();
            $requestedGOLD = $request->get('gold');

            if ($money >= ($requestedGOLD)) {

                $user->setGold($user->getGold() - $requestedGOLD);
                $level = $magicWands->getLevel() * self::BASE_UPDATE_TIME;
                $stringTIme = "+$level minutes";
                $time = new \DateTime();

                $timePlus = strtotime($stringTIme, strtotime($time->format('Y-m-d H:i:s')));
                $totalTime = new \DateTime(date('Y-m-d H:i:s', $timePlus));
                $magicWands->setTimeToUpdate($totalTime);
                $magicWands->setStatus(1);
                $em->flush();

                return $this->redirectToRoute('update-magic-wands', ['success' => 'Successfully requested update']);
            } else {
                return $this->redirectToRoute('update-magic-wands', ['error' => 'You don\'t enough gold']);
            }

        } else {
            return $this->redirectToRoute('update-magic-wands', ['error' => 'You don\'t own this wand']);
        }
    }


}