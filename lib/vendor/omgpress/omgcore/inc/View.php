<?php

namespace WPDevAssist\OmgCore;

defined('ABSPATH') || exit;
abstract class View extends OmgFeature
{
    protected array $config_props = array('dir' => 'view');
    abstract public function get(string $name, array $args = array()): string;
    abstract public function render(string $name, array $args = array()): self;
}
