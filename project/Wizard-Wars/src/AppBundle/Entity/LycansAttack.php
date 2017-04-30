<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LycansAttack
 *
 * @ORM\Table(name="lycans_attack", indexes={@ORM\Index(name="FK_lycans_attack_battle", columns={"battle_id"}), @ORM\Index(name="FK_lycans_attack_lycans", columns={"lycan_id"})})
 * @ORM\Entity
 */
class LycansAttack
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
     * @var \Battle
     *
     * @ORM\ManyToOne(targetEntity="Battle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="battle_id", referencedColumnName="id")
     * })
     */
    private $battle;

    /**
     * @var \Lycans
     *
     * @ORM\ManyToOne(targetEntity="Lycans")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="lycan_id", referencedColumnName="id")
     * })
     */
    private $lycan;

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
     * @return \Battle
     */
    public function getBattle()
    {
        return $this->battle;
    }

    /**
     * @param \Battle $battle
     */
    public function setBattle($battle)
    {
        $this->battle = $battle;
    }

    /**
     * @return \Lycans
     */
    public function getLycan()
    {
        return $this->lycan;
    }

    /**
     * @param \Lycans $lycan
     */
    public function setLycan($lycan)
    {
        $this->lycan = $lycan;
    }
}

