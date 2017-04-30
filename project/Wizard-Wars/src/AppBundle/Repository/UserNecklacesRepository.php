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

    //PROBLEM WITH MORE THAN TWO LEFT JOINS !!!
    public function getUpdaterNecklaces($user,$em){

        $qb = $em->createQueryBuilder();

        $queryQB = $qb->select('un')
            ->from('AppBundle:UsersNecklaces', 'un')
            ->leftJoin('AppBundle:Necklaces','n','WITH','un.necklace = n')
            ->leftJoin('AppBundle:NecklaceTypes','nt','WITH','n.updater = nt')
            ->where('nt.type = :neckType')
            ->andWhere('un.user = :user')
            ->setParameter('neckType','Updater')
            ->setParameter('user',$user)
        ;


        return $queryQB->getQuery()->getResult();
    }

    public function getNormalNecklaces($user,$em){


        $qb = $em->createQueryBuilder();

        $queryQB = $qb->select('un')
            ->from('AppBundle:UsersNecklaces', 'un')
            ->leftJoin('AppBundle:Necklaces','n','WITH','un.necklace = n')
            ->leftJoin('AppBundle:NecklaceTypes','nt','WITH','n.updater = nt')
            ->where('nt.type != :neckType')
            ->andWhere('un.user = :user')
            ->setParameter('neckType','Updater')
            ->setParameter('user',$user)
        ;


        return $queryQB->getQuery()->getResult();
    }

    public function getBonusNecklaces($user,$em){


        $qb = $em->createQueryBuilder();

        $queryQB = $qb->select('un')
            ->from('AppBundle:UsersNecklaces', 'un')
            ->leftJoin('AppBundle:Necklaces','n','WITH','un.necklace = n')
            ->leftJoin('AppBundle:NecklaceTypes','nt','WITH','n.updater = nt')
            ->where('nt.type != :neckType')
            ->andWhere('un.user = :user')
            ->setParameter('neckType','User')
            ->setParameter('user',$user)
        ;


        return $queryQB->getQuery()->getResult();
    }
}