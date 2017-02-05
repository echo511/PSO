<?php

namespace Echo511\PSO;

class Space
{

    /**
     * Return vector that when added to from coordinates results in to coordinates.
     *
     * @param  Coordinates $from
     * @param  Coordinates $to
     * @return Vector
     */
    public static function getVectorToMove(Coordinates $from, Coordinates $to)
    {
        return (new Vector($to))->minus((new Vector($from)));
    }
}
