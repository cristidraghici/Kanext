<?php
namespace Kanboard\Plugin\Kanext\Helper;

use Kanboard\Core\Base;

use Kanboard\Plugin\Kanext\Helper\ConfigHelper;

class OverwriteHelper extends Base
{
    public function loadTemplates()
    {
        #
        # Layout
        #
        // Add additional CSS-File in Header and change the favicon or apple-touch-icons
        $this->template->hook->attach('template:layout:head', 'kanext:layout/header-head');

        // Change the login-Page
        if ($this->configHelper->get('login-logo') !== null) {
            $this->template->hook->attach('template:auth:login-form:before', 'kanext:layout/login-top');
        }
        if ($this->configHelper->get('login-link') !== null) {
            $this->template->hook->attach('template:auth:login-form:after', 'kanext:layout/login-bottom');
        }

        // Change the Header for add Logo
        if ($this->configHelper->get('logo') !== null) {
            $this->template->setTemplateOverride('header/title', 'kanext:layout/header-title');
        }

        // Load config styling
        if ($this->configHelper->get('disable_theme_styling') !== true && $this->configHelper->get('theme') !== null) {
            $this->hook->on('template:layout:css', array('template' => 'plugins/Kanext/Css/minified/' . $this->configHelper->get('theme') . '.css'));
        }
        if ($this->configHelper->get('disable_skin_styling') !== true && $this->configHelper->get('skin') !== null) {
            $this->hook->on('template:layout:css', array('template' => 'plugins/Kanext/Skins/' . $this->configHelper->get('skin') . '.css'));
        }

        if ($this->configHelper->get('disable_kanext_templating') !== true) {
            #
            # Dashboard
            #
            $this->template->setTemplateOverride('dashboard/layout', 'kanext:dashboard/layout');
            $this->template->setTemplateOverride('dashboard/sidebar', 'kanext:dashboard/sidebar');
            $this->template->setTemplateOverride('dashboard/overview', 'kanext:dashboard/overview');
            $this->template->setTemplateOverride('dashboard/projects', 'kanext:dashboard/projects');

            #
            # Project
            #
            $this->template->hook->attach('template:project:dropdown', 'kanext:project/dropdown');

            #
            # Task list
            #
            $this->template->setTemplateOverride('task_list/task_title', 'kanext:task_list/task_title');
            $this->template->setTemplateOverride('task_list/task_details', 'kanext:task_list/task_details');
        }
    }
}
