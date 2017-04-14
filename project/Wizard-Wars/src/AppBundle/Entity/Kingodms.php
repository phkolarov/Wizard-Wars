<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Kingodms
 *
 * @ORM\Table(name="kingodms", indexes={@ORM\Index(name="FK_kingodms_user", columns={"owner_id"})})
 * @ORM\Entity
 */
class Kingodms implements \JsonSerializable
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
     * @ORM\Column(name="casle_name", type="string", nullable=false)
     */
    private $casleName;

    /**
     * @var integer
     *
     * @ORM\Column(name="castle_attack", type="integer", nullable=false)
     */
    private $castleAttack = '50';

    /**
     * @var integer
     *
     * @ORM\Column(name="castle_health", type="integer", nullable=false)
     */
    private $castleHealth = '1000';

    /**
     * @var integer
     *
     * @ORM\Column(name="x", type="integer", nullable=false)
     */
    private $x = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="y", type="integer", nullable=false)
     */
    private $y = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="owner_id", type="integer", nullable=true)
     */
    private $ownerId;


    private $kingName;



    /**
     * @return int
     */
    public function getCasleName()
    {
        return $this->casleName;
    }


    /**
     * @param int $casleName
     */
    public function setCasleName($casleName)
    {
        $this->casleName = $casleName;
    }

    /**
     * @return int
     */
    public function getCastleAttack()
    {
        return $this->castleAttack;
    }

    /**
     * @param int $castleAttack
     */
    public function setCastleAttack($castleAttack)
    {
        $this->castleAttack = $castleAttack;
    }

    /**
     * @return int
     */
    public function getCastleHealth()
    {
        return $this->castleHealth;
    }

    /**
     * @param int $castleHealth
     */
    public function setCastleHealth($castleHealth)
    {
        $this->castleHealth = $castleHealth;
    }

    /**
     * @return int
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @param int $x
     */
    public function setX($x)
    {
        $this->x = $x;
    }

    /**
     * @return int
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @param int $y
     */
    public function setY($y)
    {
        $this->y = $y;
    }

    /**
     * @return int
     */
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /**
     * @param int $ownerId
     */
    public function setOwnerId($ownerId)
    {
        $this->ownerId = $ownerId;
    }

    public function setKingName($name){

        $this->kingName = $name;
    }


    function jsonSerialize()
    {
        return
            [
                'id' => $this->id,
                'x' => $this->x,
                'y' => $this->y,
                'casleName' => $this->casleName,
                'castleAttack' => $this->castleAttack,
                'castleHealth' => $this->castleHealth,
                'ownerId'=> $this->ownerId,
                'kingName'=> $this->kingName
            ];
    }


}

