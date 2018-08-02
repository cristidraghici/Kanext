<?php
namespace Kanboard\Plugin\Kanext;

use Kanboard\Core\Base;
use Kanboard\Core\Template;

use Kanboard\Plugin\Kanext\Helper\ConfigHelper;
use Kanboard\Plugin\Kanext\Helper\OverwriteHelper;

require __DIR__ . '/vendor/autoload.php';

use SassCompiler;
use MatthiasMullie\Minify;

class Plugin extends Base
{
    public function initialize()
    {
        // Generate minified CSS
        if (!$this->configHelper->get('disable_scss_compilation')) {
            SassCompiler::run(__DIR__ . '/resources/scss/', __DIR__ . '/Assets/Css/');

            // Update the file with more commands than needed
            unlink(__DIR__ . '/Assets/Css/kanext.min.css');
            $css = new Minify\CSS();
            $css->add(__DIR__ . '/Assets/Css/kanext.css');
            $minified = $css->minify();
            file_put_contents(__DIR__ . '/Assets/Css/kanext.min.css', $minified);

            @unlink(__DIR__ . '/Assets/Css/kanext.css');
        }

        // Generate minified Js
        if (!$this->configHelper->get('disable_js_compilation')) {

            // Update the file with more commands than needed
            unlink(__DIR__ . '/Assets/Js/kanext.min.js');
            $js = new Minify\JS();

            $js->add(__DIR__ . '/resources/js/links.js');
            $js->add(__DIR__ . '/resources/js/modal.js');

            $minified = $js->minify();
            file_put_contents(__DIR__ . '/Assets/Js/kanext.min.js', $minified);
        }

        // Add some css and js
        $this->hook->on('template:layout:css', array('template' => 'plugins/Kanext/Assets/Css/kanext.min.css' ));
        $this->hook->on('template:layout:js', array('template' => 'plugins/Kanext/Assets/Js/kanext.min.js' ));

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
