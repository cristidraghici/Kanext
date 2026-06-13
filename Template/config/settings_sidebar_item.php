<li <?= $this->app->checkMenuSelection('KanextController', 'show') ?>>
    <?= $this->url->link(t('Kanext settings'), 'KanextConfigController', 'show', ['plugin' => 'Kanext']) ?>
</li>
