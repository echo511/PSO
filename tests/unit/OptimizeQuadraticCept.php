<?php 
$I = new UnitTester($scenario);
$I->wantTo('perform actions and see result');


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

$limiter = \Echo511\PSO\Limiters::createStandardDeviationLimiter(0.5, 500);

$generateParticleCoordinatesCallback = function () {
    return new \Echo511\PSO\Coordinates([rand(-50, 50)]);
};

$generateParticleVelocityCallback = function () {
    $coordinates = new \Echo511\PSO\Coordinates([rand(-5, 5)]);
    return new \Echo511\PSO\Vector($coordinates);
};

$swarm = new \Echo511\PSO\Swarm($function, $optimizer, $c1, $c2, $c3, $numberOfParticles, $limiter, $generateParticleCoordinatesCallback, $generateParticleVelocityCallback);
$swarm->run();

$value = (int) round($swarm->getBestValue());
$coordinates = (int) round($swarm->getBestCoordinates()->getCoordinates()[0]);

$I->assertEquals(5, $value);
$I->assertEquals(3, $coordinates);
