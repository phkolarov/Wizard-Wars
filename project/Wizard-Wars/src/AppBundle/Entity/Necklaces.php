<?php

namespace AppBundle\Entity;

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
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="attack_bonus", type="integer", nullable=false)
     */
    private $attackBonus;

    /**
     * @var integer
     *
     * @ORM\Column(name="mana_bonus", type="integer", nullable=false)
     */
    private $manaBonus;

    /**
     * @var integer
     *
     * @ORM\Column(name="dogs_attack_bonus", type="integer", nullable=false)
     */
    private $dogsAttackBonus;

    /**
     * @var integer
     *
     * @ORM\Column(name="dogs_defense_bonus", type="integer", nullable=false)
     */
    private $dogsDefenseBonus;

    /**
     * @var integer
     *
     * @ORM\Column(name="health_bonus", type="integer", nullable=false)
     */
    private $healthBonus;

    /**
     * @var integer
     *
     * @ORM\Column(name="castle_health_bonus", type="integer", nullable=false)
     */
    private $castleHealthBonus;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=50, nullable=false)
     */
    private $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="updater", type="integer", nullable=false)
     */
    private $updater = '0';

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

    /**
     * @return int
     */
    public function getDogsAttackBonus()
    {
        return $this->dogsAttackBonus;
    }

    /**
     * @param int $dogsAttackBonus
     */
    public function setDogsAttackBonus($dogsAttackBonus)
    {
        $this->dogsAttackBonus = $dogsAttackBonus;
    }

    /**
     * @return int
     */
    public function getDogsDefenseBonus()
    {
        return $this->dogsDefenseBonus;
    }

    /**
     * @param int $dogsDefenseBonus
     */
    public function setDogsDefenseBonus($dogsDefenseBonus)
    {
        $this->dogsDefenseBonus = $dogsDefenseBonus;
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
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getUpdater()
    {
        return $this->updater;
    }

    /**
     * @param int $updater
     */
    public function setUpdater($updater)
    {
        $this->updater = $updater;
    }

}

