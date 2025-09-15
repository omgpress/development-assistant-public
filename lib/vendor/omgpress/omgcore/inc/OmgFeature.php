<?php

namespace WPDevAssist\OmgCore;

use Exception;
use InvalidArgumentException;
defined('ABSPATH') || exit;
/**
 * Feature.
 */
abstract class OmgFeature
{
    protected static array $initiated = array();
    protected array $config = array();
    protected array $i18n = array();
    /**
     * @throws Exception
     * @ignore
     */
    public function __construct(?callable $get_config = null, ?callable $get_i18n = null)
    {
        if (in_array(static::class, self::$initiated, \true)) {
            throw new Exception(static::class . ' class can be initialized only once');
        }
        self::$initiated[] = static::class;
        if (is_callable($get_config)) {
            $config = $get_config()[static::class] ?? array();
            foreach ($config as $prop => $value) {
                if (!property_exists(static::class, $prop)) {
                    throw new InvalidArgumentException(esc_html("Unknown config prop: {$prop}"));
                }
                switch (gettype($this->{$prop})) {
                    case 'string':
                        if (!is_string($value)) {
                            throw new InvalidArgumentException(esc_html("Config key {$prop} must be a string"));
                        }
                        break;
                    case 'integer':
                        if (!is_int($value)) {
                            throw new InvalidArgumentException(esc_html("Config key {$prop} must be an integer"));
                        }
                        break;
                    case 'array':
                        if (!is_array($value)) {
                            throw new InvalidArgumentException(esc_html("Config key {$prop} must be an array"));
                        }
                        break;
                    case 'bool':
                        if (!is_bool($value)) {
                            throw new InvalidArgumentException(esc_html("Config key {$prop} must be a boolean"));
                        }
                        break;
                    default:
                        throw new InvalidArgumentException(esc_html("Unknown config prop type: {$prop}"));
                }
                $this->{$prop} = $value;
            }
        }
        if (is_callable($get_i18n)) {
            add_action('init', function () use ($get_i18n): void {
                $i18n = $get_i18n()[static::class] ?? array();
                foreach ($i18n as $prop => $value) {
                    if (!property_exists(static::class, $prop)) {
                        throw new InvalidArgumentException(esc_html("Unknown i18n prop: {$prop}"));
                    }
                    if (!is_string($value)) {
                        throw new InvalidArgumentException(esc_html("I18n key {$prop} must be a string"));
                    }
                    $this->{$prop} = $value;
                }
            }, 1);
        }
    }
}
