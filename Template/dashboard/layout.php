<section id="main">
    <div class="page-header">
        <ul>
            <?php if ($this->user->hasAccess('ProjectCreationController', 'create')) { ?>
                <li>
                    <?php echo $this->modal->medium('plus', t('New project'), 'ProjectCreationController', 'create'); ?>
                </li>
            <?php } ?>
            <?php if (0 == $this->app->config('disable_private_project', 0)) { ?>
                <li>
                    <?php echo $this->modal->medium('lock', t('New personal project'), 'ProjectCreationController', 'createPrivate'); ?>
                </li>
            <?php } ?>
            <li>
                <?php echo $this->url->icon('folder', t('Project management'), 'ProjectListController', 'show'); ?>
            </li>

            <?php echo $this->hook->render('template:dashboard:page-header:menu', ['user' => $user]); ?>
        </ul>
    </div>
    <section class="sidebar-container" id="dashboard">
        <?php echo $this->render($sidebar_template, ['user' => $user]); ?>
        <div class="sidebar-content">
            <?php echo $content_for_sublayout; ?>
        </div>
    </section>
</section>
