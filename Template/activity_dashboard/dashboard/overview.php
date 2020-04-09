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

<div class="kanext-dashboard">
    <?php if ($this->app->configHelper->get('kanext_feature_dashboard_activity_show_tasks_of_loggedin_user') === "1"): ?>
    <div class="kanext-dashboard-column kanext-dashboard-column--right-padding kanext-dashboard-column kanext-dashboard-column--double-size">
        <?= $this->render('kanext:activity_dashboard/dashboard/overview_paginator', array('overview_paginator' => $overview_paginator)) ?>
    </div>
    <?php endif; ?>

    <?php if ($this->app->configHelper->get('kanext_feature_dashboard_activity_show_comments_separately') === "1"): ?>
    <div class="kanext-dashboard-column kanext-dashboard-column--right-padding">
        <?= $this->render('kanext:activity_dashboard/dashboard/overview_comments') ?>
    </div>
    <?php endif; ?>

    <div class="kanext-dashboard-column">
        <?= $this->render('kanext:activity_dashboard/dashboard/overview_activity') ?>
    </div>
</div>
