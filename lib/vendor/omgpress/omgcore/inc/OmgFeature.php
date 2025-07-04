<?php

namespace WPDevAssist\OmgCore;

use Exception;
use InvalidArgumentException;
defined('ABSPATH') || exit;
abstract class OmgFeature
{
    protected static array $initiated = array();
    protected array $config_props = array();
    /**
     * @throws Exception
     */
    public function __construct(array $config = array())
    {
        if (in_array(static::class, self::$initiated, \true)) {
            throw new Exception(static::class . ' class can be initialized only once');
        }
        self::$initiated[] = static::class;
        foreach ($this->config_props as $config_prop => $config_default_value) {
            if (!isset($config[$config_prop])) {
                $this->{$config_prop} = $config_default_value;
                continue;
            }
            switch (gettype($this->config_props[$config_prop])) {
                case 'string':
                    if (!is_string($config[$config_prop])) {
                        throw new InvalidArgumentException(esc_html("Config key \"{$config_prop}\" must be a string"));
                    }
                    break;
                case 'integer':
                    if (!is_int($config[$config_prop])) {
                        throw new InvalidArgumentException(esc_html("Config key \"{$config_prop}\" must be an integer"));
                    }
                    break;
                case 'array':
                    if (!is_array($config[$config_prop])) {
                        throw new InvalidArgumentException(esc_html("Config key \"{$config_prop}\" must be an array"));
                    }
                    break;
                case 'bool':
                    if (!is_bool($config[$config_prop])) {
                        throw new InvalidArgumentException(esc_html("Config key \"{$config_prop}\" must be a boolean"));
                    }
                    break;
                default:
                    throw new InvalidArgumentException(esc_html("Unknown config prop type: \"{$config_prop}\""));
            }
            $this->{$config_prop} = $config[$config_prop];
        }
    }
}
