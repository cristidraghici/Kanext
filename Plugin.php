<?php
namespace Kanboard\Plugin\Kanext;

use DirectoryIterator;
use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;

class Plugin extends Base
{
    public function initialize()
    {
        // Hooks
        $this->template->hook->attach('template:dashboard:sidebar', 'kanext:_hooks/dashboard/sidebar');
        $this->template->hook->attach('template:layout:head', 'kanext:_hooks/layout/head');

        // Override
        $this->template->setTemplateOverride('dashboard/layout', 'kanext:_overrides/dashboard/layout');
        $this->template->setTemplateOverride('dashboard/overview', 'kanext:_overrides/dashboard/overview');
        $this->template->setTemplateOverride('dashboard/projects', 'kanext:_overrides/dashboard/projects');
        $this->template->setTemplateOverride('board/table_container', 'kanext:_overrides/board/table_container');

        // JS and CSS
        $this->hook->on('template:layout:js', array('template' => 'plugins/Kanext/Assets/base.js'));
        $this->hook->on('template:layout:css', array('template' => 'plugins/Kanext/Assets/base.css'));

        // Fixes
        if ($this->configModel->get('kanext_use_js_fixes') == 1) {
            $this->hook->on('template:layout:js', array('template' => 'plugins/Kanext/Assets/fixes.js'));
        }
        if ($this->configModel->get('kanext_use_css_fixes') == 1) {
            $this->hook->on('template:layout:css', array('template' => 'plugins/Kanext/Assets/fixes.css'));
        }

        // The Kanext theme
        if ($this->configModel->get('kanext_use_own_theme') == 1) {
            $this->hook->on('template:layout:css', array('template' => 'plugins/Kanext/Assets/PluginSkins/kanext.css'));
        }

        // Configuration
        $this->template->hook->attach('template:config:sidebar', 'kanext:config/sidebar');
    }
    public function onStartup()
    {
        // Load the locales
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');

        // Load custom CSS for plugins
        if ($this->configModel->get('kanext_use_plugin_fixes') == 1) {
            $overwritables_plugins_css = array();

            // Get the list of overwritable values
            $dir = new DirectoryIterator(__DIR__ . '/Assets/PluginSkins/');
            foreach ($dir as $fileInfo) {
                if ($fileInfo->isFile()) {
                    $overwritables_plugins_css[] = strtolower($fileInfo->getBasename('.css'));
                }
            }

            // Get the installed plugins
            $installedPlugins = array();
            foreach ($this->pluginLoader->getPlugins() as $plugin) {
                $installedPlugins[strtolower($plugin->getPluginName())] = $plugin->getPluginVersion();
            }

            foreach ($overwritables_plugins_css as $theme) {
                if (isset($installedPlugins[$theme])) {
                    $this->hook->on('template:layout:css', array('template' => 'plugins/Kanext/Assets/PluginSkins/'.$theme.'.css'));
                }
            }
        }
    }

    public function getClasses()
    {
        return array(
            'Plugin\Kanext\Helper' => array(
              'ConfigHelper'
            )
        );
    }

    public function getPluginName()
    {
        return 'Kanext';
    }
    public function getPluginDescription()
    {
        return t('This theme modifies the default functionality of kanboard and enhances the user experience.', 'kanext');
    }
    public function getPluginAuthor()
    {
        return 'Cristi Draghici';
    }
    public function getPluginVersion()
    {
        return '2.0.0';
    }
    public function getPluginHomepage()
    {
        return 'https://github.com/cristidraghici/Kanext';
    }

    /**
     * This plugin alters php templates, thus is tightly dependent on the kanboard version.
     * It is recommended that the plugin be checked with every release,
     * but mandatory to have it checked when kanboard releases minors or majors. Thus,
     * we use a lesser than condition, assuming that people who new-ish :) plugins, also care to update
     * the version of Kanboard.
     */
    public function getCompatibleVersion()
    {
        return '<1.3.0';
    }
}
