<?php // This template is extracted from the original `board/table_tasks.php` file ?>
<div
    class="board-task-list board-column-expanded <?= $this->projectRole->isSortableColumn($column['project_id'], $column['id']) ? 'sortable-column' : '' ?>"
    data-column-id="<?= $column['id'] ?>"
    data-swimlane-id="<?= $swimlane['id'] ?>"
    data-task-limit="<?= $column['task_limit'] ?>">

<?php foreach ($column['tasks'] as $task): ?>
    <?= $this->render($not_editable ? 'board/task_public' : 'board/task_private', array(
        'project' => $project,
        'task' => $task,
        'board_highlight_period' => $board_highlight_period,
        'not_editable' => $not_editable,
    )) ?>
<?php endforeach; ?>

</div>
