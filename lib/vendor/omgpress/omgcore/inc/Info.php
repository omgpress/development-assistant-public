<?php

namespace WPDevAssist\OmgCore;

use Exception;
defined('ABSPATH') || exit;
/**
 * Plugin or theme information.
 */
abstract class Info extends Feature
{
    protected string $name;
    protected string $url;
    protected string $version;
    protected string $description;
    protected string $author;
    protected string $author_url;
    protected string $textdomain;
    protected string $domain_path;
    protected string $requires_php;
    protected string $requires_wp;
    protected array $headers = array('version' => 'Version', 'description' => 'Description', 'author' => 'Author', 'author_url' => 'Author URI', 'textdomain' => 'Text Domain', 'domain_path' => 'Domain Path', 'requires_wp' => 'Requires at least', 'requires_php' => 'Requires PHP');
    /**
     * @throws Exception
     * @ignore
     */
    public function __construct(string $file_with_headers)
    {
        parent::__construct();
        $info = get_file_data($file_with_headers, $this->headers);
        $this->name = $info['name'];
        $this->url = $info['url'];
        $this->version = $info['version'];
        $this->description = $info['description'];
        $this->author = $info['author'];
        $this->author_url = $info['author_url'];
        $this->textdomain = $info['textdomain'];
        $this->domain_path = $info['domain_path'];
        $this->requires_wp = $info['requires_wp'];
        $this->requires_php = $info['requires_php'];
    }
    /**
     * Returns the name of the plugin or theme.
     *
     * @return string The name of the plugin or theme.
     */
    public function get_name(): string
    {
        return $this->name;
    }
    /**
     * Returns the URL of the plugin or theme.
     *
     * @return string The URL of the plugin or theme.
     */
    public function get_url(): string
    {
        return $this->url;
    }
    /**
     * Returns the version of the plugin or theme.
     *
     * @return string The version of the plugin or theme.
     */
    public function get_version(): string
    {
        return $this->version;
    }
    /**
     * Returns the description of the plugin or theme.
     *
     * @return string The description of the plugin or theme.
     */
    public function get_description(): string
    {
        return $this->description;
    }
    /**
     * Returns the author of the plugin or theme.
     *
     * @return string The author of the plugin or theme.
     */
    public function get_author(): string
    {
        return $this->author;
    }
    /**
     * Returns the author URL of the plugin or theme.
     *
     * @return string The author URL of the plugin or theme.
     */
    public function get_author_url(): string
    {
        return $this->author_url;
    }
    /**
     * Returns the text domain of the plugin or theme.
     *
     * @return string The text domain of the plugin or theme.
     */
    public function get_textdomain(): string
    {
        return $this->textdomain;
    }
    /**
     * Returns the domain path of the plugin or theme.
     *
     * @return string The domain path of the plugin or theme.
     */
    public function get_domain_path(): string
    {
        return $this->domain_path;
    }
    /**
     * Returns the required PHP version for the plugin or theme.
     *
     * @return string The required PHP version.
     */
    public function get_requires_php(): string
    {
        return $this->requires_php;
    }
    /**
     * Returns the required WordPress version for the plugin or theme.
     *
     * @return string The required WordPress version.
     */
    public function get_requires_wp(): string
    {
        return $this->requires_wp;
    }
}
