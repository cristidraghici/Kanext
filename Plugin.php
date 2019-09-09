<?php
namespace Kanboard\Plugin\Kanext;

use Kanboard\Core\Plugin\Base;

class Plugin extends Base
{
    public function initialize()
    {
        // Hooks
        $this->template->hook->attach('template:dashboard:sidebar', 'kanext:_hooks/dashboard/sidebar');

        // Override
        $this->template->setTemplateOverride('dashboard/layout', 'kanext:_overrides/dashboard/layout');
        $this->template->setTemplateOverride('dashboard/overview', 'kanext:_overrides/dashboard/overview');
        $this->template->setTemplateOverride('dashboard/projects', 'kanext:_overrides/dashboard/projects');

        // JS and CSS
        $this->hook->on('template:layout:js', array('template' => 'plugins/Kanext/Assets/kanext.js'));
        $this->hook->on('template:layout:css', array('template' => 'plugins/Kanext/Assets/kanext.css'));
    }
    public function getClasses()
    {
        return array();
    }
    public function getPluginName()
    {
        return 'Kanext';
    }
    public function getPluginAuthor()
    {
        return 'Cristi Draghici';
    }
    public function getPluginVersion()
    {
        return '2.0.0';
    }
    public function getPluginDescription()
    {
        return 'This theme modifies the default functionality of kanboard and enhances the user experience.';
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
