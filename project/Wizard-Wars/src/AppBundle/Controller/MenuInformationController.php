<?php
/**
 * Created by PhpStorm.
 * User: mst
 * Date: 21.4.2017 г.
 * Time: 22:13
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MenuInformationController extends Controller
{
    /**
     * @Security("is_authenticated()")
     * @Route("/userBarInfo", name="userBarInfo")
     */
    public function loadXPAction()
    {

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        //LEVEL FORMULA
        $roundedXPlevel = sprintf('%0.2f', ((sqrt(625 + 100 * $user->getXP()) - 25) / 50));
        $levelPercent = explode('.', $roundedXPlevel);
        $percentToNewLevel = $levelPercent[1];
        $level = $user->getLevel();

        $mana = $user->getMana();
        $percentMana = 100;

        if ($user->getMana() <= 100) {

            $percentMana = $user->getMana();
        }

        if ($level <= $levelPercent[0]) {
            $user->setLevel(intval($levelPercent[0]) + 1);
            $em->flush();
            $level = $levelPercent[0] + 1;
        }


        //MAX   IMUM HEALTH PER LEVEL FORMULA
        $percentHealth = ($user->getHealth() / ($user->getRace()->getHealth() * $user->getLevel()) * 100);
        if ($percentHealth > 100) {
            $percentHealth = 100;
        }

        return $this->render('partials/user-information.html.twig', [
            'xp' => $user->getXP(),
            'percentToNewLevel' => $percentToNewLevel,
            'mana' => $mana,
            'level' => $level,
            'percentHealth' => $percentHealth,
            'health' => $user->getHealth(),
            'percentMana' => $percentMana,
            'gold' => $user->getGold()
        ]);
    }

}