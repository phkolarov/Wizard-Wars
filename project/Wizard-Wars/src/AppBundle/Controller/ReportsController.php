<?php
/**
 * Created by PhpStorm.
 * User: mst
 * Date: 28.4.2017 г.
 * Time: 20:00
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ReportsController extends Controller
{


    /**
     * @Security("is_authenticated()")
     * @Route("/battle-reports", name="battle-reports")
     */
    public function ReportViewAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $myAttacks = $this->getDoctrine()->getRepository('AppBundle:Battle')->findBy(['user' => $user]);
        $myBattles = $this->getDoctrine()->getRepository('AppBundle:Battle')->findBy(['opponentId' => $user->getId()]);


        return $this->render('pages/statistic.html.twig',
            [
                'battacks' => $myAttacks,
                'myBattles' => $myBattles
            ]);

    }


    /**
     * @Security("is_authenticated()")
     * @Method("GET")
     * @Route("/battle-stats/{id}", name="battle-stats")
     */
    public function BattleStats($id, Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $battle = $this->getDoctrine()->getRepository('AppBundle:Battle')->find($id);

        if($battle){
            $stats = $this->getDoctrine()->getRepository('AppBundle:BattleReports')->findBy(['battle'=> $battle]);

            return $this->render('pages/battle_stats.html.twig',['battleStatistic'=> $stats,'winnerCheck'=> $battle->getWinner(), '']);

        }else{
            return $this->redirectToRoute('battle-reports',['error'=> 'Battle not found']);
        }
    }


}