<?php
/**
 * Created by PhpStorm.
 * User: mst
 * Date: 26.4.2017 г.
 * Time: 10:25
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Lycans;
use AppBundle\Entity\UsersMagicWands;
use AppBundle\Entity\UsersNecklaces;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\DateTime;

class ShopController extends Controller
{


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
    public function PurchaseNecklaceAction($id, Request $request)
    {
        $gold = $request->get('priceGold');
        $mana = $request->get('priceMana');

        $user = $this->get('security.token_storage')->getToken()->getUser();

        if ($user->getMana() >= $mana && $user->getGold() >= $gold) {

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

            return $this->redirectToRoute('buy-necklace', ['success' => 'Successfully purchased this item']);

        } else {
            return $this->redirectToRoute('buy-necklace', ['error' => 'Not enough resources']);
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
        $lycan = $this->getDoctrine()->getRepository('AppBundle:Lycan')->find(1);

        return $this->render('pages/buy-lycans.html.twig', ['lycan' => $lycan]);
    }


    /**
     * @Security("is_authenticated()")
     * @Route("/purchase-lycans", name="purchase-lycans")
     * @Method("POST")
     * @return \Symfony\Component\HttpFoundation\Response
     * @param Request $request
     */
    public function PurchaseLycanAction(Request $request)
    {

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $lycan = $this->getDoctrine()->getRepository('AppBundle:Lycan')->find(1);
        $countOfRequestedLycans = $request->get('countOfLycans');
        ;

        $priceGold = $lycan->getPrice() * $countOfRequestedLycans;
        $priceMana = $lycan->getPriceMana() * $countOfRequestedLycans;


        if($user->getGold() >= $priceGold && $user->getMana() >= $priceMana){
            $em = $this->getDoctrine()->getManager();

            for ($i = 0; $i < $countOfRequestedLycans; $i++) {

                $lycanName = "Lycan-" . $user->getName() . "-" . uniqid();
                $userLycan = new Lycans();
                $userLycan->setLevel(1);
                $userLycan->setUser($user);
                $userLycan->setTimeToUpdate(new \DateTime());
                $userLycan->setHealth($lycan->getHealth());
                $userLycan->setAttack($lycan->getAttack());
                $userLycan->setName($lycanName);
                $em->persist($userLycan);
                $em->flush();
            }
            $user->setGold($user->getGold() - $priceGold);
            $user->setMana($user->getMana() - $priceMana);
            $em->flush();

            return $this->redirectToRoute('buy-lycans', ['success' => 'Successfully purchased lycans']);
        }else{
            return $this->redirectToRoute('buy-lycans', ['error' => 'Not enough resources']);

        }

    }


    /**
     * @Security("is_authenticated()")
     * @Route("/buy-wands", name="buy-wands")
     * @return \Symfony\Component\HttpFoundation\Response
     * @param Request $request
     */
    public function BuyWandsAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $dql = "SELECT w FROM AppBundle:MagicWands w";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            4
        );

        return $this->render('pages/buy-wands.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @Security("is_authenticated()")
     * @Route("/purchase-wand/{id}", name="purchase-wand")
     * @return \Symfony\Component\HttpFoundation\Response
     * @param Request $request
     */
    public function PurchaseWandAction($id,Request $request){

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $priceGold = $request->get('priceGold');
        $priceMana = $request->get('priceMana');
        $currentWand = $this->getDoctrine()->getRepository('AppBundle:MagicWands')->find($id);


//        if($currentWand->getId() == $user->getWand()){
//            return $this->redirectToRoute('buy-wands', ['error' => 'You already have that wand']);
//        }

        if($user->getGold() >= $priceGold && $user->getMana() >= $priceMana) {
            $em = $this->getDoctrine()->getManager();

            $userWand = new UsersMagicWands();
            $userWand->setTimeToUpdate(new \DateTime());
            $userWand->setUser($user);
            $userWand->setLevel(1);
            $userWand->setMagicWand($currentWand);
            $userWand->setStatus(0);

            $user->setGold($user->getGold() - $priceGold);
            $user->setMana($user->getMana() - $priceMana);
            $em->persist($userWand);
            $em->flush();

            return $this->redirectToRoute('buy-wands', ['success' => 'Successfully purchased magic wand']);

        }else{
            return $this->redirectToRoute('buy-wands', ['error' => 'Not enough resources']);
        }
    }
}