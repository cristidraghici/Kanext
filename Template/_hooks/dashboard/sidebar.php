<br />

<ul class="dashboard-sidebar-extras">
    <li>
        <?= $this->url->link(t('My activity stream'), 'ActivityController', 'user', array(), false, 'js-modal-medium', t('My activity stream')); ?>
    </li>

    <?php if ($this->user->hasAccess('UserListController', 'show')): ?>
        <li>
            <?= $this->url->link(t('Settings'), 'ConfigController', 'index') ?>
        </li>
    <?php endif ?>
</ul>
