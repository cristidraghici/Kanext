<?php

namespace Kanboard\Plugin\Kanext\Controller;

/**
 * Class KanextConfigController
 *
 * @package Kanboard\Plugin\Kanext\Controller
 */
class KanextConfigController extends \Kanboard\Controller\ConfigController
{
    public function show()
    {
        // Default configuration
        $values = array(
            'kanext_dashboard_activity_type' => $this->configModel->get('kanext_dashboard_activity_type', 'kanext_dashboard_activity_general'),
            'kanext_use_own_theme' => $this->configModel->get('kanext_use_own_theme'),
            'kanext_use_css_fixes' => $this->configModel->get('kanext_use_css_fixes'),
            'kanext_use_js_fixes' => $this->configModel->get('kanext_use_js_fixes'),
            'kanext_use_plugin_fixes' => $this->configModel->get('kanext_use_plugin_fixes'),
            'kanext_theme_from_submodules' => $this->configModel->get('kanext_theme_from_submodules', ''),
            'kanext_custom_css' => $this->configModel->get('kanext_custom_css', ''),
        );

        $this->response->html($this->helper->layout->config('Kanext:config/config', array(
            'title' => t('Settings').' &gt; '.t('Kanext settings'),
            'values' => $values
        )));
    }

    public function save()
    {
        $values =  $this->request->getValues();

        if (!$values['kanext_use_own_theme']) { $values['kanext_use_own_theme'] = 0; }
        if (!$values['kanext_use_css_fixes']) { $values['kanext_use_css_fixes'] = 0; }
        if (!$values['kanext_use_js_fixes']) { $values['kanext_use_js_fixes'] = 0; }
        if (!$values['kanext_use_plugin_fixes']) { $values['kanext_use_plugin_fixes'] = 0; }

        if ($this->configModel->save($values)) {
            $this->flash->success(t('Settings saved successfully.'));
        } else {
            $this->flash->failure(t('Unable to save your settings.'));
        }

        $this->response->redirect($this->helper->url->to('KanextConfigController', 'show', array('plugin' => 'Kanext')));
    }
}
