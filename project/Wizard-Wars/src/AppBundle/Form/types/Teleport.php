<?php
/**
 * Created by PhpStorm.
 * User: mst
 * Date: 29.4.2017 г.
 * Time: 22:21
 */

namespace AppBundle\Form\types;


class Teleport
{


    private $positionX;
    private $positionY;
    private $manaCost;


    public function __construct()
    {
    }


    /**
     * @return mixed
     */
    public function getPositionX()
    {
        return $this->positionX;
    }

    /**
     * @param mixed $positionX
     */
    public function setPositionX($positionX)
    {
        $this->positionX = $positionX;
    }

    /**
     * @return mixed
     */
    public function getPositionY()
    {
        return $this->positionY;
    }

    /**
     * @param mixed $positionY
     */
    public function setPositionY($positionY)
    {
        $this->positionY = $positionY;
    }

    /**
     * @return mixed
     */
    public function getManaCost()
    {
        return $this->manaCost;
    }

    /**
     * @param mixed $manaCost
     */
    public function setManaCost($manaCost)
    {
        $this->manaCost = $manaCost;
    }




}