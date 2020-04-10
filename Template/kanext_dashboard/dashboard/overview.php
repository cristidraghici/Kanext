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
    <?php
        $show_main_column =
            $this->app->configHelper->get('kanext_feature_kanext_dashboard_show_tasks_of_loggedin_user') === "1" ||
            $this->app->configHelper->get('kanext_feature_kanext_dashboard_show_projects_where_the_user_has_no_tasks') === "1";
    ?>

    <div class="kanext_dashboard-column kanext_dashboard-column--right-padding kanext_dashboard-column kanext_dashboard-column--double-size">
        <?php if ($this->app->configHelper->get('kanext_feature_kanext_dashboard_show_tasks_of_loggedin_user') === "1"): ?>
        <?= $this->render('kanext:kanext_dashboard/dashboard/overview_paginator', array('overview_paginator' => $overview_paginator)) ?>
        <?php endif; ?>

        <?php if ($this->app->configHelper->get('kanext_feature_kanext_dashboard_show_projects_where_the_user_has_no_tasks') === "1"): ?>
        <?= $this->render('kanext:kanext_dashboard/dashboard/overview_user_has_no_tasks') ?>
        <?php endif; ?>
    </div>

    <?php if ($this->app->configHelper->get('kanext_feature_kanext_dashboard_show_comments_separately') === "1"): ?>
    <div class="kanext_dashboard-column kanext_dashboard-column--right-padding">
        <?= $this->render('kanext:kanext_dashboard/dashboard/overview_comments') ?>
    </div>
    <?php endif; ?>

    <div class="kanext_dashboard-column">
        <?= $this->render('kanext:kanext_dashboard/dashboard/overview_activity') ?>
    </div>
</div>
