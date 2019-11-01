<?php
    // This needs to change when more options will be available
    $show_activity = $this->app->configHelper->get('kanext_dashboard_activity_type') == 'kanext_dashboard_activity_general';
?>
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

<div class="<?php echo $show_activity ? 'kanext-dashboard-container' : ''; ?>">
    <div class="<?php echo $show_activity ? 'kanext-dashboard-container-center' : ''; ?>">
        <?php if (empty($overview_paginator)): ?>
            <p class="alert"><?= t('There is nothing assigned to you.') ?></p>
        <?php else: ?>
            <?php foreach ($overview_paginator as $result): ?>
                <?php if (! $result['paginator']->isEmpty()): ?>
                    <div class="page-header">
                        <h2 id="project-tasks-<?= $result['project_id'] ?>"><?= $this->url->link($this->text->e($result['project_name']), 'BoardViewController', 'show', array('project_id' => $result['project_id'])) ?></h2>
                    </div>

                    <div class="table-list">
                        <?= $this->render('task_list/header', array(
                            'paginator' => $result['paginator'],
                        )) ?>

                        <?php foreach ($result['paginator']->getCollection() as $task): ?>
                            <div class="table-list-row color-<?= $task['color_id'] ?>">
                                <?= $this->render('task_list/task_title', array(
                                    'task' => $task,
                                    'redirect' => 'dashboard',
                                )) ?>

                                <?= $this->render('task_list/task_details', array(
                                    'task' => $task,
                                )) ?>

                                <?= $this->render('task_list/task_avatars', array(
                                    'task' => $task,
                                )) ?>

                                <?= $this->render('task_list/task_icons', array(
                                    'task' => $task,
                                )) ?>

                                <?= $this->render('task_list/task_subtasks', array(
                                    'task'    => $task,
                                    'user_id' => $user['id'],
                                )) ?>

                                <?= $this->hook->render('template:dashboard:task:footer', array('task' => $task)) ?>
                            </div>
                        <?php endforeach ?>
                    </div>

                    <?= $result['paginator'] ?>
                <?php endif ?>
            <?php endforeach ?>
        <?php endif ?>

        <?= $this->hook->render('template:dashboard:show', array('user' => $user)) ?>
    </div>

    <?php if ($show_activity): ?>
        <div class="kanext-dashboard-container-right">
            <div class="page-header">
                <h2><?php echo t('Activity overview'); ?></h2>
            </div>
            <div class="dashboard-activity">
                <?php
                    $projects = [];
                    $max_activity_items = 15;
                    foreach ($project_paginator->getCollection() as $project) {
                        $projects[] = $project['id'];
                    }
                    $events = $this->helper->projectActivity->getProjectsEvents($projects, $max_activity_items);

                    echo $this->render('kanext:event/dashevents', array('events' => $events));
                ?>
            </div>
        </div>
    <?php endif; ?>

</div>
