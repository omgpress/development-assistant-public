<?php

namespace WPDevAssist\OmgCore\Helper;

defined('ABSPATH') || exit;
trait ArrayInsertToPosition
{
    protected function insert_to_position(array $array_for_insert, array $target_array, int $position): array
    {
        if (empty($target_array)) {
            return $array_for_insert;
        }
        return array_merge(array_slice($target_array, 0, $position), $array_for_insert, array_slice($target_array, $position));
    }
}
