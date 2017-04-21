<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsersNecklaces
 *
 * @ORM\Table(name="users_necklaces", indexes={@ORM\Index(name="FK_users_necklaces_user", columns={"user_id"}), @ORM\Index(name="FK_users_necklaces_necklaces", columns={"necklace_id"})})
 * @ORM\Entity
 */
class UsersNecklaces
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
     * @ORM\Column(name="level", type="integer", nullable=true)
     */
    private $level = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time_to_update", type="datetime", nullable=true)
     */
    private $timeToUpdate;

    /**
     * @var \Necklaces
     *
     * @ORM\ManyToOne(targetEntity="Necklaces")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="necklace_id", referencedColumnName="id")
     * })
     */
    private $necklace;

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
     * @var integer
     * @ORM\Column(name="castle_id", type="integer", nullable=true)
     */
    private $castle_id;

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
     * @return \Necklaces
     */
    public function getNecklace()
    {
        return $this->necklace;
    }

    /**
     * @param \Necklaces $necklace
     */
    public function setNecklace($necklace)
    {
        $this->necklace = $necklace;
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

    /**
     * @return mixed
     */
    public function getCastleId()
    {
        return $this->castle_id;
    }

    /**
     * @param mixed $castle_id
     */
    public function setCastleId($castle_id)
    {
        $this->castle_id = $castle_id;
    }

}

