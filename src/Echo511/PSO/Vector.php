<?php

namespace Echo511\PSO;

/**
 * Class Vector
 *
 * @category Library
 * @package  Echo511\PSO
 */
class Vector
{

    /**
     * @var Coordinates
     */
    private $coordinates;

    /**
     * Vector constructor.
     *
     * @param Coordinates $coordinates
     */
    public function __construct(Coordinates $coordinates)
    {
        $this->coordinates = $coordinates;
    }

    /**
     * @return Coordinates
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * @return array
     */
    public function getCoordinatesArray()
    {
        return $this->coordinates->getCoordinates();
    }

    /**
     * @param $axe
     * @return mixed
     */
    public function getCoordinateAxeValue($axe)
    {
        return $this->coordinates->getAxeValue($axe);
    }

    /**
     * @param Vector $vector
     * @return Vector
     */
    public function plus(Vector $vector)
    {
        $coordinates = $this->manipulate($this, $vector, '+');
        return new Vector($coordinates);
    }

    /**
     * @param Vector $vector
     * @return Vector
     */
    public function minus(Vector $vector)
    {
        $coordinates = $this->manipulate($this, $vector, '-');
        return new Vector($coordinates);
    }

    /**
     * @param $int
     * @return Vector
     */
    public function multiply($int)
    {
        $coordinates = [];
        foreach ($this->getCoordinatesArray() as $axe => $value) {
            $newValue = $value * $int;
            $coordinates[$axe] = $newValue;
        }
        $coordinates = new Coordinates($coordinates);
        return new Vector($coordinates);
    }

    /**
     * @param Vector $self
     * @param Vector $vector
     * @param string $operator
     * @return Coordinates
     */
    private function manipulate(Vector $self, Vector $vector, $operator = '+')
    {
        if (count($self->getCoordinatesArray()) != count($vector->getCoordinatesArray())) {
            throw new \RuntimeException("Axis count does not match.");
        }

        $coordinates = [];
        foreach ($self->getCoordinatesArray() as $axe => $value) {
            $newValue = $value;
            switch ($operator) {
            case '+':
                $newValue = $value + $vector->getCoordinateAxeValue($axe);
                break;
            case '-':
                $newValue = $value - $vector->getCoordinateAxeValue($axe);
                break;
            }
            $coordinates[$axe] = $newValue;
        }


        return new Coordinates($coordinates);
    }
}
