<div class="filter-box margin-bottom">
    <form method="get" action="<?= $this->url->dir() ?>" class="search">
        <?= $this->form->hidden('controller', array('controller' => 'SearchController')) ?>
        <?= $this->form->hidden('action', array('action' => 'index')) ?>

        <div class="input-addon">
            <?= $this->form->text('search', array(), array(), array('placeholder="'.t('Search').'"'), 'input-addon-field') ?>
            <div class="input-addon-item">
                <?= $this->render('app/filters_helper') ?>
            </div>
        </div>
    </form>
</div>

<div class="kanext_dashboard">
    <?php if ($this->app->configHelper->get('kanext_feature_kanext_dashboard_show_tasks_of_loggedin_user') === "1"): ?>
    <div class="kanext_dashboard-column kanext_dashboard-column--right-padding kanext_dashboard-column kanext_dashboard-column--double-size">
        <?= $this->render('kanext:kanext_dashboard/dashboard/overview_paginator', array('overview_paginator' => $overview_paginator)) ?>
    </div>
    <?php endif; ?>

    <?php if ($this->app->configHelper->get('kanext_feature_kanext_dashboard_show_comments_separately') === "1"): ?>
    <div class="kanext_dashboard-column kanext_dashboard-column--right-padding">
        <?= $this->render('kanext:kanext_dashboard/dashboard/overview_comments') ?>
    </div>
    <?php endif; ?>

    <div class="kanext_dashboard-column">
        <?= $this->render('kanext:kanext_dashboard/dashboard/overview_activity') ?>
    </div>
</div>
