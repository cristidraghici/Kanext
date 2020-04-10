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

                        <div class="kanext-task-meta table-list-details">
                            <?= $this->text->e($task['project_name']) ?> &gt;
                            <?= $this->text->e($task['swimlane_name']) ?> &gt;
                            <?= $this->text->e($task['column_name']) ?>

                            <?php if (! empty($task['category_id'])): ?>
                                <span class="table-list-category <?= $task['category_color_id'] ? "color-{$task['category_color_id']}" : '' ?>">
                                    <?php if ($this->user->hasProjectAccess('TaskModificationController', 'edit', $task['project_id'])): ?>
                                        <?= $this->url->link(
                                            $this->text->e($task['category_name']),
                                            'TaskModificationController',
                                            'edit',
                                            array('task_id' => $task['id'], 'project_id' => $task['project_id']),
                                            false,
                                            'js-modal-medium' . (! empty($task['category_description']) ? ' tooltip' : ''),
                                            t('Change category')
                                        ) ?>
                                        <?php if (! empty($task['category_description'])): ?>
                                            <?= $this->app->tooltipMarkdown($task['category_description']) ?>
                                        <?php endif ?>
                                    <?php else: ?>
                                        <?= $this->text->e($task['category_name']) ?>
                                    <?php endif ?>
                                </span>
                            <?php endif ?>

                            <div class="task-list-avatars">
                                <span
                                    <?php if ($this->user->hasProjectAccess('TaskModificationController', 'edit', $task['project_id'])): ?>
                                    class="task-board-change-assignee"
                                    data-url="<?= $this->url->href('TaskModificationController', 'edit', array('task_id' => $task['id'], 'project_id' => $task['project_id'])) ?>">
                                <?php else: ?>
                                    class="task-board-assignee">
                                <?php endif ?><span class="task-avatar-assignee"><?= $this->text->e($task['assignee_name'] ?: $task['assignee_username']) ?></span>
                                </span>
                            </div>

                            <?php foreach ($task['tags'] as $tag): ?>
                                <span class="table-list-category task-list-tag <?= $tag['color_id'] ? "color-{$tag['color_id']}" : '' ?>">
                                    <?= $this->text->e($tag['name']) ?>
                                </span>
                            <?php endforeach ?>
                        </div>

                        <?= $this->hook->render('template:dashboard:task:footer', array('task' => $task)) ?>
                    </div>
                <?php endforeach ?>
            </div>

            <div class="kanext_dashboard-add-new-task">
                <small>
                    <?php if ($this->projectRole->canCreateTaskInColumn($result['project_id'], $column['id'])): ?>

                        <?= $this->helper->modal->large(
                            'plus',
                            t('Add a new task in ') . $this->text->e($result['project_name']),
                            'TaskCreationController',
                            'show', array(
                                'project_id'  => $result['project_id'],
                                'column_id'   => null,
                                'swimlane_id' => null,
                            )
                        ); ?>

                    <?php endif ?>
                </small>
            </div>

            <?php if ($this->app->configHelper->get('kanext_feature_kanext_dashboard_show_bar_chart_for_project') === "1"): ?>
            <div class="c3_project_stats" id="c3_project_stats_<?= $result['project_id'] ?>" data-stats='<?= $this->model->kanextDashboardModel->getBarChartProjectStats($result['project_id']); ?>'></div>
            <?php endif; ?>


            <?= $result['paginator'] ?>
        <?php endif ?>
    <?php endforeach ?>
<?php endif ?>

<?= $this->hook->render('template:dashboard:show', array('user' => $user)) ?>
