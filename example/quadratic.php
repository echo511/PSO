<?php

require_once __DIR__ . '/../vendor/autoload.php';

$function = function (\Echo511\PSO\Coordinates $coordinates) {
    $x = $coordinates->getAxeValue(0);
    return ($x - 3) ** 2 + 5;
};

$optimizer = function ($value, $bestValue) {
    return $value < $bestValue;
};

$c1 = 0.3;
$c2 = 0.3;
$c3 = 0.3;

$numberOfParticles = 50;
$numberOfIterations = 50;

$generateParticleCoordinatesCallback = function () {
    return new \Echo511\PSO\Coordinates([rand(-50, 50)]);
};

$generateParticleVelocityCallback = function () {
    $coordinates = new \Echo511\PSO\Coordinates([rand(-5, 5)]);
    return new \Echo511\PSO\Vector($coordinates);
};

$swarm = new \Echo511\PSO\Swarm($function, $optimizer, $c1, $c2, $c3, $numberOfParticles, $numberOfIterations, $generateParticleCoordinatesCallback, $generateParticleVelocityCallback);
$swarm->run();

print_r("Best value: ");
print_r($swarm->getBestValue());
print_r("\n");
print_r("Best coordinates: ");
print_r(implode("; ", $swarm->getBestCoordinates()->getCoordinates()));
print_r("\n");