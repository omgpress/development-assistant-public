<?php

namespace WPDevAssist\OmgCore\Dependency;

use InvalidArgumentException;
defined('ABSPATH') || exit;
class Plugin
{
    protected string $key;
    protected string $name;
    /**
     * @var string|array
     */
    protected $filename;
    protected bool $is_optional;
    protected bool $is_active = \false;
    protected bool $is_installed = \false;
    protected bool $is_validated = \false;
    protected ?string $installation_url = null;
    /**
     * @param string|array $filename
     */
    public function __construct(string $key, string $name, $filename, bool $is_optional = \false, ?string $installation_url = null)
    {
        if (!is_string($filename) && !is_array($filename)) {
            throw new InvalidArgumentException('$filename must be a string or an array of strings');
        }
        if (is_array($filename)) {
            foreach ($filename as $file) {
                if (!is_string($file)) {
                    throw new InvalidArgumentException('$filename array can contain only strings');
                }
            }
        }
        $this->key = $key;
        $this->name = $name;
        $this->filename = $filename;
        $this->is_optional = $is_optional;
        $this->installation_url = $installation_url;
    }
    public function get_key(): string
    {
        return $this->key;
    }
    public function get_name(): string
    {
        return $this->name;
    }
    public function is_optional(): bool
    {
        return $this->is_optional;
    }
    public function is_active(): bool
    {
        return $this->validate()->is_active;
    }
    public function is_installed(): bool
    {
        return $this->validate()->is_installed;
    }
    public function get_installation_url(): ?string
    {
        return $this->installation_url;
    }
    protected function validate(): self
    {
        if ($this->is_validated) {
            return $this;
        }
        if (is_array($this->filename)) {
            foreach ($this->filename as $filename) {
                $this->is_active = is_plugin_active($filename);
                $this->is_installed = $this->is_active || file_exists(WP_PLUGIN_DIR . '/' . $filename);
                if ($this->is_installed) {
                    break;
                }
            }
        } else {
            $this->is_active = is_plugin_active($this->filename);
            $this->is_installed = $this->is_active || file_exists(WP_PLUGIN_DIR . '/' . $this->filename);
        }
        $this->is_validated = \true;
        return $this;
    }
    public function activate(): bool
    {
        if (is_array($this->filename)) {
            foreach ($this->filename as $filename) {
                if (null === activate_plugin($filename)) {
                    return \true;
                }
            }
            return \false;
        }
        return null === activate_plugin($this->filename);
    }
}
