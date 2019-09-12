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
        $this->response->html($this->helper->layout->config('Kanext:config/config', array(
            'title' => t('Settings').' &gt; '.t('Kanext settings'),
        )));
    }

    public function save()
    {
        $values =  $this->request->getValues();

        // if ($this->configModel->save($values)) {
            $this->flash->success(t('Settings saved successfully.'));
        // } else {
        //     $this->flash->failure(t('Unable to save your settings.'));
        // }

        $this->response->redirect($this->helper->url->to('KanextConfigController', 'show', array('plugin' => 'Kanext')));
    }
}
