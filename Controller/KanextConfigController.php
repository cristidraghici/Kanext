<?php
namespace Kanboard\Plugin\Kanext\Controller;

use \Kanboard\Controller\ConfigController;

class KanextConfigController extends ConfigController
{
    public function show()
    {
        $this->response->html($this->helper->layout->config('Kanext:kanext_configuration/configuration-page', array(
            'title' => t('Settings') . ' &gt; Kanext',

            'groups'    => $this->configHelper->getGroups(),
            'options'   => $this->configHelper->getOptions(),
            'values'    => $this->configHelper->getValues()
        )));
    }

    public function save()
    {
        // Get the values from the from
        $values =  $this->request->getValues();

        // Set the disabled checkboxes values
        foreach ($this->configHelper->getCheckboxes() as $checkbox) {
            if (!$values[$checkbox]) {
                $values[$checkbox] = 0;
            }
        }

        if ($this->configModel->save($values)) {
            $this->flash->success(t('Settings saved successfully.'));
        } else {
            $this->flash->failure(t('Unable to save your settings.'));
        }

        $this->response->redirect($this->helper->url->to('KanextConfigController', 'show', array('plugin' => 'Kanext')));
    }
}
