<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0ae3c240357615aec9ffc2c7d9e8f349
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WPDevAssist\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WPDevAssist\\' => 
        array (
            0 => __DIR__ . '/../..' . '/../inc',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'WPDevAssist\\App' => __DIR__ . '/../..' . '/../inc/App.php',
        'WPDevAssist\\Assistant' => __DIR__ . '/../..' . '/../inc/Assistant.php',
        'WPDevAssist\\Assistant\\Control' => __DIR__ . '/../..' . '/../inc/Assistant/Control.php',
        'WPDevAssist\\Assistant\\MailHog' => __DIR__ . '/../..' . '/../inc/Assistant/MailHog.php',
        'WPDevAssist\\Assistant\\Section' => __DIR__ . '/../..' . '/../inc/Assistant/Section.php',
        'WPDevAssist\\Assistant\\SupportUser' => __DIR__ . '/../..' . '/../inc/Assistant/SupportUser.php',
        'WPDevAssist\\Assistant\\WPDebug' => __DIR__ . '/../..' . '/../inc/Assistant/WPDebug.php',
        'WPDevAssist\\Htaccess' => __DIR__ . '/../..' . '/../inc/Htaccess.php',
        'WPDevAssist\\MailHog' => __DIR__ . '/../..' . '/../inc/MailHog.php',
        'WPDevAssist\\Model\\ActionLink' => __DIR__ . '/../..' . '/../inc/Model/ActionLink.php',
        'WPDevAssist\\OmgCore\\ActionQuery' => __DIR__ . '/..' . '/omgpress/omgcore/inc/ActionQuery.php',
        'WPDevAssist\\OmgCore\\AdminNotice' => __DIR__ . '/..' . '/omgpress/omgcore/inc/AdminNotice.php',
        'WPDevAssist\\OmgCore\\Asset' => __DIR__ . '/..' . '/omgpress/omgcore/inc/Asset.php',
        'WPDevAssist\\OmgCore\\Dependency' => __DIR__ . '/..' . '/omgpress/omgcore/inc/Dependency.php',
        'WPDevAssist\\OmgCore\\Dependency\\Plugin' => __DIR__ . '/..' . '/omgpress/omgcore/inc/Dependency/Plugin.php',
        'WPDevAssist\\OmgCore\\Dependency\\SilentUpgraderSkin' => __DIR__ . '/..' . '/omgpress/omgcore/inc/Dependency/SilentUpgraderSkin.php',
        'WPDevAssist\\OmgCore\\Env' => __DIR__ . '/..' . '/omgpress/omgcore/inc/Env.php',
        'WPDevAssist\\OmgCore\\Fs' => __DIR__ . '/..' . '/omgpress/omgcore/inc/Fs.php',
        'WPDevAssist\\OmgCore\\FsPlugin' => __DIR__ . '/..' . '/omgpress/omgcore/inc/FsPlugin.php',
        'WPDevAssist\\OmgCore\\FsTheme' => __DIR__ . '/..' . '/omgpress/omgcore/inc/FsTheme.php',
        'WPDevAssist\\OmgCore\\Helper\\ArrayInsertToPosition' => __DIR__ . '/..' . '/omgpress/omgcore/inc/Helper/ArrayInsertToPosition.php',
        'WPDevAssist\\OmgCore\\Helper\\ConvertIso8601ToMin' => __DIR__ . '/..' . '/omgpress/omgcore/inc/Helper/ConvertIso8601ToMin.php',
        'WPDevAssist\\OmgCore\\Helper\\DashToCamelcase' => __DIR__ . '/..' . '/omgpress/omgcore/inc/Helper/DashToCamelcase.php',
        'WPDevAssist\\OmgCore\\Helper\\GenerateRandom' => __DIR__ . '/..' . '/omgpress/omgcore/inc/Helper/GenerateRandom.php',
        'WPDevAssist\\OmgCore\\Helper\\TruncateHtmlContent' => __DIR__ . '/..' . '/omgpress/omgcore/inc/Helper/TruncateHtmlContent.php',
        'WPDevAssist\\OmgCore\\Info' => __DIR__ . '/..' . '/omgpress/omgcore/inc/Info.php',
        'WPDevAssist\\OmgCore\\InfoPlugin' => __DIR__ . '/..' . '/omgpress/omgcore/inc/InfoPlugin.php',
        'WPDevAssist\\OmgCore\\InfoTheme' => __DIR__ . '/..' . '/omgpress/omgcore/inc/InfoTheme.php',
        'WPDevAssist\\OmgCore\\OmgApp' => __DIR__ . '/..' . '/omgpress/omgcore/inc/OmgApp.php',
        'WPDevAssist\\OmgCore\\OmgFeature' => __DIR__ . '/..' . '/omgpress/omgcore/inc/OmgFeature.php',
        'WPDevAssist\\OmgCore\\View' => __DIR__ . '/..' . '/omgpress/omgcore/inc/View.php',
        'WPDevAssist\\OmgCore\\ViewPlugin' => __DIR__ . '/..' . '/omgpress/omgcore/inc/ViewPlugin.php',
        'WPDevAssist\\OmgCore\\ViewTheme' => __DIR__ . '/..' . '/omgpress/omgcore/inc/ViewTheme.php',
        'WPDevAssist\\PluginsScreen' => __DIR__ . '/../..' . '/../inc/PluginsScreen.php',
        'WPDevAssist\\PluginsScreen\\ActivationManager' => __DIR__ . '/../..' . '/../inc/PluginsScreen/ActivationManager.php',
        'WPDevAssist\\PluginsScreen\\Downloader' => __DIR__ . '/../..' . '/../inc/PluginsScreen/Downloader.php',
        'WPDevAssist\\Setting' => __DIR__ . '/../..' . '/../inc/Setting.php',
        'WPDevAssist\\Setting\\BasePage' => __DIR__ . '/../..' . '/../inc/Setting/BasePage.php',
        'WPDevAssist\\Setting\\Control' => __DIR__ . '/../..' . '/../inc/Setting/Control.php',
        'WPDevAssist\\Setting\\DebugLog' => __DIR__ . '/../..' . '/../inc/Setting/DebugLog.php',
        'WPDevAssist\\Setting\\DevEnv' => __DIR__ . '/../..' . '/../inc/Setting/DevEnv.php',
        'WPDevAssist\\Setting\\Page' => __DIR__ . '/../..' . '/../inc/Setting/Page.php',
        'WPDevAssist\\Setting\\SupportUser' => __DIR__ . '/../..' . '/../inc/Setting/SupportUser.php',
        'WPDevAssist\\Setting\\Tab' => __DIR__ . '/../..' . '/../inc/Setting/Tab.php',
        'WPDevAssist\\WPDebug' => __DIR__ . '/../..' . '/../inc/WPDebug.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0ae3c240357615aec9ffc2c7d9e8f349::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0ae3c240357615aec9ffc2c7d9e8f349::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit0ae3c240357615aec9ffc2c7d9e8f349::$classMap;

        }, null, ClassLoader::class);
    }
}
