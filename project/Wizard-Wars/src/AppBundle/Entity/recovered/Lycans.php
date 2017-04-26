<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lycans
 *
 * @ORM\Table(name="lycans", indexes={@ORM\Index(name="FK_dogs_user", columns={"user_id"})})
 * @ORM\Entity
 */
class Lycans
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
     * @ORM\Column(name="attack", type="integer", nullable=true)
     */
    private $attack = '50';

    /**
     * @var integer
     *
     * @ORM\Column(name="health", type="integer", nullable=true)
     */
    private $health = '60';

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer", nullable=true)
     */
    private $level = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="castle_id", type="integer", nullable=true)
     */
    private $castleId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time_to_update", type="datetime", nullable=true)
     */
    private $timeToUpdate;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

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
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return int
     */
    public function getCastleId()
    {
        return $this->castleId;
    }

    /**
     * @param int $castleId
     */
    public function setCastleId($castleId)
    {
        $this->castleId = $castleId;
    }

    /**
     * @return \DateTime
     */
    public function getTimeToUpdate()
    {
        return $this->timeToUpdate;
    }

    /**
     * @param \DateTime $timeToUpdate
     */
    public function setTimeToUpdate($timeToUpdate)
    {
        $this->timeToUpdate = $timeToUpdate;
    }

    /**
     * @return \User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }



}

