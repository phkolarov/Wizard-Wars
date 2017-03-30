<?php

namespace DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Necklaces
 *
 * @ORM\Table(name="necklaces")
 * @ORM\Entity
 */
class Necklaces
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="attack_bonus", type="integer", nullable=false)
     */
    private $attackBonus = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="health_bonus", type="integer", nullable=false)
     */
    private $healthBonus = '0';


}

