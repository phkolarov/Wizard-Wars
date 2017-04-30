<?php
/**
 * Created by PhpStorm.
 * User: mst
 * Date: 29.4.2017 г.
 * Time: 21:37
 */

namespace AppBundle\Controller;


use AppBundle\Form\TeleportType;
use AppBundle\Form\types\Teleport;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class TeleportController extends Controller
{

    /**
     * @Security("is_authenticated()")
     * @Route("/teleport",options={"expose"=true}, name="teleport")
     */
    public function TeleportViewAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $teleport = new Teleport();
        $teleport->setPositionX($user->getX());
        $teleport->setPositionY($user->getY());
        $form = $this->createForm(TeleportType::class, $teleport);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em= $this->getDoctrine()->getManager();
            $formData = $form->getData();

            $user->setX($formData->getPositionX());
            $user->setY($formData->getPositionY());
            $user->setMana($user->getMana() - $formData->getManaCost());
            $em->flush();
            return $this->redirectToRoute('teleport',['success'=>'Successful teleportation']);
        }


        return $this->render('pages/teleport.html.twig', ['form' => $form->createView()]);
    }

}