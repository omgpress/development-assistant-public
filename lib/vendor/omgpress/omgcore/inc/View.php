<?php

namespace WPDevAssist\OmgCore;

defined('ABSPATH') || exit;
/**
 * View manager.
 */
abstract class View extends Feature
{
    protected string $dir = 'view';
    /**
     * Returns content of a template file.
     *
     * @param string $name The name of the template file (without extension).
     * @param array $args Optional. An associative array of variables to be extracted into the template.
     *
     * @return string The rendered content of the template file.
     */
    abstract public function get(string $name, array $args = array()): string;
    /**
     * Renders (echoes) a template file.
     *
     * @param string $name The name of the template file (without extension).
     * @param array $args Optional. An associative array of variables to be extracted into the template.
     *
     * @return self
     */
    abstract public function render(string $name, array $args = array()): self;
}
