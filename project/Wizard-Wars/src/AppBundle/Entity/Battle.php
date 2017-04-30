<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Battle
 *
 * @ORM\Table(name="battle", indexes={@ORM\Index(name="FK_battle_user", columns={"user_id"}), @ORM\Index(name="FK_battle_kingodms", columns={"castle_id"})})
 * @ORM\Entity
 */
class Battle
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
     * @ORM\Column(name="opponent_id", type="integer", nullable=true)
     */
    private $opponentId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time_to_reach_destination", type="datetime", nullable=true)
     */
    private $timeToReachDestination = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time_to_back", type="datetime", nullable=true)
     */
    private $timeToBack;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="started_date", type="datetime", nullable=true)
     */
    private $startedDate = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="finished_date", type="datetime", nullable=true)
     */
    private $finishedDate;

    /**
     * @var \Kingodms
     *
     * @ORM\ManyToOne(targetEntity="Kingodms")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="castle_id", referencedColumnName="id")
     * })
     */
    private $castle;

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
     *
     * @ORM\Column(name="winner", type="integer", nullable=false)
     */
    private $winner = 0;

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
    public function getOpponentId()
    {
        return $this->opponentId;
    }

    /**
     * @param int $opponentId
     */
    public function setOpponentId($opponentId)
    {
        $this->opponentId = $opponentId;
    }

    /**
     * @return \DateTime
     */
    public function getTimeToReachDestination()
    {
        return $this->timeToReachDestination;
    }

    /**
     * @param \DateTime $timeToReachDestination
     */
    public function setTimeToReachDestination($timeToReachDestination)
    {
        $this->timeToReachDestination = $timeToReachDestination;
    }

    /**
     * @return \DateTime
     */
    public function getTimeToBack()
    {
        return $this->timeToBack;
    }

    /**
     * @param \DateTime $timeToBack
     */
    public function setTimeToBack($timeToBack)
    {
        $this->timeToBack = $timeToBack;
    }

    /**
     * @return \DateTime
     */
    public function getStartedDate()
    {
        return $this->startedDate;
    }

    /**
     * @param \DateTime $startedDate
     */
    public function setStartedDate($startedDate)
    {
        $this->startedDate = $startedDate;
    }

    /**
     * @return \DateTime
     */
    public function getFinishedDate()
    {
        return $this->finishedDate;
    }

    /**
     * @param \DateTime $finishedDate
     */
    public function setFinishedDate($finishedDate)
    {
        $this->finishedDate = $finishedDate;
    }

    /**
     * @return \Kingodms
     */
    public function getCastle()
    {
        return $this->castle;
    }

    /**
     * @param \Kingodms $castle
     */
    public function setCastle($castle)
    {
        $this->castle = $castle;
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
     * @return int
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * @param int $winner
     */
    public function setWinner($winner)
    {
        $this->winner = $winner;
    }



}

