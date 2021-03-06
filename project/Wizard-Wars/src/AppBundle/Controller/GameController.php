<?php
/**
 * Created by PhpStorm.
 * User: mst
 * Date: 12.4.2017 г.
 * Time: 21:52
 */

namespace AppBundle\Controller;


use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;


class GameController extends Controller
{


    /**
     * @Security("is_authenticated()")
     * @Route("/", name="homepage")
     */
    public function gameWorldAction()
    {

        $helper = $this->get('security.authentication_utils');
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $kingdoms = $this->getDoctrine()
            ->getRepository('AppBundle:Kingodms')->findAll();


        $kingdomsArray = [];

        foreach ($kingdoms as $kingdom) {

            $object = ($kingdom);

            if (is_int($object->getOwnerId())) {
                $kingdomOwner = $this->getDoctrine()
                    ->getRepository('AppBundle:User')
                    ->find($object->getOwnerId());

                $object->setKingName($kingdomOwner->getName());

            } else {
                $object->setKingName("No king");
            }

            $kingdomsArray[] = $object;
        }


        $jsonContent = json_encode($kingdomsArray);
        $x = $user->getX();
        $y = $user->getX();

        return $this->render(
            'pages/real_world.html.twig',
            array(
                'x' => $x,
                'y' => $y,
                'kingdoms' => $jsonContent,
                'userId'=>$user->getId(),
                'last_username' => $helper->getLastUsername(),
                'error' => $helper->getLastAuthenticationError(),
            )
        );
    }

    /**
     * @Security("is_authenticated()")
     * @Route("/castleAttack/{id}", options={"expose"=true}, name="castleAttack")
     */
    public function attackOpponent($id)
    {

        $kingdom = $this->getDoctrine()
            ->getRepository('AppBundle:Kingodms')
            ->find($id);

        $user = $this->get('security.token_storage')->getToken()->getUser();


        if ($user->getHealth() <= 0) {
            return $this->redirectToRoute('own-kingdom', ["message" => "you must regenerate your health"]);
        }

        $castleAttack = $kingdom->getCastleAttack();
        $castleHealth = $kingdom->getCastleHealth();
        $castleKing = "NO KING CASTLE";
        $bonusCastleLive = 0;

        if ($kingdom->getOwnerId() != null) {

            $owner = $this->getDoctrine()
                ->getRepository('AppBundle:User')
                ->find($kingdom->getOwnerId());

            $castleKing = $owner->getName();

            $necklaces = $this->getDoctrine()
                ->getRepository('AppBundle:UsersNecklaces')
                ->findBy(['user' => $owner->getId(), 'castle_id' => $id]);

            foreach ($necklaces as $necklace) {
                $bonusCastleLive += intval($necklace->getNecklace()->getCastleHealthBonus());
            }

            $lycans = $this->getDoctrine()->getRepository('AppBundle:Lycans')->findBy(['castleId' => $id]);

            foreach ($lycans as $lycan){
                $castleAttack += intval($lycan->getAttack());
                $castleHealth += intval($lycan->getHealth());
            }
        }




        $userHealth = $user->getHealth();
        $userBonusHealth = 0;
        $userAttack = $user->getAttack();
        $wandName = 'DEFAULT WAND';

        $userNecklaces = $this->getDoctrine()
            ->getRepository('AppBundle:UsersNecklaces')
            ->findBy(['user' => $id]);


        if (is_int($user->getWand())) {

            $userWand = $this->getDoctrine()
                ->getRepository('AppBundle:UsersMagicWands')
                ->findOneBy(['user'=>$user,'magicWand'=>$user->getWand()]);


            $userAttack += ($userWand->getMagicWand()->getAttackBonus() * $userWand->getLevel());
            $userBonusHealth += ($userWand->getMagicWand()->getHealthBonus()  * $userWand->getLevel());
            $wandName = $userWand->getMagicWand()->getName();
        }

        foreach ($userNecklaces as $necklace) {

            // castle 0 updater 1 user 2
            if ($necklace->getNecklace()->getUpdater() == 2) {
                $userBonusHealth += intval($necklace->getNecklace()->getHealthBonus());
                $userAttack += intval($necklace->getNecklace()->getAttackBonus());
            }
        }

        return $this->render('pages/action_game.html.twig', [
            'castleAttack' => $castleAttack,
            'castleHealth' => $castleHealth,
            'bonusCastleLive' => $bonusCastleLive,
            'castleKing' => $castleKing,
            'wizardName' => $user->getName(),
            'userHealth' => $userHealth,
            'userBonusHealth' => $userBonusHealth,
            'userAttack' => $userAttack,
            'wandName' => $wandName,
            'castleId' => $id
        ]);
    }


    /**
     * @Route("/gameResult", name="send-game-result")
     * @Method("POST")
     * @param Request $request
     * @return Response
     */
    public function gameResult(Request $request)
    {

        $submittedToken = $request->headers->get('host');
        $response = new Response();

        if (!$this->isCsrfTokenValid('token_id', $submittedToken)) {
            $response->setContent(json_encode(array(
                'error' => "not authenticated",
            )));
        }


        $playerHealth = $request->get('playerHealth');
        $opponentCastleHealth = $request->get('opponentCastleHealth');
        $castleId = $request->get('castleId');
        $result = $request->get('result');

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $castle = $this->getDoctrine()->getRepository('AppBundle:Kingodms')->find($castleId);



        $user->setHealth($playerHealth);

        $castle->setCastleHealth($opponentCastleHealth);
        $em = $this->getDoctrine()->getManager();

        if ($playerHealth > 0 && $opponentCastleHealth > 0 && $result == "escape") {

            $response->setContent(json_encode(array(
                'success' => "escaped",
            )));
            return $response;
        } else if ($playerHealth > 0 && $opponentCastleHealth < 0 && $result == "win") {
            $user->setXP($user->getXP()+ 80 * $user->getLevel());
            $user->setGold($user->getGold() + 20);
            $user->setMana($user->getGold() + 20);
            $lycans = $this->getDoctrine()->getRepository('AppBundle:Lycans')->findBy(['castleId'=>$castleId]);

            foreach ($lycans as $lycan) {
                $em->remove($lycan);
            }
            $castle->setOwnerId($user->getId());
            $castle->setCastleHealth(500);
            $response->setContent(json_encode(array(
                'success' => "win",
            )));
            $em->flush();

            return $response;
        } else if ($playerHealth < 0 && $opponentCastleHealth > 0 && $result == "lose") {

            $totalMana = $user->getMana() - $playerHealth;

            if ($totalMana < 0) {

                $user->setMana(0);
                $user->setAttack(0);
                $user->setHealth(0);
                $user->setMoney(0);

                $userNecklaces = $this->getDoctrine()->getRepository('UsersNecklaces')->findBy(['user'=>$user]);

                foreach ($userNecklaces as $necklace){

                    if($userNecklaces->getNecklace()->getUpdater()->getType() == 'Updater'){

                        $em->remove($necklace);
                        $em->flush();
                    }
                }

                $response->setContent(json_encode(array(
                    'success' => "die",
                )));
                $em->flush();
                return $response;
            } else {
                $user->setMana($totalMana);

                $response->setContent(json_encode(array(
                    'success' => "lose",
                )));

                $em->flush();
                return $response;
            }
        } else {
            $user->setHealth(500);
            $castle->setHealth(500);

            $response->setContent(json_encode(array(
                'success' => "draw",
            )));

            $em->flush();
            return $response;
        }

    }


}