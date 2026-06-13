<?php // This template is extracted from the original `board/table_tasks.php` file?>
<div
    class="board-task-list board-column-expanded <?php echo $this->projectRole->isSortableColumn($column['project_id'], $column['id']) ? 'sortable-column' : ''; ?>"
    data-column-id="<?php echo $column['id']; ?>"
    data-swimlane-id="<?php echo $swimlane['id']; ?>"
    data-task-limit="<?php echo $column['task_limit']; ?>">

<?php foreach ($column['tasks'] as $task) { ?>
    <?php echo $this->render($not_editable ? 'board/task_public' : 'board/task_private', [
        'project' => $project,
        'task' => $task,
        'board_highlight_period' => $board_highlight_period,
        'not_editable' => $not_editable,
    ]); ?>
<?php } ?>

</div>
