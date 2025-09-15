<?php

namespace WPDevAssist\OmgCore;

use Exception;
defined('ABSPATH') || exit;
/**
 * @ignore
 */
class InfoPlugin extends Info
{
    /**
     * @throws Exception
     * @ignore
     */
    public function __construct(string $file_with_headers)
    {
        $this->headers['name'] = 'Plugin Name';
        $this->headers['url'] = 'Plugin URI';
        parent::__construct($file_with_headers);
    }
}
