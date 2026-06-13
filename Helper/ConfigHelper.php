<?php

namespace Kanboard\Plugin\Kanext\Helper;

use Kanboard\Core\Base;

class ConfigHelper extends Base
{
    // The groups for the configuration options (just organizational)
    public function getGroups()
    {
        $all_groups = [
            [
                'title' => t('Customization', 'kanext'),
                'description' => '',
                'slug' => 'customization',
            ],

            [
                'title' => t('Features', 'kanext'),
                'description' => '',
                'slug' => 'features',
            ],

            // Optional settings
            [
                'title' => t('Custom dashboard', 'kanext'),
                'description' => '',
                'slug' => 'kanext_dashboard',
            ],

            [
                'title' => t('Team conventions', 'kanext'),
                'description' => '',
                'slug' => 'team_conventions',
            ],

            [
                'title' => t('Limit number of tasks in a swimlane', 'kanext'),
                'description' => '',
                'slug' => 'kanext_limit_tasks',
            ],
        ];

        $groups_with_options = [];
        foreach ($all_groups as $group) {
            if ($this->hasOptions($group['slug'])) {
                $groups_with_options[] = $group;
            }
        }

        return $groups_with_options;
    }

    // The default configuration
    public function getOptions()
    {
        $all_options = [
            // customization group
            'kanext_custom_css' => [
                'title' => t('Custom CSS', 'kanext'),
                'description' => '',
                'default_value' => '',
                'type' => 'textarea',
                'group' => 'customization',
                'options' => [],
                'enabled' => true,
            ],
            'kanext_general_style_fixes' => [
                'title' => t('General style fixes', 'kanext'),
                'description' => t('Examples: improved resposivness, full width search, all CSS changes', 'kanext'),
                'default_value' => '1',
                'type' => 'checkbox',
                'group' => 'customization',
                'options' => [],
                'enabled' => true,
            ],
            'kanext_feature_fixes_for_theme_plugins' => [
                'title' => t('Fixes for theme plugins', 'kanext'),
                'description' => t('Kanext can provide small fixes for theme plugins you might use. For now, it only offers this feature for GreenWing', 'kanext'),
                'default_value' => '1',
                'type' => 'checkbox',
                'group' => 'customization',
                'options' => [],
                'enabled' => true,
            ],

            // features group
            'kanext_close_dropdown_on_second_click' => [
                'title' => t('Close dropdown on second click', 'kanext'),
                'description' => '',
                'default_value' => '1',
                'type' => 'checkbox',
                'group' => 'features',
                'options' => [],
                'enabled' => true,
            ],
            'kanext_close_modal_on_overlay_click' => [
                'title' => t('Close modal on overlay click', 'kanext'),
                'description' => '',
                'default_value' => '1',
                'type' => 'checkbox',
                'group' => 'features',
                'options' => [],
                'enabled' => true,
            ],
            'kanext_feature_toggle_sidebar' => [
                'title' => t('Toggle sidebar', 'kanext'),
                'description' => '',
                'default_value' => '1',
                'type' => 'checkbox',
                'group' => 'features',
                'options' => [],
                'enabled' => true,
            ],
            'kanext_feature_kanext_dashboard' => [
                'title' => t('Custom dashboard', 'kanext'),
                'description' => '',
                'default_value' => '1',
                'type' => 'checkbox',
                'group' => 'features',
                'options' => [],
                'enabled' => true, // Enabled by default, which is hardcoded in the condition check below
            ],

            /*
             * Currently, the task limitation is done only by limiting the number of displayed tasks in the tamplate file,
             * which was the easiest to override. The proper way is to change the controller/model.
             */
            'kanext_feature_limit_tasks' => [
                'title' => t('Limit number of tasks in a board', 'kanext'),
                'description' => '',
                'default_value' => '1',
                'type' => 'checkbox',
                'group' => 'features',
                'options' => [],
                'enabled' => true,
            ],

            // Custom dashboard options
            'kanext_feature_kanext_dashboard_project_limit' => [
                'title' => t('Amount of projects to show on the dashboard', 'kanext'),
                'description' => t('Set to 0 to show all active projects.', 'kanext'),
                'default_value' => 0,
                'type' => 'number',
                'group' => 'kanext_dashboard',
                'options' => [],
                'enabled' => '1' === $this->configModel->get('kanext_feature_kanext_dashboard', '1'),
            ],
            'kanext_feature_kanext_dashboard_project_order' => [
                'title' => t('Sorting order for projects on the dashboard', 'kanext'),
                'description' => '',
                'default_value' => 'name',
                'type' => 'select',
                'group' => 'kanext_dashboard',
                'options' => [
                    'name' => t('Project Name', 'kanext'),
                    'id' => t('Date created (ID)', 'kanext'),
                    'assigned_tasks' => t('Amount of assigned tasks', 'kanext'),
                ],
                'enabled' => '1' === $this->configModel->get('kanext_feature_kanext_dashboard', '1'),
            ],
            'kanext_feature_kanext_dashboard_project_order_direction' => [
                'title' => t('Sorting direction for projects on the dashboard', 'kanext'),
                'description' => '',
                'default_value' => 'ASC',
                'type' => 'select',
                'group' => 'kanext_dashboard',
                'options' => [
                    'ASC' => t('Ascending', 'kanext'),
                    'DESC' => t('Descending', 'kanext'),
                ],
                'enabled' => '1' === $this->configModel->get('kanext_feature_kanext_dashboard', '1'),
            ],
            'kanext_feature_kanext_dashboard_activity_limit' => [
                'title' => t('How many items to show in the feeds', 'kanext'),
                'description' => t('A very high number will break the interface and also might affect your server\'s resources. Recommended value: 15 items', 'kanext'),
                'default_value' => 20,
                'type' => 'number',
                'group' => 'kanext_dashboard',
                'options' => [],
                'enabled' => '1' === $this->configModel->get('kanext_feature_kanext_dashboard', '1'),
            ],
            'kanext_feature_kanext_dashboard_show_comments_separately' => [
                'title' => t('Show comments separately', 'kanext'),
                'description' => '',
                'default_value' => '1',
                'type' => 'checkbox',
                'group' => 'kanext_dashboard',
                'options' => [],
                'enabled' => '1' === $this->configModel->get('kanext_feature_kanext_dashboard', '1'),
            ],
            'kanext_feature_kanext_dashboard_show_tasks_of_loggedin_user' => [
                'title' => t('Show the tasks of the currently logged in user', 'kanext'),
                'description' => '',
                'default_value' => '1',
                'type' => 'checkbox',
                'group' => 'kanext_dashboard',
                'options' => [],
                'enabled' => '1' === $this->configModel->get('kanext_feature_kanext_dashboard', '1'),
            ],
            'kanext_feature_kanext_dashboard_show_bar_chart_for_project' => [
                'title' => t('Show a bar chart with the tasks in each column', 'kanext'),
                'description' => t('Under testing and development', 'kanext'),
                'default_value' => '0',
                'type' => 'checkbox',
                'group' => 'kanext_dashboard',
                'options' => [],
                'enabled' => '1' === $this->configModel->get('kanext_feature_kanext_dashboard', '1'),
            ],
            'kanext_feature_kanext_dashboard_show_projects_where_the_user_has_no_tasks' => [
                'title' => t('Show the projects where the user has not tasks', 'kanext'),
                'description' => t('Under testing and development', 'kanext'),
                'default_value' => '0',
                'type' => 'checkbox',
                'group' => 'kanext_dashboard',
                'options' => [],
                'enabled' => '1' === $this->configModel->get('kanext_feature_kanext_dashboard', '1'),
            ],
            'kanext_feature_team_conventions' => [
                'title' => t('Show team conventions', 'kanext'),
                'description' => t('Show a list of conventions all the users should be reminded of.', 'kanext'),
                'default_value' => '0',
                'type' => 'checkbox',
                'group' => 'kanext_dashboard',
                'options' => [],
                'enabled' => true,
            ],

            // Team conventions
            'kanext_feature_kanext_dashboard_team_conventions' => [
                'title' => '',
                'description' => '',
                'default_value' => '',
                'type' => 'textEditor',
                'group' => 'team_conventions',
                'options' => [],
                'enabled' => '1' === $this->configModel->get('kanext_feature_team_conventions', '1'),
            ],

            // Limited tasks
            'kanext_feature_limit_tasks_limit' => [
                'title' => t('How many items to show in the column of a swimlane', 'kanext'),
                'description' => t('A very high number leads to slow interface and big response files for the requests. Recommended value: 100 items', 'kanext'),
                'default_value' => 100,
                'type' => 'number',
                'group' => 'kanext_limit_tasks',
                'options' => [],
                'enabled' => '1' === $this->configModel->get('kanext_feature_limit_tasks', '1'),
            ],
        ];

        $active_options = [];
        foreach ($all_options as $name => $meta) {
            if (true === $meta['enabled']) {
                $active_options[$name] = $meta;
                $active_options[$name]['value'] = $this->configModel->get($name, $meta['default_value']);
            }
        }

        return $active_options;
    }

    private function hasOptions($group_slug)
    {
        $options = $this->memoryCache->proxy($this, 'getOptions');

        foreach ($options as $option) {
            if (isset($option['group']) && $option['group'] === $group_slug) {
                return true;
            }
        }

        return false;
    }

    // Only get the values from the options
    public function getValues()
    {
        $options = $this->memoryCache->proxy($this, 'getOptions');
        $values = [];

        foreach ($options as $option_name => $option) {
            $values[$option_name] = $option['value'] ?? null;
        }

        return $values;
    }

    // Only get the options of type field
    public function getCheckboxes()
    {
        $options = $this->memoryCache->proxy($this, 'getOptions');
        $checkboxes = [];

        foreach ($options as $option_name => $option) {
            if (isset($option['type']) && 'checkbox' === $option['type']) {
                $checkboxes[] = $option_name;
            }
        }

        return $checkboxes;
    }

    /**
     * Get a value for a configuration variable.
     *
     * @param string $name Name of the variables
     *
     * @return mixed Content of the variable
     */
    public function get($name = null)
    {
        $values = $this->memoryCache->proxy($this, 'getValues');

        return $values[$name] ?? null;
    }
}
