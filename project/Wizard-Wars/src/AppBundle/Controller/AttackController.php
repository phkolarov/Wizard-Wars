<?php
/**
 * Created by PhpStorm.
 * User: mst
 * Date: 26.4.2017 г.
 * Time: 21:16
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Battle;
use AppBundle\Entity\BattleReports;
use AppBundle\Entity\Lycans;
use AppBundle\Entity\LycansAttack;
use AppBundle\Entity\UsersMagicWands;
use AppBundle\Entity\UsersNecklaces;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Validator\Constraints\DateTime;

class AttackController extends Controller
{

    /**
     * @Security("is_authenticated()")
     * @Route("/attack_lycans", options={"expose"=true}, name="attack_lycans")
     * @return \Symfony\Component\HttpFoundation\Response
     * @param Request $request
     */
    public function AttackOpponentViewAction(Request $request)
    {


        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $userLycans = $this->getDoctrine()->getRepository('AppBundle:Lycans')->getUserFreeLycans($user, $em);

        $em = $this->get('doctrine.orm.entity_manager');
        $dql = "SELECT k FROM AppBundle:Kingodms k";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            4
        );
        return $this->render('pages/attack.html.twig', ['lycans' => $userLycans, 'pagination' => $pagination,'userId'=>$user->getId()]);
    }


    /**
     * @Security("is_authenticated()")
     * @Route("/start-battle", options={"expose"=true}, name="start-battle")
     * @Method("POST")
     * @return \Symfony\Component\HttpFoundation\Response
     * @param Request $request
     */
    public function startBattle(Request $request)
    {

        $lycansIds = $request->get('attackers');
        $castleId = $request->get('castleId');
        $opponentId = null;

        if (!empty($lycansIds) && $castleId) {

            $castle = $this->getDoctrine()->getRepository('AppBundle:Kingodms')->find($castleId);
            $castleAttack = $castle->getCastleAttack();
            $castleHealth = $castle->getCastleHealth();
            $castleBattleAttack = $castleAttack;
            $castleBattleHealth = $castleHealth;

            if ($castle->getOwnerId()) {


                $opponentId = $castle->getOwnerId();
                $opponent = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(['id'=>$castle->getOwnerId()]);
                $opponentNecklaces = $this->getDoctrine()->getRepository('AppBundle:UsersNecklaces')->findBy(['user' => $opponent]);

                //OPPONENT NECKLACE CASTLE BONUS
                foreach ($opponentNecklaces as $necklace) {

                    $type = $necklace->getNecklace()->getUpdater()->getType();

                    if ($type == 'Castle') {
                        $castleBattleHealth += $necklace->getNecklace()->getCastleHealthBonus();
                    }
                }

                //OPPONENT WAND CASTLE BONUS
                if ($opponent->getWand()) {
                    $opponentWand = $this->getDoctrine()->getRepository('AppBundle:User')->find($castle->getOwnerId());
                    $wandAttackBonus = $this->getDoctrine()->getRepository('AppBundle:MagicWands')->find($opponent->getWand());
                    $castleBattleAttack += $wandAttackBonus->getCastleAttackBonus() ;
                }

                //OPPONENT LYCAN CASTLE BONUS
                $castleLycans = $this->getDoctrine()->getRepository('AppBundle:Lycans')->findBy(['castleId'=> $castleId]);

                foreach ($castleLycans as $castleLycan) {

                    $castleBattleAttack += $castleLycan->getAttack();
                    $castleBattleHealth += $castleLycan->getHealth();
                }
            }

            $em = $this->getDoctrine()->getManager();
            $user = $this->get('security.token_storage')->getToken()->getUser();

            $battle = new Battle();
            $battle->setUser($user);
            $battle->setOpponentId($opponentId);
            $battle->setCastle($castle);

            $x1 = $user->GetX();
            $y1 = $user->GetY();
            $x2 = $castle->getX();
            $y2 = $castle->getY();

            $realDistance = sqrt(pow($x2 - $x1, 2) + pow($y2 - $y1, 2));
            $timeDistance = intval((($realDistance / 100) / 2) * 60);



            $dateNow = new \DateTime();

            //CALCULATE TRAVEL TIME
            $seconds = "+" . $timeDistance . ' seconds';
            $newTime = date('Y-m-d H:i:s', strtotime($seconds, strtotime($dateNow->format('Y-m-d H:i:s'))));
            $battle->setTimeToReachDestination(new \DateTime($newTime));


            //PREPARING TO FIGHT
            $randSeconds = rand(1, 2) * 60;
            $seconds = "+" . ($timeDistance + $randSeconds) . ' seconds';
            $statedTime = date('Y-m-d H:i:s', strtotime($seconds, strtotime($dateNow->format('Y-m-d H:i:s'))));
            $battle->setStartedDate(new \DateTime($statedTime));

            //FINISH FIGHT
            $randSeconds = $randSeconds + rand(1, 3) * 60;
            $seconds = "+" . ($timeDistance + $randSeconds) . ' seconds';
            $endTime = date('Y-m-d H:i:s', strtotime($seconds, strtotime($dateNow->format('Y-m-d H:i:s'))));
            $battle->setFinishedDate(new \DateTime($endTime));

            //TIME TO BACK
            $seconds = "+" . ($timeDistance + $randSeconds + $timeDistance) . ' seconds';
            $timeToBack = date('Y-m-d H:i:s', strtotime($seconds, strtotime($dateNow->format('Y-m-d H:i:s'))));
            $battle->setTimeToBack(new \DateTime($timeToBack));

            $em->persist($battle);
            $em->flush();

            $bonusNecklaces = $this->getDoctrine()->getRepository('AppBundle:UsersNecklaces')->getBonusNecklaces($user, $em);

            $lycanAttackDefaultBonus = 0;
            $lycanHealthDefaultBonus = 0;

            foreach ($bonusNecklaces as $bonusNecklace) {

                $lycanAttackDefaultBonus += $bonusNecklace->GetNecklace()->getLycanAttackBonus();
                $lycanHealthDefaultBonus += $bonusNecklace->GetNecklace()->getLycanHealthBonus();
            }

            $allAttackerLycans = [];


            foreach ($lycansIds as $lycansId) {

                $currentLycan = $this->getDoctrine()->getRepository('AppBundle:Lycans')->findOneBy(['id' => $lycansId]);

                $currentLycan->setAttack($currentLycan->getAttack() + $lycanAttackDefaultBonus);
                $currentLycan->setHealth($currentLycan->getHealth() + $lycanHealthDefaultBonus);

                $lycanAttack = new LycansAttack();
                $lycanAttack->setLycan($currentLycan);
                $lycanAttack->setBattle($battle);
                $em->persist($lycanAttack);

                $allAttackerLycans[] = $currentLycan;
            }

            $this->proceedBattle($allAttackerLycans, $user, $castleId, $castleBattleAttack, $castleBattleHealth, $battle, $castle->getCastleName());

            return $this->redirectToRoute('battle-reports');

        } else {
            return $this->redirectToRoute('attack_lycans', ['error' => 'Please choose lycans and kingdom']);
        }
    }

    private function proceedBattle($allAttackerLycansInput, $user, $castleId, $castleBattleAttack, $castleBattleHealth, $battle, $castleName)
    {
        $numberOfLycans = count($allAttackerLycansInput);

        $deadLycans =[];
        $allAttackerLycans = array_merge(array(), $allAttackerLycansInput);;
        $round = 0;
        $em = $this->getDoctrine()->getManager();


        while ($numberOfLycans > 0 && $castleBattleHealth > 0) {
            $round++;
            $randLycanIndex = rand(0, $numberOfLycans - 1);
            $currentLycan = $allAttackerLycans[$randLycanIndex];

            $currentLycanAttack = $currentLycan->getAttack();

            $battleReport = new BattleReports();
            $battleReport->setBattle($battle);
            $battleReport->setBattleTime(new \DateTime());

            if ($round % 2 != 0) {

                $chance = rand(0, 99);
                $battleReport->setIsLycan(1);

                if ($chance <= 70) {
                    $castleBattleHealth -= $currentLycanAttack;
                    $battleReport->setEntityId($currentLycan->getId());
                    $battleReport->setEntityName($currentLycan->getName());
                    $battleReport->setLosedDamage(0);
                    $battleReport->setMakedDamage($currentLycanAttack);

                    $em->persist($battleReport);
                    $em->flush();
                    var_dump('Lycan Attack CASTLE - castle health- '. $castleBattleHealth.' lycan health - ' );

                    if ($castleBattleHealth <= 0) {

                        $battleReport = new BattleReports();
                        $battleReport->setBattle($battle);
                        $battleReport->setBattleTime(new \DateTime());
                        $battleReport->setIsLycan(1);


                        $battleReport->setEntityId($currentLycan->getId());
                        $battleReport->setEntityName($currentLycan->getName());
                        $battleReport->setLosedDamage(0);
                        $battleReport->setMakedDamage(-100);


                        var_dump('Lycan Kill CASTLE - castle health- '. $castleBattleHealth);
                        $em->persist($battleReport);
                        $em->flush();
                        break;
                    }
                    //ADD ROW FOR ATTACKER LYCAN
                } else {

                    $battleReport->setEntityId($currentLycan->getId());
                    $battleReport->setEntityName($currentLycan->getName());
                    $battleReport->setLosedDamage(0);
                    $battleReport->setMakedDamage(0);
                    $em->persist($battleReport);
                    $em->flush();
                    //OPPONENT IS ESCAPE FROM YOUR ATTACK 0 0
                }

            } else {
                $chance = rand(0, 99);
                $battleReport->setIsLycan(0);

                if ($chance <= 70) {

                    $currentLycan->setHealth($currentLycan->getHealth() - $castleBattleAttack);
                    $battleReport->setEntityId($castleId);
                    $battleReport->setEntityName($castleName);
                    $battleReport->setLosedDamage(0);
                    $battleReport->setMakedDamage($castleBattleAttack);
                    $em->persist($battleReport);
                    $em->flush();

                    if ($currentLycan->getHealth() <= 0) {

                        $numberOfLycans--;
                        $deadLycan = $allAttackerLycans[$randLycanIndex];
                        unset($allAttackerLycans[$randLycanIndex]);
                        $deadLycans[] = $deadLycan;

                        $allAttackerLycans = array_values($allAttackerLycans);

                        $battleReport = new BattleReports();
                        $battleReport->setBattle($battle);
                        $battleReport->setBattleTime(new \DateTime());
                        $battleReport->setIsLycan(0);

                        $battleReport->setEntityId($castleId);
                        $battleReport->setEntityName($castleName);
                        $battleReport->setLosedDamage(0);
                        $battleReport->setMakedDamage(-100);

                        var_dump('CASTLE  kill lycan - castle health- '. $castleBattleHealth);
                        var_dump('Lycan  health- '. $currentLycan->getHealth());

//                        $em->remove($currentLycan);
                        $em->persist($battleReport);
                        $em->flush();
                    }
                    //ADD ROW FOR DEFENCER CASTLE

                } else {

                    $battleReport->setEntityId($castleId);
                    $battleReport->setEntityName($castleName);
                    $battleReport->setLosedDamage(0);
                    $battleReport->setMakedDamage(0);
                    $em->persist($battleReport);
                    $em->flush();
                    //LYCAN IS ESCAPE FROM YOUR ATTACK 0 0
                }
            }
        }


        $attackedCastle = $this->getDoctrine()->getRepository('AppBundle:Kingodms')->find($castleId);

        foreach ($allAttackerLycansInput as $lycanEntity){
            $entity = $this->getDoctrine()->getRepository('AppBundle:LycansAttack')->findOneBy(['lycan'=>$lycanEntity]);
            $em->remove($entity);
        }
        $em->flush();

        if ($castleBattleHealth > 0) {

           foreach ($allAttackerLycansInput as $deadLycan){
               $em->remove($deadLycan);
           }

            $attackedCastle->setCastleHealth($castleBattleHealth);
            $battle->setWinner(1);
            $em->flush();

        }else{

            foreach ($deadLycans as $deadLycan){

                if($deadLycan->getHealth() <= 0){
                     $em->remove($deadLycan);
                }
            }

            $attackedCastle->setOwnerId($user->getId());
            $attackedCastle->setCastleHealth(1000);
            $battle->setWinner(0);
            $em->flush();

            var_dump("LYCANS WIN");
            var_dump($castleBattleHealth);
            var_dump(count($numberOfLycans));


        }

    }
}