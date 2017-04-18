<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MagicWands
 *
 * @ORM\Table(name="magic_wands")
 * @ORM\Entity
 */
class MagicWands
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
     * @ORM\Column(name="name", type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="attack_bonus", type="integer", nullable=true)
     */
    private $attackBonus;

    /**
     * @var integer
     *
     * @ORM\Column(name="health_bonus", type="integer", nullable=true)
     */
    private $healthBonus;

    /**
     * @var integer
     *
     * @ORM\Column(name="castle_attack_bonus", type="integer", nullable=true)
     */
    private $castleAttackBonus;

    /**
     * @var integer
     *
     * @ORM\Column(name="image", type="integer", nullable=true)
     */
    private $image;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

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
    public function getAttackBonus()
    {
        return $this->attackBonus;
    }

    /**
     * @param int $attackBonus
     */
    public function setAttackBonus($attackBonus)
    {
        $this->attackBonus = $attackBonus;
    }

    /**
     * @return int
     */
    public function getHealthBonus()
    {
        return $this->healthBonus;
    }

    /**
     * @param int $healthBonus
     */
    public function setHealthBonus($healthBonus)
    {
        $this->healthBonus = $healthBonus;
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
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param int $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }



}

