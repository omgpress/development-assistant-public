<?php

namespace WPDevAssist\OmgCore;

defined('ABSPATH') || exit;
class InfoTheme extends Info
{
    public function __construct(string $file_with_headers)
    {
        $this->headers['name'] = 'Theme Name';
        $this->headers['url'] = 'Theme URI';
        parent::__construct($file_with_headers);
    }
}
