<?php

namespace WPDevAssist\OmgCore;

use Exception;
defined('ABSPATH') || exit;
/**
 * @ignore
 */
class InfoTheme extends Info
{
    /**
     * @throws Exception
     * @ignore
     */
    public function __construct(string $file_with_headers)
    {
        $this->headers['name'] = 'Theme Name';
        $this->headers['url'] = 'Theme URI';
        parent::__construct($file_with_headers);
    }
}
