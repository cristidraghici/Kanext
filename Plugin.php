<?php

namespace Kanboard\Plugin\Kanext;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;

class Plugin extends Base
{
    public function initialize()
    {
        // Hooks
        $this->template->hook->attach('template:dashboard:sidebar', 'kanext:dashboard/sidebar_hook');
        $this->template->hook->attach('template:layout:head', 'kanext:layout/head_hook');

        // Override
        $this->template->setTemplateOverride('dashboard/layout', 'kanext:dashboard/layout');

        // Kanext configuration - attach the link to the settings sidebar
        $this->template->hook->attach('template:config:sidebar', 'kanext:config/settings_sidebar_item');

        // Close dropdown on second click
        if ('1' === $this->configModel->get('kanext_close_dropdown_on_second_click')) {
            $this->hook->on('template:layout:js', ['template' => 'plugins/Kanext/Asset/SecondClickClose/script.js']);
        }

        // Close modal on overlay click
        if ('1' === $this->configModel->get('kanext_close_modal_on_overlay_click')) {
            $this->hook->on('template:layout:js', ['template' => 'plugins/Kanext/Asset/OverlayClickClose/script.js']);
        }

        // General style fixes
        if ('1' === $this->configModel->get('kanext_general_style_fixes')) {
            $this->hook->on('template:layout:css', ['template' => 'plugins/Kanext/Asset/StyleFixes/style.css']);
        }

        // The sidebar toggle
        if ('1' === $this->configModel->get('kanext_feature_toggle_sidebar')) {
            $this->hook->on('template:layout:js', ['template' => 'plugins/Kanext/Asset/ToggleSidebar/script.js']);
            $this->hook->on('template:layout:css', ['template' => 'plugins/Kanext/Asset/ToggleSidebar/style.css']);
        }

        // Custom dashboard
        if ('1' === $this->configModel->get('kanext_feature_kanext_dashboard')) {
            $this->hook->on('template:layout:js', ['template' => 'plugins/Kanext/Asset/KanextDashboard/script.js']);
            $this->hook->on('template:layout:css', ['template' => 'plugins/Kanext/Asset/KanextDashboard/style.css']);

            $this->template->setTemplateOverride('dashboard/overview', 'kanext:dashboard/overview');
        }
    }

    public function onStartup()
    {
        // Load the locales
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__ . '/Locale');

        // Limit the number of tasks in a column (in `onStartup` for later loading them)
        if ('1' === $this->configModel->get('kanext_feature_limit_tasks')) {
            $this->route->addRoute('kanext/tasks/:column/:swimlane', 'KanextTasksController', 'allTasksInColumn');

            $this->hook->on('template:layout:js', ['template' => 'plugins/Kanext/Asset/KanextLimitTasks/script.js']);
            $this->hook->on('template:layout:css', ['template' => 'plugins/Kanext/Asset/KanextLimitTasks/style.css']);

            $this->template->setTemplateOverride('board/table_tasks', 'kanext:board/table_tasks');
        }

        // Load custom CSS for plugins
        if ('1' === $this->configModel->get('kanext_feature_fixes_for_theme_plugins')) {
            $kanext_skins = PLUGINS_DIR . '/Kanext/Asset/PluginSkins/';

            if (!is_dir($kanext_skins)) {
                return;
            }

            $overwritables_plugins_css = [];

            // Get the list of overwritable values
            $dir = new \DirectoryIterator($kanext_skins);
            foreach ($dir as $fileInfo) {
                if ($fileInfo->isFile()) {
                    $overwritables_plugins_css[] = strtolower($fileInfo->getBasename('.css'));
                }
            }

            // Get the installed plugins
            $installed_plugins = [];
            foreach ($this->pluginLoader->getPlugins() as $plugin) {
                $installed_plugins[strtolower($plugin->getPluginName())] = $plugin->getPluginVersion();
            }

            foreach ($overwritables_plugins_css as $theme) {
                if (isset($installed_plugins[$theme])) {
                    $this->hook->on('template:layout:css', ['template' => 'plugins/Kanext/Asset/PluginSkins/' . $theme . '.css']);
                }
            }
        }
    }

    public function getClasses()
    {
        $classes = [
            'Plugin\Kanext\Helper' => [
                'ConfigHelper',
            ],
        ];

        // Custom dashboard
        if ('1' === $this->configModel->get('kanext_feature_kanext_dashboard')) {
            $classes['Plugin\Kanext\Model'] = [
                'KanextDashboardModel',
            ];
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
        return '4.0.1';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/cristidraghici/Kanext';
    }

    /**
     * This plugin alters php templates, thus is tightly dependent on the kanboard version.
     * It is mandatory to check the plugin with every update of kanboard.
     */
    public function getCompatibleVersion()
    {
        return '<=1.2.35';
    }
}
