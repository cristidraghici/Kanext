<div class="page-header">
    <h2><?php echo t('Activity overview'); ?></h2>
</div>

<?php
    $events = @array_values($this->model->activityDashboardModel->activityEvents());
    $nr_events = count($events);
?>

<div class="dashboard-activity">
    <?php if ($nr_events === 0): ?>
        <p class="alert"><?= t('There is no activity yet.') ?></p>
    <?php else: ?>
        <?php $current_project_id = null; foreach ($events as $key=>$event): ?>

            <?php if ($current_project_id !== $event['task']['project_id']) : ?>
                <div class="table-list">

                    <div class="table-list-header">
                        <a href="?controller=BoardViewController&action=show&project_id=<?= $event['task']['project_id'] ?>"><?= $event['task']['project_name'] ?></a>
                    </div>

                <?php $current_project_id = $event['task']['project_id']; ?>
            <?php endif; ?>

            <div class="table-list-row color-<?= $event['task']['color_id'] ?> dashboard-activity-content">
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
