<?php

namespace Echo511\PSO;

/**
 * Class Swarm
 *
 * @category Library
 * @package  Echo511\PSO
 */
class Swarm
{

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
     * @var int
     */
    private $numberOfParticles = 100;

    /**
     * @var null|int
     */
    private $numberOfIterations = null;

    /**
     * @var callable
     */
    private $generateParticleCoordinatesCallback;

    /**
     * @var callable
     */
    private $generateParticleVelocityCallback;

    /**
     * @var Coordinates
     */
    private $bestCoordinates;

    /**
     * @var float
     */
    private $bestValue;

    /**
     * Swarm constructor.
     *
     * @param $function
     * @param $optimizer
     * @param $c1
     * @param $c2
     * @param $c3
     * @param int                                 $numberOfParticles
     * @param null                                $numberOfIterations
     * @param $generateParticleCoordinatesCallback
     * @param $generateParticleVelocityCallback
     */
    public function __construct(
        $function,
        $optimizer,
        $c1,
        $c2,
        $c3,
        $numberOfParticles,
        $numberOfIterations,
        $generateParticleCoordinatesCallback,
        $generateParticleVelocityCallback
    ) {

        $this->function = $function;
        $this->optimizer = $optimizer;
        $this->c1 = $c1;
        $this->c2 = $c2;
        $this->c3 = $c3;
        $this->numberOfParticles = $numberOfParticles;
        $this->numberOfIterations = $numberOfIterations;
        $this->generateParticleCoordinatesCallback = $generateParticleCoordinatesCallback;
        $this->generateParticleVelocityCallback = $generateParticleVelocityCallback;
    }

    /**
     * Run.
     */
    public function run()
    {
        $particles = $this->createParticles();

        $this->bestCoordinates = $coordinates = $particles[0]->getCoordinates();
        $this->bestValue = call_user_func_array($this->function, [$coordinates]);

        $n = 1;
        while ($n <= $this->numberOfIterations) {
            foreach ($particles as $particle) {
                $particle->move();
            }
            $n += 1;
        }
    }

    /**
     * @return Coordinates
     */
    public function getBestCoordinates()
    {
        return $this->bestCoordinates;
    }

    /**
     * @return float|int
     */
    public function getBestValue()
    {
        return $this->bestValue;
    }

    /**
     * Particle reports new value.
     *
     * @internal
     * @param    Coordinates $coordinates
     * @param    $value
     */
    public function reportValue(Coordinates $coordinates, $value)
    {
        if (call_user_func_array($this->optimizer, [$value, $this->bestValue])) {
            $this->bestValue = $value;
            $this->bestCoordinates = $coordinates;
        }
    }

    /**
     * @return Particle[]
     */
    private function createParticles()
    {
        $particles = [];
        $n = 1;
        while ($n <= $this->numberOfParticles) {
            $coordinates = call_user_func($this->generateParticleCoordinatesCallback);
            $velocity = call_user_func($this->generateParticleVelocityCallback);
            $particles[] = new Particle(
                $this,
                $this->function,
                $this->optimizer,
                $this->c1,
                $this->c2,
                $this->c3,
                $coordinates,
                $velocity
            );
            $n += 1;
        }
        return $particles;
    }
}
