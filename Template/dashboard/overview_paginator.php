<?php if (empty($overview_paginator)) { ?>
    <div class="page-header">
        <h2><?php echo t('Tasks'); ?></h2>
    </div>
    <p class="alert"><?php echo t('Chill out, you\'ve done everything! ;)', 'kanext'); ?></p>
<?php } else { ?>
    <?php foreach ($overview_paginator as $result) { ?>
        <?php if (!$result['paginator']->isEmpty()) { ?>
            <div class="page-header">
                <h2 id="project-tasks-<?php echo $result['project_id']; ?>"><?php echo $this->url->link($this->text->e($result['project_name']), 'BoardViewController', 'show', ['project_id' => $result['project_id']]); ?></h2>
            </div>

            <div class="table-list">
                <?php echo $this->render('task_list/header', [
                    'paginator' => $result['paginator'],
                ]); ?>

                <?php foreach ($result['paginator']->getCollection() as $task) { ?>
                    <div class="table-list-row color-<?php echo $task['color_id']; ?>">
                        <?php echo $this->render('task_list/task_title', [
                            'task' => $task,
                            'redirect' => 'dashboard',
                        ]); ?>

                        <div class="kanext-task-meta table-list-details">
                            <?php echo $this->text->e($task['project_name']); ?> &gt;
                            <?php echo $this->text->e($task['swimlane_name']); ?> &gt;
                            <?php echo $this->text->e($task['column_name']); ?>

                            <?php if (!empty($task['category_id'])) { ?>
                                <span class="table-list-category <?php echo $task['category_color_id'] ? "color-{$task['category_color_id']}" : ''; ?>">
                                    <?php if ($this->user->hasProjectAccess('TaskModificationController', 'edit', $task['project_id'])) { ?>
                                        <?php echo $this->url->link(
                                            $this->text->e($task['category_name']),
                                            'TaskModificationController',
                                            'edit',
                                            ['task_id' => $task['id'], 'project_id' => $task['project_id']],
                                            false,
                                            'js-modal-medium' . (!empty($task['category_description']) ? ' tooltip' : ''),
                                            t('Change category')
                                        ); ?>
                                        <?php if (!empty($task['category_description'])) { ?>
                                            <?php echo $this->app->tooltipMarkdown($task['category_description']); ?>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <?php echo $this->text->e($task['category_name']); ?>
                                    <?php } ?>
                                </span>
                            <?php } ?>

                            <div class="task-list-avatars">
                                <span
                                    <?php if ($this->user->hasProjectAccess('TaskModificationController', 'edit', $task['project_id'])) { ?>
                                    class="task-board-change-assignee"
                                    data-url="<?php echo $this->url->href('TaskModificationController', 'edit', ['task_id' => $task['id'], 'project_id' => $task['project_id']]); ?>">
                                <?php } else { ?>
                                    class="task-board-assignee">
                                <?php } ?><span class="task-avatar-assignee"><?php echo $this->text->e($task['assignee_name'] ?: $task['assignee_username']); ?></span>
                                </span>
                            </div>

                            <?php foreach ($task['tags'] as $tag) { ?>
                                <span class="table-list-category task-list-tag <?php echo $tag['color_id'] ? "color-{$tag['color_id']}" : ''; ?>">
                                    <?php echo $this->text->e($tag['name']); ?>
                                </span>
                            <?php } ?>
                        </div>

                        <?php echo $this->hook->render('template:dashboard:task:footer', ['task' => $task]); ?>
                    </div>
                <?php } ?>
            </div>

            <div class="kanext_dashboard-add-new-task">
                <small>
                    <?php if ($this->projectRole->canCreateTaskInColumn($result['project_id'], isset($column) ? $column['id'] : null)) { ?>

                        <?php echo $this->helper->modal->large(
                            'plus',
                            t('Add a new task in ') . $this->text->e($result['project_name']),
                            'TaskCreationController',
                            'show', [
                                'project_id' => $result['project_id'],
                                'column_id' => null,
                                'swimlane_id' => null,
                            ]
                        ); ?>

                    <?php } ?>
                </small>
            </div>

            <?php if ('1' === $this->app->configHelper->get('kanext_feature_kanext_dashboard_show_bar_chart_for_project')) { ?>
            <div class="c3_project_stats" id="c3_project_stats_<?php echo $result['project_id']; ?>" data-stats='<?php echo $this->model->kanextDashboardModel->getBarChartProjectStats($result['project_id']); ?>'></div>
            <?php } ?>


            <?php echo $result['paginator']; ?>
        <?php } ?>
    <?php } ?>
<?php } ?>

<?php echo $this->hook->render('template:dashboard:show', ['user' => isset($user) ? $user : null]); ?>
