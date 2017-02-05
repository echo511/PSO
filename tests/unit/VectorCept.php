<?php
$I = new UnitTester($scenario);
$I->wantTo('perform actions and see result');

$coordinates = new \Echo511\PSO\Coordinates([0, 1, 2]);
$vector = new \Echo511\PSO\Vector($coordinates);

$I->assertEquals(0, $vector->getCoordinateAxeValue(0));
$I->assertEquals(1, $vector->getCoordinateAxeValue(1));
$I->assertEquals(2, $vector->getCoordinateAxeValue(2));

$I->assertSame($vector->getCoordinatesArray(), $vector->getCoordinates()->getCoordinates());

$coordinates = new \Echo511\PSO\Coordinates([2, 1, 0]);
$vectorPlus = new \Echo511\PSO\Vector($coordinates);
$result = $vector->plus($vectorPlus)->getCoordinatesArray();
$I->assertEquals([2, 2, 2], $result);
$I->assertNotEquals($vector, $result);


$coordinates = new \Echo511\PSO\Coordinates([1, 2, 0]);
$vectorMinus = new \Echo511\PSO\Vector($coordinates);
$result = $vector->minus($vectorMinus)->getCoordinatesArray();
$I->assertEquals([-1, -1, 2], $result);
$I->assertNotEquals($vector, $result);


$result = $vector->multiply(2)->getCoordinatesArray();
$I->assertEquals([0, 2, 4], $result);
$I->assertNotEquals($vector, $result);
