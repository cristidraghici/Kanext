<?php
namespace Kanboard\Plugin\Kanext\Helper;

use Kanboard\Core\Base;

class ConfigHelper extends Base
{
    // The groups for the configuration options (just organizational)
    public function getGroups () {
        $all_groups = array(
            array(
                'title'         => t('Features', 'kanext'),
                'description'   => '',
                'slug'          => 'features'
            ),

            array(
                'title'         => t('Customization', 'kanext'),
                'description'   => '',
                'slug'          => 'customization'
            ),

            // Optional settings
            array(
                'title'         => t('Activity on dashboard', 'kanext'),
                'description'   => '',
                'slug'          => 'dashboard_activity'
            )
        );

        $groups_with_options = array();
        foreach ($all_groups as $group) {
            if ($this->hasOptions($group['slug'])) {
                $groups_with_options[] = $group;
            }
        }

        return $groups_with_options;
    }

    // The default configuration
    public function getOptions () {
        $all_options = array(
            // features group
            'kanext_use_kanboard_fixes' => array(
                'title'         => t('Kanboard general fixes', 'kanext'),
                'description'   => '',
                'default_value' => '1',
                'value'         => $this->configModel->get('kanext_use_kanboard_fixes'),
                'type'          => 'checkbox',
                'group'         => 'features',
                'options'       => array(),
                'enabled'       => true
            ),
            'kanext_feature_toggle_sidebar' => array(
                'title'         => t('Toggle sidebar', 'kanext'),
                'description'   => '',
                'default_value' => '1',
                'value'         => $this->configModel->get('kanext_feature_toggle_sidebar'),
                'type'          => 'checkbox',
                'group'         => 'features',
                'options'       => array(),
                'enabled'       => true
            ),
            'kanext_feature_dashboard_activity' => array(
                'title'         => t('Activity on dashboard', 'kanext'),
                'description'   => '',
                'default_value' => '1',
                'value'         => $this->configModel->get('kanext_feature_dashboard_activity'),
                'type'          => 'checkbox',
                'group'         => 'features',
                'options'       => array(),
                'enabled'       => true
            ),

            // customization group
            'kanext_custom_css' => array(
                'title'         => t('Custom CSS', 'kanext'),
                'description'   => '',
                'default_value' => '',
                'value'         => $this->configModel->get('kanext_custom_css', ''),
                'type'          => 'textarea',
                'group'         => 'customization',
                'options'       => array(),
                'enabled'       => true
            ),
            'kanext_feature_fixes_for_theme_plugins' => array(
                'title'         => t('Fixes for theme plugins', 'kanext'),
                'description'   => '',
                'default_value' => '1',
                'value'         => $this->configModel->get('kanext_feature_fixes_for_theme_plugins'),
                'type'          => 'checkbox',
                'group'         => 'customization',
                'options'       => array(),
                'enabled'       => true
            ),

            // Activity on dashboard
            'kanext_feature_dashboard_activity_activity_limit' => array(
                'title'         => t('How many items to show in the feeds', 'kanext'),
                'description'   => t('A very high number will break the interface and also might affect your server\'s resources. Recommended value: 15 items', 'kanext'),
                'default_value' => 20,
                'value'         => $this->configModel->get('kanext_feature_dashboard_activity_activity_limit'),
                'type'          => 'number',
                'group'         => 'dashboard_activity',
                'options'       => array(),
                'enabled'       => $this->configModel->get('kanext_feature_dashboard_activity') === "1"
            ),
            'kanext_feature_dashboard_activity_show_comments_separately' => array(
                'title'         => t('Show comments separately', 'kanext'),
                'description'   => '',
                'default_value' => '1',
                'value'         => $this->configModel->get('kanext_feature_dashboard_activity_show_comments_separately'),
                'type'          => 'checkbox',
                'group'         => 'dashboard_activity',
                'options'       => array(),
                'enabled'       => $this->configModel->get('kanext_feature_dashboard_activity') === "1"
            ),
            'kanext_feature_dashboard_activity_show_tasks_of_loggedin_user' => array(
                'title'         => t('Show the tasks of the currently logged in user', 'kanext'),
                'description'   => '',
                'default_value' => '1',
                'value'         => $this->configModel->get('kanext_feature_dashboard_activity_show_tasks_of_loggedin_user'),
                'type'          => 'checkbox',
                'group'         => 'dashboard_activity',
                'options'       => array(),
                'enabled'       => $this->configModel->get('kanext_feature_dashboard_activity') === "1"
            ),
        );

        $active_options = array();
        foreach ($all_options as $name=>$meta) {
            if ($meta['enabled'] === true) {
                $active_options[$name] = $meta;
            }
        }

        return $active_options;

    }

    private function hasOptions ($group_slug) {
        $options = $this->getOptions();

        foreach ($options as $option) {
            if ($option['group'] === $group_slug) {
                return true;
            }
        }

        return false;
    }

    // Only get the values from the options
    public function getValues () {
        $options = $this->getOptions();
        $values = array();

        foreach ($options as $option_name => $option) {
            $values[$option_name] = $option['value'] ?: $option['default_value'];
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
