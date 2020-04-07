<div class="page-header">
    <h2><?php echo t('Comments'); ?></h2>
</div>

<?php
    $events = @array_values($this->model->activityDashboardModel->commentEvents());
    $nr_events = count($events);
?>

<div class="dashboard-activity">
    <?php if ($nr_events === 0): ?>
        <p class="alert"><?= t('There are no comments yet.') ?></p>
    <?php else: ?>
        <?php $current_project_id = null; foreach ($events as $key=>$event): ?>

            <?php if ($current_project_id !== $event['task']['project_id']) : ?>
                <div class="table-list">

                    <div class="table-list-header">
                        <?= $this->url->link($this->text->e($event['task']['project_name']), 'BoardViewController', 'show', array('project_id' => $event['task']['project_id'])) ?>
                    </div>

                <?php $current_project_id = $event['task']['project_id']; ?>
            <?php endif; ?>

            <?php $rgb = $this->model->activityDashboardModel->getColorByName($event['author_name'] ?: $event['author_username']); ?>

            <div class="table-list-row color-<?= $event['task']['color_id'] ?> dashboard-activity-content" style="border-left-color: <?= sprintf('rgb(%d, %d, %d)', $rgb[0], $rgb[1], $rgb[2]) ?>;">
                <div>
                    <?= $event['event_content'] ?>
                </div>
            </div>

            <?php $next_key = $key + 1; if ($next_key === $nr_events || $events[$next_key]['task']['project_id'] !== $current_project_id): ?>
                </div>
            <?php endif; ?>

        <?php endforeach ?>
    <?php endif ?>
</div>
