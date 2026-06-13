<div class="filter-box margin-bottom">
    <form method="get" action="<?php echo $this->url->dir(); ?>" class="search">
        <?php echo $this->form->hidden('controller', ['controller' => 'SearchController']); ?>
        <?php echo $this->form->hidden('action', ['action' => 'index']); ?>

        <div class="input-addon">
            <?php echo $this->form->text('search', [], [], ['placeholder="' . t('Search') . '"'], 'input-addon-field'); ?>
            <div class="input-addon-item">
                <?php echo $this->render('app/filters_helper'); ?>
            </div>
        </div>
    </form>
</div>

<div class="kanext_dashboard">
    <?php
        $show_main_column =
            '1' === $this->app->configHelper->get('kanext_feature_kanext_dashboard_show_tasks_of_loggedin_user')
            || '1' === $this->app->configHelper->get('kanext_feature_kanext_dashboard_show_projects_where_the_user_has_no_tasks');
    ?>

    <div class="kanext_dashboard-column kanext_dashboard-column--right-padding kanext_dashboard-column kanext_dashboard-column--double-size">
        <?php if ('1' === $this->app->configHelper->get('kanext_feature_kanext_dashboard_show_tasks_of_loggedin_user')) { ?>
        <?php echo $this->render('kanext:kanext_dashboard/dashboard/overview_paginator', ['overview_paginator' => $overview_paginator]); ?>
        <?php } ?>

        <?php if ('1' === $this->app->configHelper->get('kanext_feature_kanext_dashboard_show_projects_where_the_user_has_no_tasks')) { ?>
        <?php echo $this->render('kanext:kanext_dashboard/dashboard/overview_user_has_no_tasks'); ?>
        <?php } ?>

        <?php if ('1' === $this->app->configHelper->get('kanext_feature_team_conventions')) { ?>
        <div class="page-header">
            <h2><?php echo t('Team conventions', 'kanext'); ?></h2>
        </div>
        <div class="markdown">
            <?php echo $this->text->markdown($this->app->configHelper->get('kanext_feature_kanext_dashboard_team_conventions')); ?>
        </div>
        <?php } ?>
    </div>

    <?php if ('1' === $this->app->configHelper->get('kanext_feature_kanext_dashboard_show_comments_separately')) { ?>
    <div class="kanext_dashboard-column kanext_dashboard-column--right-padding">
        <?php echo $this->render('kanext:kanext_dashboard/dashboard/overview_comments'); ?>
    </div>
    <?php } ?>

    <div class="kanext_dashboard-column">
        <?php echo $this->render('kanext:kanext_dashboard/dashboard/overview_activity'); ?>
    </div>
</div>
