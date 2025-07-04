<?php

namespace WPDevAssist\OmgCore\Dependency;

use WPDevAssist\WP_Upgrader_Skin;
defined('ABSPATH') || exit;
class SilentUpgraderSkin extends WP_Upgrader_Skin
{
    /**
     * @param string $feedback
     * @param mixed ...$args
     */
    public function feedback($feedback, ...$args): void
    {
        // Do nothing
    }
}
