<?php

namespace WPDevAssist\OmgCore;

use Exception;
defined('ABSPATH') || exit;
/**
 * Environment manager.
 */
class Env extends Feature
{
    protected array $dev_hosts = array('localhost', 'local', 'loc', 'development', 'dev', 'mamp');
    protected array $dev_envs = array('development', 'local');
    protected bool $is_dev;
    /**
     * @throws Exception
     * @ignore
     */
    public function __construct()
    {
        parent::__construct();
        $host = explode('.', wp_parse_url(home_url(), \PHP_URL_HOST));
        $root_host = end($host);
        $this->is_dev = in_array($root_host, $this->dev_hosts, \true) || in_array(wp_get_environment_type(), $this->dev_envs, \true) || defined('WP_ENVIRONMENT') && in_array(WP_ENVIRONMENT, $this->dev_envs, \true);
    }
    /**
     * Checks if the current environment is a development environment.
     *
     * @return bool True if in a development environment, false otherwise.
     */
    public function is_dev(): bool
    {
        return $this->is_dev;
    }
}
