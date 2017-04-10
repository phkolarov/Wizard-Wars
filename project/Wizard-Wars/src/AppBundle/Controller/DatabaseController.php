<?php
/**
 * Created by PhpStorm.
 * User: mst
 * Date: 10.4.2017 г.
 * Time: 21:34
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Kingodms;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class DatabaseController extends Controller
{


    /**
     * @Route("/createKingdoms", name="createKingdoms")
     * @Method("GET")
     */
    public function seedKingomsToDatabase()
    {

        ini_set('max_execution_time', 300);

        $castleArr = [];
        $x = 9000;
        $y = 8600;

        $tempX = 0;
        $tempY = 150;

        $step = 180;
        $percentOfBuild = 30;

        while ($tempY <= $y) {

            for ($i = 0; $i <= $x; $i += $step) {

                $tempX = $i;
                $randNum = (rand(0, 100) );

                if ($randNum < $percentOfBuild) {


                    $kingDom = new Kingodms();

                    $kingDom->setX($tempX);
                    $kingDom->setY($tempY);
                    $kingDom->setCasleName("CASTLE-" . uniqid());

                    $em = $this->getDoctrine()->getManager();

                    $em->persist($kingDom);
                    $em->flush();

//                    castleArr.push({x: tempX, y: tempY, king: "Pinko", attack: 100, health: 40})
                }
            }
            $tempY += $step;
        }


        return new Response("asd");

    }
}