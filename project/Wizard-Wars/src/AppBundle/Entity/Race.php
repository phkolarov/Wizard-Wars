<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Race
 *
 * @ORM\Table(name="race")
 * @ORM\Entity
 */
class Race
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
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="attack", type="integer", nullable=false)
     */
    private $attack = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="health", type="integer", nullable=false)
     */
    private $health = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="castle_attack_bonus", type="integer", nullable=false)
     */
    private $castleAttackBonus = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="castle_health_bonus", type="integer", nullable=false)
     */
    private $castleHealthBonus = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="mana_bonus", type="integer", nullable=false)
     */
    private $manaBonus = '0';


}

