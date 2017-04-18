<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsersMagicWands
 *
 * @ORM\Table(name="users_magic_wands", indexes={@ORM\Index(name="FK_users_magic_wands_user", columns={"user_id"}), @ORM\Index(name="FK_users_magic_wands_magic_wands", columns={"magic_wand_id"})})
 * @ORM\Entity
 */
class UsersMagicWands
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
     * @ORM\Column(name="level", type="integer", nullable=false)
     */
    private $level = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time_to_update", type="datetime", nullable=true)
     */
    private $timeToUpdate;

    /**
     * @var \MagicWands
     *
     * @ORM\ManyToOne(targetEntity="MagicWands")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="magic_wand_id", referencedColumnName="id")
     * })
     */
    private $magicWand;

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
     * @return \MagicWands
     */
    public function getMagicWand()
    {
        return $this->magicWand;
    }

    /**
     * @param \MagicWands $magicWand
     */
    public function setMagicWand($magicWand)
    {
        $this->magicWand = $magicWand;
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

