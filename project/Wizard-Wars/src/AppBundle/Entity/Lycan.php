<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lycan
 * @ORM\Table(name="lycan")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LycanRepository")
 */
class Lycan
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
     * @var integer
     *
     * @ORM\Column(name="attack", type="integer", nullable=true)
     */
    private $attack;

    /**
     * @var integer
     *
     * @ORM\Column(name="health", type="integer", nullable=true)
     */
    private $health;

    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="integer", nullable=false)
     */
    private $price = '0';


    /**
     * @var integer
     *
     * @ORM\Column(name="price_mana", type="integer", nullable=false)
     */
    private $priceMana = '0';

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
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getPriceMana()
    {
        return $this->priceMana;
    }

    /**
     * @param int $priceMana
     */
    public function setPriceMana($priceMana)
    {
        $this->priceMana = $priceMana;
    }


}

