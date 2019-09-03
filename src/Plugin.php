<?php
namespace Kanboard\Plugin\Kanext;

use Kanboard\Core\Base;
use Kanboard\Core\Template;

class Plugin extends Base
{
    public function initialize()
    {
    }
    public function getClasses()
    {
        return array();
    }

    public function getHelpers()
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
     * but mandatory to have it checked when kanboard releases minors or majors.
     */
    public function getCompatibleVersion()
    {
        return '>1.2.0';
    }
}
