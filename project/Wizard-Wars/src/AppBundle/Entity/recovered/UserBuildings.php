<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserBuildings
 *
 * @ORM\Table(name="user_buildings", indexes={@ORM\Index(name="FK_user_buildings_user", columns={"user_id"}), @ORM\Index(name="FK_user_buildings_buildings", columns={"building_id"})})
 * @ORM\Entity
 */
class UserBuildings
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



}

