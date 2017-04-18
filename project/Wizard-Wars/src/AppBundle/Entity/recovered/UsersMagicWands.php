<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsersMagicWands
 *
 * @ORM\Table(name="users_magic_wands")
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
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="magic_stick_id", type="integer", nullable=false)
     */
    private $magicStickId = '0';

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
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getMagicStickId()
    {
        return $this->magicStickId;
    }

    /**
     * @param int $magicStickId
     */
    public function setMagicStickId($magicStickId)
    {
        $this->magicStickId = $magicStickId;
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



}

