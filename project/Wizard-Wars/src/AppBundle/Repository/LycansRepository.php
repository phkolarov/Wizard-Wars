<?php
/**
 * Created by PhpStorm.
 * User: mst
 * Date: 26.4.2017 г.
 * Time: 11:22
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class LycansRepository extends EntityRepository
{

    public function getUserFreeLycans($user, $em)
    {

        $query = $em->createQuery('SELECT l FROM AppBundle:Lycans l WHERE l.castleId IS NULL AND l.user = :userId');
        $query->setParameters(array(
            'userId' => $user->getId(),
        ));

        $lycans = $query->getResult();

        $freeLycans = [];

        foreach ($lycans as $lycan){

            $query = $em->createQuery('SELECT la FROM AppBundle:LycansAttack la WHERE la.lycan = :lycanId');
            $query->setParameters(array(
                'lycanId' => $lycan->getId(),
            ));

            $lycanResult = $query->getResult();

            if(empty($lycanResult)){
                $freeLycans[] = $lycan;
            }
        }

        return $freeLycans;
    }
}