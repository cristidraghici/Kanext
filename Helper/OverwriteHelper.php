<?php
namespace Kanboard\Plugin\Kanext\Helper;

use Kanboard\Core\Base;

use Kanboard\Plugin\Kanext\Helper\ConfigHelper;

class OverwriteHelper extends Base
{
    public function loadTemplates() {
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
        if ($this->configHelper->get('disable_styling') !== true) {
          if ($this->configHelper->get('theme') !== null) {
              $this->hook->on('template:layout:css', array('template' => 'plugins/Kanext/Css/' . $this->configHelper->get('theme') . '.css'));
          }
          if ($this->configHelper->get('css') !== null) {
              $this->hook->on('template:layout:css', array('template' => 'plugins/Kanext/Css/' . $this->configHelper->get('css') . '.css'));
          }
        }

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
    }
}
