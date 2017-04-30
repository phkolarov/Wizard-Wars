<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Buildings
 *
 * @ORM\Table(name="buildings")
 * @ORM\Entity
 */
class Buildings implements \JsonSerializable
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
     * @ORM\Column(name="buildingName", type="string", length=50, nullable=false)
     */
    private $buildingname = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     */
    private $type = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="positionX", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $positionx;

    /**
     * @var string
     *
     * @ORM\Column(name="positionY", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $positiony;

    /**
     * @var string
     *
     * @ORM\Column(name="sizeX", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $sizex;

    /**
     * @var string
     *
     * @ORM\Column(name="sizeY", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $sizey;

    /**
     * @var string
     *
     * @ORM\Column(name="buildingImage", type="string", length=50, nullable=true)
     */
    private $buildingimage;

    /**
     * @var string
     *
     * @ORM\Column(name="uri", type="string", length=50, nullable=false)
     */
    private $uri = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="default", type="integer", nullable=false)
     */
    private $default = '0';

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
     * @return string
     */
    public function getBuildingname()
    {
        return $this->buildingname;
    }

    /**
     * @param string $buildingname
     */
    public function setBuildingname($buildingname)
    {
        $this->buildingname = $buildingname;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getPositionx()
    {
        return $this->positionx;
    }

    /**
     * @param string $positionx
     */
    public function setPositionx($positionx)
    {
        $this->positionx = $positionx;
    }

    /**
     * @return string
     */
    public function getPositiony()
    {
        return $this->positiony;
    }

    /**
     * @param string $positiony
     */
    public function setPositiony($positiony)
    {
        $this->positiony = $positiony;
    }

    /**
     * @return string
     */
    public function getSizex()
    {
        return $this->sizex;
    }

    /**
     * @param string $sizex
     */
    public function setSizex($sizex)
    {
        $this->sizex = $sizex;
    }

    /**
     * @return string
     */
    public function getSizey()
    {
        return $this->sizey;
    }

    /**
     * @param string $sizey
     */
    public function setSizey($sizey)
    {
        $this->sizey = $sizey;
    }

    /**
     * @return string
     */
    public function getBuildingimage()
    {
        return $this->buildingimage;
    }

    /**
     * @param string $buildingimage
     */
    public function setBuildingimage($buildingimage)
    {
        $this->buildingimage = $buildingimage;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * @return int
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param int $default
     */
    public function setDefault($default)
    {
        $this->default = $default;
    }

    function jsonSerialize()
    {
        return
            [
                'buildingName' => $this->buildingname,
                'type' => $this->type,
                'positionX' => $this->positionx,
                'positionY' => $this->positiony,
                'sizeX' => $this->sizex,
                'sizeY' => $this->sizey,
                'buildingImage' => $this->buildingimage,
                'uri' => $this->uri,
                'default' => $this->default
            ];

    }

}

