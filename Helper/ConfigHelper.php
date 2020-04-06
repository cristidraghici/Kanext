<?php
namespace Kanboard\Plugin\Kanext\Helper;

use Kanboard\Core\Base;

class ConfigHelper extends Base
{
    // The groups for the configuration options (just organizational)
    public function getGroups () {
        return array(
            array(
                'title'         => t('Features', 'kanext'),
                'description'   => '',
                'slug'          => 'features'
            ),

            array(
                'title'         => t('Customization', 'kanext'),
                'description'   => '',
                'slug'          => 'customization'
            )
        );
    }

    // The default configuration
    public function getOptions () {
        return array(
            // features group
            'kanext_use_kanboard_fixes' => array(
                'title'         => t('Kanboard general fixes', 'kanext'),
                'description'   => '',
                'default_value' => 1,
                'value'         => $this->configModel->get('kanext_use_kanboard_fixes'),
                'type'          => 'checkbox',
                'group'         => 'features',
                'options'       => array()
            ),
            'kanext_feature_toggle_sidebar' => array(
                'title'         => t('Toggle sidebar', 'kanext'),
                'description'   => '',
                'default_value' => 1,
                'value'         => $this->configModel->get('kanext_feature_toggle_sidebar'),
                'type'          => 'checkbox',
                'group'         => 'features',
                'options'       => array()
            ),
            'kanext_feature_dashboard_activity' => array(
                'title'         => t('Activity on dashboard', 'kanext'),
                'description'   => '',
                'default_value' => 1,
                'value'         => $this->configModel->get('kanext_feature_dashboard_activity'),
                'type'          => 'checkbox',
                'group'         => 'features',
                'options'       => array()
            ),

            // customization group
            'kanext_custom_css' => array(
                'title'         => t('Custom CSS', 'kanext'),
                'description'   => '',
                'default_value' => '',
                'value'         => $this->configModel->get('kanext_custom_css', ''),
                'type'          => 'textarea',
                'group'         => 'customization',
                'options'       => array()
            ),
            'kanext_feature_fixes_for_theme_plugins' => array(
                'title'         => t('Fixes for theme plugins', 'kanext'),
                'description'   => t('Kanext might include some CSS or Javascript fixes for certain themes (e.g. Geenwing or the default template)', 'kanext'),
                'default_value' => 1,
                'value'         => $this->configModel->get('kanext_feature_fixes_for_theme_plugins'),
                'type'          => 'checkbox',
                'group'         => 'customization',
                'options'       => array()
            ),
        );
    }

    // Only get the values from the options
    public function getValues () {
        $options = $this->getOptions();
        $values = array();

        foreach ($options as $option_name => $option) {
            $values[$option_name] = $option['value'];
        }

        return $values;
    }

    // Only get the options of type field
    public function getCheckboxes () {
        $options = $this->getOptions();
        $checkboxes = array();

        foreach ($options as $option_name => $option) {
            if ($option['type'] === 'checkbox') {
                $checkboxes[] = $option_name;
            }
        }

        return $checkboxes;
    }

    /**
     * Get a value for a configuration variable
     * @param  string $name Name of the variables
     * @return mixed        Content of the variable
     */
    public function get ($name=null)
    {
        return $this->configModel->get($name);
    }
}
