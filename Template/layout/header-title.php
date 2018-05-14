<h1>
    <span class="logo">
        <?php if (strlen($this->app->configHelper->get('logo')) > 0): ?>
          <?= $this->url->link('<img src="'.$this->url->dir().'plugins/Kanext/Img/'.$this->app->configHelper->get('logo').'" class="logo-img" />', 'DashboardController', 'show', array(), false, '', t('Dashboard')) ?>
        <?php else: ?>
          <?= $this->url->link('K<span>B</span>', 'DashboardController', 'show', array(), false, '', t('Dashboard')) ?>
        <?php endif; ?>
    </span>
    <span class="title">
        <?php if (! empty($project) && ! empty($task)): ?>
            <?= $this->url->link($this->text->e($project['name']), 'BoardViewController', 'show', array('project_id' => $project['id'])) ?>
        <?php else: ?>
            <?= $this->text->e($title) ?>
        <?php endif ?>
    </span>
    <?php if (! empty($description)): ?>
        <small class="tooltip" title="<?= $this->text->markdownAttribute($description) ?>">
            <i class="fa fa-info-circle"></i>
        </small>
    <?php endif ?>
</h1>
