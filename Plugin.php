<?php
namespace Kanboard\Plugin\Kanext;

use Kanboard\Core\Base;
use Kanboard\Core\Template;

use Kanboard\Plugin\Kanext\Helper\ConfigHelper;
use Kanboard\Plugin\Kanext\Helper\OverwriteHelper;

class Plugin extends Base
{
    public function initialize()
    {
        // Add some css and js
        $this->hook->on('template:layout:css', array('template' => 'plugins/Kanext/Assets/Css/kanext.css'));
        $this->hook->on('template:layout:js', array('template' => 'plugins/Kanext/Assets/Js/kanext.js'));

        // Load the overwrites
        $this->overwriteHelper->loadTemplates();
    }
    public function getClasses()
    {
        return array(
            'Plugin\Kanext\Helper' => array(
              'ConfigHelper',
              'OverwriteHelper'
            )
        );
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
        return '1.0.0';
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
     * Since this plugin stongly depends on the kanboard version, a compatible check is added
     */
    public function getCompatibleVersion()
    {
        return '<=1.2.4';
    }
}
