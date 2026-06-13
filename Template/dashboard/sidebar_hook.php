<br />

<ul class="dashboard-sidebar-extras">
    <li>
        <?php echo $this->url->link(t('My activity stream'), 'ActivityController', 'user', [], false, 'js-modal-medium', t('My activity stream')); ?>
    </li>

    <?php if ($this->user->hasAccess('UserListController', 'show')) { ?>
        <li>
            <?php echo $this->url->link(t('Kanext settings'), 'KanextConfigController', 'show', ['plugin' => 'Kanext']); ?>
        </li>
    <?php } ?>
</ul>
