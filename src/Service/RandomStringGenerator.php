<?php

namespace App\Service;

/**
 * Class RandomStringGenerator
 */
final class RandomStringGenerator
{
    /**
     * @param int $len
     * @return string
     */
    public static function incrementalHash($len = 5) : string
    {
        $limit = 5;
        return random_int(10 ** ($limit - 1), (10 ** $limit) - 1);
    }
}
