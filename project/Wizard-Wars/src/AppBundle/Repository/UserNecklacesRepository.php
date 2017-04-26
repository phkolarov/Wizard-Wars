<?php
/**
 * Created by PhpStorm.
 * User: mst
 * Date: 26.4.2017 г.
 * Time: 11:25
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class UserNecklacesRepository extends EntityRepository
{

    public function getUpdaterNecklaces($user,$em){

        $necklaces = $em->createQuery('SELECT un FROM AppBundle:UsersNecklaces un LEFT JOIN AppBundle:Necklaces n WHERE un.necklace = n.id')->getResult();
        $necklacesUpdaters = [];

        foreach ($necklaces as $necklace) {

            if ($necklace->getNecklace()->getUpdater() == 1 && $user->getId() == $necklace->getUser()->getId()) {
                $necklacesUpdaters[] = $necklace;
            }
        }

        return $necklacesUpdaters;
    }


    public function getNormalNecklaces($user,$em){

        $necklaces = $em->createQuery('SELECT un FROM AppBundle:UsersNecklaces un LEFT JOIN AppBundle:Necklaces n WHERE un.necklace = n.id')->getResult();
        $normalNecklaces = [];

        foreach ($necklaces as $necklace) {

            if ($necklace->getNecklace()->getUpdater() != 1&& $user->getId() == $necklace->getUser()->getId()) {
                $normalNecklaces[] = $necklace;
            }
        }
        return $normalNecklaces;
    }
}