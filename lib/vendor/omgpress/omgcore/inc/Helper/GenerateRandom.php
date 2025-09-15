<?php

namespace WPDevAssist\OmgCore\Helper;

use Random\RandomException;
defined('ABSPATH') || exit;
trait GenerateRandom
{
    /**
     * Generates a random string of specified length using characters from the keyspace.
     *
     * @param int $length The length of the random string to generate.
     * @param string $keyspace The characters to use for generating the random string.
     *
     * @return string The generated random string.
     * @throws RandomException
     */
    public function generate_random(int $length = 16, string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'): string
    {
        $pieces = array();
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces[] = $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }
}
