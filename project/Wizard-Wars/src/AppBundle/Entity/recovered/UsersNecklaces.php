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


}

