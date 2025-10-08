<?php

namespace WPDevAssist\OmgCore;

use Exception;
defined('ABSPATH') || exit;
/**
 * @ignore
 */
class ViewPlugin extends View
{
    protected Fs $fs;
    /**
     * @throws Exception
     * @ignore
     */
    public function __construct(Fs $fs, callable $get_config)
    {
        parent::__construct($get_config);
        $this->fs = $fs;
    }
    public function get(string $name, array $args = array()): string
    {
        // phpcs:ignore
        ob_start();
        include $this->fs->get_path("{$this->dir}/{$name}.php");
        return ob_get_clean();
    }
    public function render(string $name, array $args = array()): self
    {
        echo wp_kses_post($this->get($name, $args));
        return $this;
    }
}
