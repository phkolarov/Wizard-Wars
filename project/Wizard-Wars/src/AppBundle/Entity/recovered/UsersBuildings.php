<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsersBuildings
 *
 * @ORM\Table(name="users_buildings", indexes={@ORM\Index(name="FK_users_buildings_user", columns={"user_id"}), @ORM\Index(name="FK_users_buildings_buildings", columns={"building_id"})})
 * @ORM\Entity
 */
class UsersBuildings
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
    private $level;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time_to_build", type="datetime", nullable=true)
     */
    private $timeToBuild;

    /**
     * @var \Buildings
     *
     * @ORM\ManyToOne(targetEntity="Buildings")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="building_id", referencedColumnName="id")
     * })
     */
    private $building;

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
     * @ORM\Column(name="is_builded", type="integer", nullable=true)
     */
    private $isBuilded = '0';


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
    public function getTimeToBuild()
    {
        return $this->timeToBuild;
    }

    /**
     * @param \DateTime $timeToBuild
     */
    public function setTimeToBuild($timeToBuild)
    {
        $this->timeToBuild = $timeToBuild;
    }

    /**
     * @return \Buildings
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * @param \Buildings $building
     */
    public function setBuilding($building)
    {
        $this->building = $building;
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
    public function getIsBuilded()
    {
        return $this->isBuilded;
    }

    /**
     * @param int $isBuilded
     */
    public function setIsBuilded($isBuilded)
    {
        $this->isBuilded = $isBuilded;
    }



}

