<?php

namespace Echo511\PSO;

/**
 * Class Coordinates
 *
 * @category Library
 * @package  Echo511\PSO
 */
class Coordinates
{

    /**
     * @var array
     */
    private $coordinates = [];

    public function __construct(array $coordinates)
    {
        $this->coordinates = $coordinates;
    }

    /**
     * @return array
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * @param $axe
     * @return mixed
     */
    public function getAxeValue($axe)
    {
        return $this->coordinates[$axe];
    }

    /**
     * @return array
     */
    public function getAxis()
    {
        return array_keys($this->coordinates);
    }

    /**
     * @param $axe
     * @param $value
     */
    public function setCoordinate($axe, $value)
    {
        if (!array_key_exists($axe, $this->coordinates)) {
            throw new \RuntimeException("Axe '$axe' does not exists among " . implode(', ', $this->getAxis()));
        }

        $this->coordinates[$axe] = $value;
    }
}
