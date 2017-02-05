<?php

namespace Echo511\PSO;

/**
 * Class Particle
 *
 * @category Library
 * @package  Echo511\PSO
 */
class Particle
{

    /**
     * @var Swarm
     */
    private $swarm;

    /**
     * @var callable
     */
    private $function;

    /**
     * @var callable
     */
    private $optimizer;

    /**
     * @var float
     */
    private $c1;

    /**
     * @var float
     */
    private $c2;

    /**
     * @var float
     */
    private $c3;

    /**
     * @var Coordinates
     */
    private $coordinates;

    /**
     * @var float|int
     */
    private $value;

    /**
     * @var Vector
     */
    private $velocity;

    /**
     * @var Coordinates
     */
    private $bestCoordinates;

    /**
     * @var float
     */
    private $bestValue;

    /**
     * Particle constructor.
     *
     * @param Swarm       $swarm
     * @param callable    $function
     * @param callable    $optimizer   Should the new value be considered as the new best one?
     * @param float       $c1          To swarm best coefficient.
     * @param float       $c2          To particle best coefficient.
     * @param float       $c3          Current velocity coefficient.
     * @param Coordinates $coordinates
     * @param Vector      $velocity
     */
    public function __construct(
        Swarm $swarm,
        callable $function,
        callable $optimizer,
        $c1,
        $c2,
        $c3,
        Coordinates $coordinates,
        Vector $velocity
    ) {

        $this->swarm = $swarm;
        $this->function = $function;
        $this->optimizer = $optimizer;
        $this->c1 = $c1;
        $this->c2 = $c2;
        $this->c3 = $c3;
        $this->bestCoordinates = $this->coordinates = $coordinates;
        $this->velocity = $velocity;
        $this->bestValue = $this->value = $function($coordinates);
    }

    /**
     * Move particle.
     */
    public function move()
    {
        $r1 = rand(0, 100) / 100;
        $r2 = rand(0, 100) / 100;
        $r3 = rand(0, 100) / 100;

        $toSwarmBest = Space::getVectorToMove($this->coordinates, $this->swarm->getBestCoordinates());
        $toParticleBest = Space::getVectorToMove($this->coordinates, $this->bestCoordinates);

        $newCoordinates = (new Vector($this->coordinates))
            ->plus($toSwarmBest->multiply($r1)->multiply($this->c1))
            ->plus($toParticleBest->multiply($r2)->multiply($this->c2))
            ->plus($this->velocity->multiply($r3)->multiply($this->c3))
            ->getCoordinates();

        $newVelocity = Space::getVectorToMove($this->coordinates, $newCoordinates);

        $newValue = call_user_func_array($this->function, [$newCoordinates]);

        if (call_user_func_array($this->optimizer, [$newValue, $this->bestValue])) {
            $this->bestValue = $newValue;
            $this->bestCoordinates = $newCoordinates;
        }

        $this->swarm->reportValue($newCoordinates, $newValue);
        $this->velocity = $newVelocity;
        $this->coordinates = $newCoordinates;
        $this->value = $newValue;
    }

    /**
     * @return Coordinates
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * @return float|int
     */
    public function getValue()
    {
        return $this->value;
    }
}
