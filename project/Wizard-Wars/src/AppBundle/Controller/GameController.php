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
use Symfony\Component\BrowserKit\Request;
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


        $castleAttack = $kingdom->getCastleAttack();
        $castleHealth = $kingdom->getCastleHealth();
        $castleKing = "NO KING";


        if ($kingdom->getOwnerId() != null) {

            $owner = $this->getDoctrine()
                ->getRepository('AppBundle:Kingodms')
                ->find($id);


            $castleKing = "KING " . $owner->getName();

            $necklaces = $this->getDoctrine()
                ->getRepository('AppBundle:UsersNecklaces')
                ->findAll(['user_id' => $id]);


            foreach ($necklaces as $necklace) {

                $castleHealth += intval($necklace->getNecklace()->getCastleHealthBonus());
            }
        }


        $userHealth = $user->getHealth();
        $userAttack = $user->getAttack();

        $userNecklaces = $this->getDoctrine()
            ->getRepository('AppBundle:UsersNecklaces')
            ->findAll(['user_id' => $id]);


        foreach ($userNecklaces as $necklace) {

            $userHealth += intval($necklace->getHealthBonus()->getCastleHealthBonus());
            $userAttack += intval($necklace->getAttackBonus()->getCastleHealthBonus());
        }

        return $this->render('pages/action_game.html.twig', [
            'castleAttack' => $castleAttack,
            'castleHealth' => $castleHealth,
            'castleKing' => $castleKing,
            'userHealth' => $userHealth,
            'userAttack' => $userAttack
        ]);
    }
}