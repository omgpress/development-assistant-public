<?php

namespace WPDevAssist\OmgCore\Helper;

defined('ABSPATH') || exit;
trait ArrayInsertToPosition
{
    /**
     * Inserts an array into a target array at a specified position.
     *
     * @param array $array_for_insert The array to insert.
     * @param array $target_array The target array where the insertion will happen.
     * @param int $position The position in the target array to insert the new array.
     *
     * @return array The modified target array with the new array inserted.
     */
    public function insert_to_position(array $array_for_insert, array $target_array, int $position): array
    {
        if (empty($target_array)) {
            return $array_for_insert;
        }
        return array_merge(array_slice($target_array, 0, $position), $array_for_insert, array_slice($target_array, $position));
    }
}
