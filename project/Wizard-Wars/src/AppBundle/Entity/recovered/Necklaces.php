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
     * @ORM\Column(name="health_bonus", type="integer", nullable=false)
     */
    private $healthBonus;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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




}

