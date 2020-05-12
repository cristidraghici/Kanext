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
        $this->template->hook->attach('template:dashboard:sidebar', 'kanext:kanext_hooks/dashboard/sidebar-hook');
        $this->template->hook->attach('template:layout:head', 'kanext:kanext_hooks/layout/head-hook');

        // Override
        $this->template->setTemplateOverride('dashboard/layout', 'kanext:kanext_overrides/dashboard/layout');

        // Kanext configuration - attach the link to the settings sidebar
        $this->template->hook->attach('template:config:sidebar', 'kanext:kanext_configuration/settings-sidebar-item');

        // Close dropdown on second click
        if ($this->configModel->get('kanext_close_dropdown_on_second_click') == 1) {
            $this->hook->on('template:layout:js', array('template' => 'plugins/Kanext/Assets/SecondClickClose/script.js'));
        }

        // Close modal on overlay click
        if ($this->configModel->get('kanext_close_modal_on_overlay_click') == 1) {
            $this->hook->on('template:layout:js', array('template' => 'plugins/Kanext/Assets/OverlayClickClose/script.js'));
        }

        // General style fixes
        if ($this->configModel->get('kanext_general_style_fixes') == 1) {
            $this->hook->on('template:layout:css', array('template' => 'plugins/Kanext/Assets/StyleFixes/style.css'));
        }

        // The sidebar toggle
        if ($this->configModel->get('kanext_feature_toggle_sidebar') == 1) {
            $this->hook->on('template:layout:js', array('template' => 'plugins/Kanext/Assets/ToggleSidebar/script.js'));
            $this->hook->on('template:layout:css', array('template' => 'plugins/Kanext/Assets/ToggleSidebar/style.css'));
        }

        // Custom dashboard
        if ($this->configModel->get('kanext_feature_kanext_dashboard') == 1) {
            $this->hook->on('template:layout:js', array('template' => 'plugins/Kanext/Assets/KanextDashboard/script.js'));
            $this->hook->on('template:layout:css', array('template' => 'plugins/Kanext/Assets/KanextDashboard/style.css'));

            $this->template->setTemplateOverride('dashboard/overview', 'kanext:kanext_dashboard/dashboard/overview');
        }
    }

    public function onStartup()
    {
        // Load the locales
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');

        // Load custom CSS for plugins
        if ($this->configModel->get('kanext_feature_fixes_for_theme_plugins') == 1) {
            $kanext_skins = PLUGINS_DIR . '/Kanext/Assets/PluginSkins/';
            $overwritables_plugins_css = array();

            // Get the list of overwritable values
            $dir = new DirectoryIterator($kanext_skins);
            foreach ($dir as $fileInfo) {
                if ($fileInfo->isFile()) {
                    $overwritables_plugins_css[] = strtolower($fileInfo->getBasename('.css'));
                }
            }

            // Get the installed plugins
            $installed_plugins = array();
            foreach ($this->pluginLoader->getPlugins() as $plugin) {
                $installed_plugins[strtolower($plugin->getPluginName())] = $plugin->getPluginVersion();
            }

            foreach ($overwritables_plugins_css as $theme) {
                if (isset($installed_plugins[$theme])) {
                    $this->hook->on('template:layout:css', array('template' => 'plugins/Kanext/Assets/PluginSkins/'.$theme.'.css'));
                }
            }
        }
    }

    public function getClasses()
    {
        $classes = array(
            'Plugin\Kanext\Helper' => array(
              'ConfigHelper'
            )
        );

        // Custom dashboard
        if ($this->configModel->get('kanext_feature_kanext_dashboard') == 1) {
            $classes['Plugin\Kanext\Model'] = array(
                'KanextDashboardModel',
            );
        }

        return $classes;
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
        return '3.0.1';
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
