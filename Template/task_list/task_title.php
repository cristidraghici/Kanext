<div>
    <?php if ($this->user->hasProjectAccess('TaskModificationController', 'edit', $task['project_id'])): ?>
        <?php if (isset($show_items_selection)): ?>
            <input type="checkbox" data-list-item="selectable" name="tasks[]" value="<?= $task['id'] ?>">
        <?php endif ?>
        <?= $this->render('task/dropdown', array('task' => $task, 'redirect' => isset($redirect) ? $redirect : '')) ?>
    <?php else: ?>
        <strong><?= '#'.$task['id'] ?></strong>
    <?php endif ?>

    <span class="table-list-title <?= $task['is_active'] == 0 ? 'status-closed' : '' ?>">
        <?= $this->url->link($this->text->e($task['title']), 'TaskViewController', 'show', array('project_id' => $task['project_id'], 'task_id' => $task['id'])) ?>
    </span>

    <?php foreach ($task['tags'] as $tag): ?>
        <span class="table-list-category task-list-tag <?= $tag['color_id'] ? "color-{$tag['color_id']}" : '' ?>">
            <?= $this->text->e($tag['name']) ?>
        </span>
    <?php endforeach ?>

</div>
