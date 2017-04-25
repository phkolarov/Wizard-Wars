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

        foreach ($necklaces as $necklace) {

            if ($necklace->getNecklace()->getUpdater() == 1) {
                $necklacesUpdaters[] = $necklace;
            }
        }


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

        if ($lycan) {

            $money = $user->getGold();
            $requestedGOLD = $request->get('price');
            if ($money >= ($requestedGOLD)) {

                $em = $this->getDoctrine()->getManager();
                $user->setGold($money - $requestedGOLD);
                $level = $lycan->getLevel();
                $lycan->setLevel($level + 1);
                $lycan->setAttack($lycan->getAttack() + $level / 2 + 5);
                $lycan->setHealth($lycan->getHealth() + $level / 2 + 5);
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
        $necklaces = $em->createQuery('SELECT un FROM AppBundle:UsersNecklaces un LEFT JOIN AppBundle:Necklaces n WHERE un.necklace = n.id and n.updater = \'1\'')->getResult();
        $necklacesUpdaters = [];
        foreach ($necklaces as $necklace) {

            if ($necklace->getNecklace()->getUpdater() != 1) {
                $necklacesUpdaters[] = $necklace;
            }
        }
        return $this->render('pages/update-necklaces.html.twig', ['necklaces' => $necklacesUpdaters]);
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


    /**
     * @Security("is_authenticated()")
     * @Route("/shop", name="shop")
     * @return \Symfony\Component\HttpFoundation\Response
     * @param Request $request
     */
    public function shopAction(Request $request)
    {
        return $this->render('pages/shop.html.twig');
    }


    /**
     * @Security("is_authenticated()")
     * @Route("/buy-necklace", name="buy-necklace")
     * @return \Symfony\Component\HttpFoundation\Response
     * @param Request $request
     */
    public function BuyNecklaceAction(Request $request)
    {

        $em = $this->get('doctrine.orm.entity_manager');
        $dql = "SELECT n FROM AppBundle:Necklaces n";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            4
        );

        return $this->render('pages/buy-necklaces.html.twig', ['pagination' => $pagination]);
    }


    /**
     * @Security("is_authenticated()")
     * @Route("/purchase-necklace/{id}", name="purchase-necklace")
     * @return \Symfony\Component\HttpFoundation\Response
     * @param Request $request
     */
    public function PurchaseNecklaceAction($id,Request $request)
    {
        $gold = $request->get('priceGold');
        $mana = $request->get('priceMana');

        $user = $this->get('security.token_storage')->getToken()->getUser();

        if($user->getMana() >= $mana && $user->getGold()>= $gold){

            $em = $this->get('doctrine.orm.entity_manager');

            $user->setGold($user->getGold() - $gold);
            $user->setMana($user->getMana() - $mana);
            $em->flush();

            $necklace = $this->getDoctrine()->getRepository('AppBundle:Necklaces')->findOneBy(['id' => $id]);

            $userNecklace = new UsersNecklaces();
            $userNecklace->setNecklace($necklace);
            $userNecklace->setTimeToUpdate(new \DateTime());
            $userNecklace->setUser($user);
            $userNecklace->setLevel(1);
            $em->persist($userNecklace);
            $em->flush();

            return $this->redirectToRoute('buy-necklace',['success'=>'Successfully purchased this item']);

        }else{
            return $this->redirectToRoute('buy-necklace',['error'=>'You not enough resources']);
        }
    }

    /**
     * @Security("is_authenticated()")
     * @Route("/buy-lycans", name="buy-lycans")
     * @return \Symfony\Component\HttpFoundation\Response
     * @param Request $request
     */
    public function BuyLycansAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $dql = "SELECT l FROM AppBundle:Lycans l";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            4
        );

        return $this->render('pages/buy-lycans.html.twig', ['pagination' => $pagination,'price'=>self::LYCAN_PRICE]);
    }

    /**
     * @Security("is_authenticated()")
     * @Route("/buy-wand", name="buy-wand")
     * @return \Symfony\Component\HttpFoundation\Response
     * @param Request $request
     */
    public function BuyWandsAction()
    {

    }


}