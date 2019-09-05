<section id="main">
    <div class="page-header">
        <ul>
            <li>
                <?= $this->url->icon('folder', t('Project management'), 'ProjectListController', 'show') ?>
            </li>

<!--
            <?php // if ($this->user->hasAccess('Bigboard', 'index')):?>
              <li>
                  <?= $this->url->icon('fa fa-th fa-fw', t('Bigboard'), 'Bigboard', 'index', ['plugin' => 'Bigboard']) ?>
              </li>
            <?php // endif;?>
-->

            <?php if ($this->user->hasAccess('ProjectCreationController', 'create')): ?>
                <li>
                    <?= $this->modal->medium('plus', t('New project'), 'ProjectCreationController', 'create') ?>
                </li>
            <?php endif ?>
            <?php if ($this->app->config('disable_private_project', 0) == 0): ?>
                <li>
                    <?= $this->modal->medium('lock', t('New private project'), 'ProjectCreationController', 'createPrivate') ?>
                </li>
            <?php endif ?>
        </ul>
    </div>

    <section class="sidebar-container" id="dashboard">
        <?= $this->render($sidebar_template, array('user' => $user)) ?>

        <div class="sidebar-content">
            <?= $content_for_sublayout ?>
        </div>
    </section>
</section>
