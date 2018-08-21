<div class="sidebar">
    <h2 class="sidebar-title">Menu</h2>
    <ul>
        <li <?= $this->app->checkMenuSelection('DashboardController', 'show') ?>>
            <?= $this->url->link(t('Overview'), 'DashboardController', 'show', array('user_id' => $user['id'])) ?>
        </li>
        <li <?= $this->app->checkMenuSelection('DashboardController', 'projects') ?>>
            <?= $this->url->link(t('My projects'), 'DashboardController', 'projects', array('user_id' => $user['id'])) ?>
        </li>
        <li <?= $this->app->checkMenuSelection('DashboardController', 'tasks') ?>>
            <?= $this->url->link(t('My tasks'), 'DashboardController', 'tasks', array('user_id' => $user['id'])) ?>
        </li>
        <li <?= $this->app->checkMenuSelection('DashboardController', 'subtasks') ?>>
            <?= $this->url->link(t('My subtasks'), 'DashboardController', 'subtasks', array('user_id' => $user['id'])) ?>
        </li>
    </ul>

    <h2 class="sidebar-title">Extras</h2>
    <ul class="dashboard-sidebar-extras">
        <?= $this->hook->render('template:dashboard:sidebar', array('user' => $user)) ?>
        <li>
            <?= $this->modal->medium('dashboard', t('My activity stream'), 'ActivityController', 'user') ?>
        </li>
        <?= $this->hook->render('template:dashboard:page-header:menu', array('user' => $user)) ?>

        <?php if ($this->user->hasAccess('UserListController', 'show')): ?>
            <li>
                <?= $this->url->icon('cog', t('Settings'), 'ConfigController', 'index') ?>
            </li>
        <?php endif ?>
    </ul>
</div>
