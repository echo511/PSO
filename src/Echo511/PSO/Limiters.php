<?php

namespace Echo511\PSO;

/**
 * Class Limiters
 *
 * @category Library
 * @package Echo511\PSO
 */
class Limiters
{

    /**
     * @param $maxAllowedDeviation
     * @param null $iterationLimit
     * @return \Closure
     */
    public static function createStandardDeviationLimiter($maxAllowedDeviation, $iterationLimit = NULL)
    {
        return function ($particles, $iteration) use ($maxAllowedDeviation, $iterationLimit) {
            $sum = 0;
            /** @var Particle $particle */
            foreach ($particles as $particle) {
                $sum = $sum + $particle->getValue();
            }
            $average = $sum / count($particles);

            $sum = 0;
            foreach ($particles as $particle) {
                $sum = $sum + ($particle->getValue() - $average) ** 2;
            }
            $variance = $sum / count($particles);

            $sigma = $variance ** (1/2);

            if ($iterationLimit) {
                if ($iteration >= $iterationLimit) {
                    return true;
                }
            }

            if ($sigma <= $maxAllowedDeviation) {
                return true;
            }
        };
    }

}