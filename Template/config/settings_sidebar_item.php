<li <?php echo $this->app->checkMenuSelection('KanextController', 'show'); ?>>
    <?php echo $this->url->link(t('Kanext settings'), 'KanextConfigController', 'show', ['plugin' => 'Kanext']); ?>
</li>
