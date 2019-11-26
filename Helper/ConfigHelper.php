<?php
namespace Kanboard\Plugin\Kanext\Helper;

use Kanboard\Core\Base;

// TODO: add default values here
class ConfigHelper extends Base
{
    // The default configuration
    public function getDefaults() {
        return array(
            'kanext_use_own_theme' => $this->configModel->get('kanext_use_own_theme'),
            'kaext_use_css_fixes' => $this->configModel->get('kanext_use_css_fixes'),
            'kanext_use_js_fixes' => $this->configModel->get('kanext_use_js_fixes'),
            'kanext_use_plugin_fixes' => $this->configModel->get('kanext_use_plugin_fixes'),

            'kanext_feature_toggle_sidebar' => $this->configModel->get('kanext_feature_toggle_sidebar'),

            'kanext_dashboard_activity_type' => $this->configModel->get('kanext_dashboard_activity_type', 'kanext_dashboard_activity_general'),
            'kanext_custom_css' => $this->configModel->get('kanext_custom_css', ''),
        );
    }

    // List of configuration items which are checkboxes
    public function getCheckboxes() {
        return [
            'kanext_use_own_theme',
            'kanext_use_css_fixes',
            'kanext_use_js_fixes',
            'kanext_use_plugin_fixes',
            'kanext_feature_toggle_sidebar'
        ];
    }

    /**
     * Get a value for a configuration variable
     * @param  string $name Name of the variables
     * @return mixed        Content of the variable
     */
    public function get($name=null)
    {
        return $this->configModel->get($name);
    }
}
