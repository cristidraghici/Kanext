<!-- task row -->
<tr class="board-swimlane board-swimlane-tasks-<?php echo $swimlane['id']; ?><?php echo $swimlane['task_limit'] && $swimlane['nb_tasks'] > $swimlane['task_limit'] ? ' board-task-list-limit' : ''; ?>">
    <?php foreach ($swimlane['columns'] as $column) { ?>
        <td class="
            board-column-<?php echo $column['id']; ?>
            <?php echo $column['task_limit'] > 0 && $column['column_nb_open_tasks'] > $column['task_limit'] ? 'board-task-list-limit' : ''; ?>
            "
        >

            <!-- tasks list -->

           <?php $kanext_feature_limit_tasks = $this->app->configHelper->get('kanext_feature_limit_tasks'); ?>
           <?php $kanext_feature_limit_tasks_limit = (int) $this->app->configHelper->get('kanext_feature_limit_tasks_limit'); ?>
           <?php $kanext_feature_limit_tasks_show_more = false; ?>

           <div
                class="board-task-list board-column-expanded <?php echo $this->projectRole->isSortableColumn($column['project_id'], $column['id']) ? 'sortable-column' : ''; ?>"
                data-column-id="<?php echo $column['id']; ?>"
                data-swimlane-id="<?php echo $swimlane['id']; ?>"
                data-task-limit="<?php echo $column['task_limit']; ?>">

                <?php $count = 0; ?>
                <?php foreach ($column['tasks'] as $task) { ?>
                <?php
                // Stop if the maximum task to show is reached
                if ($kanext_feature_limit_tasks && $count >= $kanext_feature_limit_tasks_limit) {
                    $kanext_feature_limit_tasks_show_more = true;

                    break;
                }
                    ?>
                    <?php echo $this->render($not_editable ? 'board/task_public' : 'board/task_private', [
                        'project' => $project,
                        'task' => $task,
                        'board_highlight_period' => $board_highlight_period,
                        'not_editable' => $not_editable,
                    ]); ?>
                <?php ++$count;
                } ?>

                <?php if (true === $kanext_feature_limit_tasks_show_more) { ?>
                <div class="kanext_limit_show_more_button">
                    <a
                        href="<?php echo $this->helper->url->href('KanextTaskController', 'allTasksInColumn', [
                            'project' => $project['id'],
                            'column' => $column['id'],
                            'swimlane' => $swimlane['id'],
                            'plugin' => 'kanext',
                        ], '', 'kanext'); ?>"
                        data-project-id="<?php echo $project['id']; ?>"
                        data-column-id="<?php echo $column['id']; ?>"
                        data-swimlane-id="<?php echo $swimlane['id']; ?>"
                    ><?php echo t('Show more', 'kanext'); ?> (<?php echo count($column['tasks']) - $kanext_feature_limit_tasks_limit; ?>)</a>
                </div>
                <?php } ?>
            </div>

            <!-- column in collapsed mode (rotated text) -->
            <div class="board-column-collapsed board-task-list sortable-column"
                data-column-id="<?php echo $column['id']; ?>"
                data-swimlane-id="<?php echo $swimlane['id']; ?>"
                data-task-limit="<?php echo $column['task_limit']; ?>">
                <!-- Added for greenwing and as a general fix -->
                <small class="board-column-header-task-count" title="<?php echo t('Show this column'); ?>">
                    <span id="task-number-column-<?php echo $column['id']; ?>"><?php echo $column['nb_tasks']; ?></span>
                </small>
                <div class="board-rotation-wrapper">
                    <div class="board-column-title board-rotation board-toggle-column-view" data-column-id="<?php echo $column['id']; ?>" title="<?php echo t('Show this column'); ?>">
                        <i class="fa fa-plus-square" title="<?php echo $this->text->e($column['title']); ?>"></i> <?php echo $this->text->e($column['title']); ?>
                    </div>
                </div>
            </div>
        </td>
    <?php } ?>
</tr>
