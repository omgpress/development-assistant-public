<?php

namespace WPDevAssist\OmgCore;

defined('ABSPATH') || exit;
class ViewTheme extends View
{
    protected string $dir;
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
