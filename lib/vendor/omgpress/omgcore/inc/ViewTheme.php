<?php

namespace WPDevAssist\OmgCore;

use Exception;
defined('ABSPATH') || exit;
/**
 * @ignore
 */
class ViewTheme extends View
{
    public function get(string $name, array $args = array()): string
    {
        ob_start();
        $this->render($name, $args);
        return ob_get_clean();
    }
    public function render(string $name, array $args = array()): self
    {
        get_template_part("{$this->dir}/{$name}", null, $args);
        return $this;
    }
}
