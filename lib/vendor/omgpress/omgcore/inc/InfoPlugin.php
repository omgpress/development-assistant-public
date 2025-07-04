<?php

namespace WPDevAssist\OmgCore;

defined('ABSPATH') || exit;
class InfoPlugin extends Info
{
    public function __construct(string $file_with_headers)
    {
        $this->headers['name'] = 'Plugin Name';
        $this->headers['url'] = 'Plugin URI';
        parent::__construct($file_with_headers);
    }
}
