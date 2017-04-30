<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BattleReports
 *
 * @ORM\Table(name="battle_reports", indexes={@ORM\Index(name="FK_battle_reports_battle", columns={"battle_id"})})
 * @ORM\Entity
 */
class BattleReports
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
     * @ORM\Column(name="entity_name", type="string", nullable=false)
     */
    private $entityName;

    /**
     * @var integer
     *
     * @ORM\Column(name="entity_id", type="integer", nullable=false)
     */
    private $entityId;

    /**
     * @var integer
     *
     * @ORM\Column(name="maked_damage", type="integer", nullable=false)
     */
    private $makedDamage = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="losed_damage", type="integer", nullable=false)
     */
    private $losedDamage = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="battle_time", type="datetime", nullable=false)
     */
    private $battleTime = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     *
     * @ORM\Column(name="is_lycan", type="integer", nullable=false)
     */
    private $isLycan = '1';

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
    public function getEntityName()
    {
        return $this->entityName;
    }

    /**
     * @param int $entityName
     */
    public function setEntityName($entityName)
    {
        $this->entityName = $entityName;
    }

    /**
     * @return int
     */
    public function getEntityId()
    {
        return $this->entityId;
    }

    /**
     * @param int $entityId
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;
    }

    /**
     * @return int
     */
    public function getMakedDamage()
    {
        return $this->makedDamage;
    }

    /**
     * @param int $makedDamage
     */
    public function setMakedDamage($makedDamage)
    {
        $this->makedDamage = $makedDamage;
    }

    /**
     * @return int
     */
    public function getLosedDamage()
    {
        return $this->losedDamage;
    }

    /**
     * @param int $losedDamage
     */
    public function setLosedDamage($losedDamage)
    {
        $this->losedDamage = $losedDamage;
    }

    /**
     * @return \DateTime
     */
    public function getBattleTime()
    {
        return $this->battleTime;
    }

    /**
     * @param \DateTime $battleTime
     */
    public function setBattleTime($battleTime)
    {
        $this->battleTime = $battleTime;
    }

    /**
     * @return int
     */
    public function getIsLycan()
    {
        return $this->isLycan;
    }

    /**
     * @param int $isLycan
     */
    public function setIsLycan($isLycan)
    {
        $this->isLycan = $isLycan;
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
}

