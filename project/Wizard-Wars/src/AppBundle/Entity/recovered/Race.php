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

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getAttack()
    {
        return $this->attack;
    }

    /**
     * @param int $attack
     */
    public function setAttack($attack)
    {
        $this->attack = $attack;
    }

    /**
     * @return int
     */
    public function getHealth()
    {
        return $this->health;
    }

    /**
     * @param int $health
     */
    public function setHealth($health)
    {
        $this->health = $health;
    }

    /**
     * @return int
     */
    public function getCastleAttackBonus()
    {
        return $this->castleAttackBonus;
    }

    /**
     * @param int $castleAttackBonus
     */
    public function setCastleAttackBonus($castleAttackBonus)
    {
        $this->castleAttackBonus = $castleAttackBonus;
    }

    /**
     * @return int
     */
    public function getCastleHealthBonus()
    {
        return $this->castleHealthBonus;
    }

    /**
     * @param int $castleHealthBonus
     */
    public function setCastleHealthBonus($castleHealthBonus)
    {
        $this->castleHealthBonus = $castleHealthBonus;
    }

    /**
     * @return int
     */
    public function getManaBonus()
    {
        return $this->manaBonus;
    }

    /**
     * @param int $manaBonus
     */
    public function setManaBonus($manaBonus)
    {
        $this->manaBonus = $manaBonus;
    }



}

