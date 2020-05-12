<?php
namespace Kanboard\Plugin\Kanext\Helper;

use Kanboard\Core\Base;

class ConfigHelper extends Base
{
    // The groups for the configuration options (just organizational)
    public function getGroups () {
        $all_groups = array(
            array(
                'title'         => t('Customization', 'kanext'),
                'description'   => '',
                'slug'          => 'customization'
            ),

            array(
                'title'         => t('Features', 'kanext'),
                'description'   => '',
                'slug'          => 'features'
            ),

            // Optional settings
            array(
                'title'         => t('Custom dashboard', 'kanext'),
                'description'   => '',
                'slug'          => 'kanext_dashboard'
            ),

            array(
                'title'         => t('Team conventions', 'kanext'),
                'description'   => '',
                'slug'          => 'team_conventions'
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
            // customization group
            'kanext_custom_css' => array(
                'title'         => t('Custom CSS', 'kanext'),
                'description'   => '',
                'default_value' => '',
                'type'          => 'textarea',
                'group'         => 'customization',
                'options'       => array(),
                'enabled'       => true
            ),
            'kanext_general_style_fixes' => array(
                'title'         => t('General style fixes', 'kanext'),
                'description'   => t('Examples: improved resposivness, full width search, all CSS changes', 'kanext'),
                'default_value' => '1',
                'type'          => 'checkbox',
                'group'         => 'customization',
                'options'       => array(),
                'enabled'       => true
            ),
            'kanext_feature_fixes_for_theme_plugins' => array(
                'title'         => t('Fixes for theme plugins', 'kanext'),
                'description'   => t('Kanext can provide small fixes for theme plugins you might use. For now, it only offers this feature for GreenWing', 'kanext'),
                'default_value' => '1',
                'type'          => 'checkbox',
                'group'         => 'customization',
                'options'       => array(),
                'enabled'       => true
            ),

            // features group
            'kanext_close_dropdown_on_second_click' => array(
                'title'         => t('Close dropdown on second click', 'kanext'),
                'description'   => '',
                'default_value' => '1',
                'type'          => 'checkbox',
                'group'         => 'features',
                'options'       => array(),
                'enabled'       => true
            ),
            'kanext_close_modal_on_overlay_click' => array(
                'title'         => t('Close modal on overlay click', 'kanext'),
                'description'   => '',
                'default_value' => '1',
                'type'          => 'checkbox',
                'group'         => 'features',
                'options'       => array(),
                'enabled'       => true
            ),
            'kanext_feature_toggle_sidebar' => array(
                'title'         => t('Toggle sidebar', 'kanext'),
                'description'   => '',
                'default_value' => '1',
                'type'          => 'checkbox',
                'group'         => 'features',
                'options'       => array(),
                'enabled'       => true
            ),
            'kanext_feature_kanext_dashboard' => array(
                'title'         => t('Custom dashboard', 'kanext'),
                'description'   => '',
                'default_value' => '1',
                'type'          => 'checkbox',
                'group'         => 'features',
                'options'       => array(),
                'enabled'       => true // Enabled by default, which is hardcoded in the condition check below
            ),

            // Custom dashboard options
            'kanext_feature_kanext_dashboard_activity_limit' => array(
                'title'         => t('How many items to show in the feeds', 'kanext'),
                'description'   => t('A very high number will break the interface and also might affect your server\'s resources. Recommended value: 15 items', 'kanext'),
                'default_value' => 20,
                'type'          => 'number',
                'group'         => 'kanext_dashboard',
                'options'       => array(),
                'enabled'       => $this->configModel->get('kanext_feature_kanext_dashboard', '1') === '1'
            ),
            'kanext_feature_kanext_dashboard_show_comments_separately' => array(
                'title'         => t('Show comments separately', 'kanext'),
                'description'   => '',
                'default_value' => '1',
                'type'          => 'checkbox',
                'group'         => 'kanext_dashboard',
                'options'       => array(),
                'enabled'       => $this->configModel->get('kanext_feature_kanext_dashboard', '1') === '1'
            ),
            'kanext_feature_kanext_dashboard_show_tasks_of_loggedin_user' => array(
                'title'         => t('Show the tasks of the currently logged in user', 'kanext'),
                'description'   => '',
                'default_value' => '1',
                'type'          => 'checkbox',
                'group'         => 'kanext_dashboard',
                'options'       => array(),
                'enabled'       => $this->configModel->get('kanext_feature_kanext_dashboard', '1') === '1'
            ),
            'kanext_feature_kanext_dashboard_show_bar_chart_for_project' => array(
                'title'         => t('Show a bar chart with the tasks in each column', 'kanext'),
                'description'   => t('Under testing and development', 'kanext'),
                'default_value' => '0',
                'type'          => 'checkbox',
                'group'         => 'kanext_dashboard',
                'options'       => array(),
                'enabled'       => $this->configModel->get('kanext_feature_kanext_dashboard', '1') === '1'
            ),
            'kanext_feature_kanext_dashboard_show_projects_where_the_user_has_no_tasks' => array(
                'title'         => t('Show the projects where the user has not tasks', 'kanext'),
                'description'   => t('Under testing and development', 'kanext'),
                'default_value' => '0',
                'type'          => 'checkbox',
                'group'         => 'kanext_dashboard',
                'options'       => array(),
                'enabled'       => $this->configModel->get('kanext_feature_kanext_dashboard', '1') === '1'
            ),
            'kanext_feature_team_conventions' => array(
                'title'         => t('Show team conventions', 'kanext'),
                'description'   => t('Show a list of conventions all the users should be reminded of.', 'kanext'),
                'default_value' => '0',
                'type'          => 'checkbox',
                'group'         => 'kanext_dashboard',
                'options'       => array(),
                'enabled'       => true
            ),

            // Team conventions
            'kanext_feature_kanext_dashboard_team_conventions' => array(
                'title'         => '',
                'description'   => '',
                'default_value' => '',
                'type'          => 'textEditor',
                'group'         => 'team_conventions',
                'options'       => array(),
                'enabled'       => $this->configModel->get('kanext_feature_team_conventions', '1') === '1'
            ),
        );

        $active_options = array();
        foreach ($all_options as $name=>$meta) {
            if ($meta['enabled'] === true) {
                $active_options[$name] = $meta;
                $active_options[$name]['value'] = $this->configModel->get($name, $meta['default_value']);
            }
        }

        return $active_options;

    }

    private function hasOptions ($group_slug) {
        $options = $this->memoryCache->proxy($this, 'getOptions');

        foreach ($options as $option) {
            if ($option['group'] === $group_slug) {
                return true;
            }
        }

        return false;
    }

    // Only get the values from the options
    public function getValues () {
        $options = $this->memoryCache->proxy($this, 'getOptions');
        $values = array();

        foreach ($options as $option_name => $option) {
            $values[$option_name] = $option['value'];
        }

        return $values;
    }

    // Only get the options of type field
    public function getCheckboxes () {
        $options = $this->memoryCache->proxy($this, 'getOptions');
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
        $values = $this->memoryCache->proxy($this, 'getValues');

        return $values[$name];
    }
}
