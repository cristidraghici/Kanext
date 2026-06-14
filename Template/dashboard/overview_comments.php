<div class="page-header">
    <h2><?php echo t('Latest comments'); ?></h2>
</div>

<?php
    $events = @array_values($this->model->kanextDashboardModel->commentEvents());
    $nr_events = count($events);
    ?>

<div class="dashboard-activity">
    <?php if (0 === $nr_events) { ?>
        <p class="alert"><?php echo t('There are no comments yet.'); ?></p>
    <?php } else { ?>
        <?php $current_project_id = null;
        foreach ($events as $key => $event) { ?>

            <?php if ($current_project_id !== $event['task']['project_id']) { ?>
                <div class="table-list">

                    <div class="table-list-header">
                        <?php echo $this->url->link($this->text->e($event['task']['project_name']), 'BoardViewController', 'show', ['project_id' => $event['task']['project_id']]); ?>
                    </div>

                <?php $current_project_id = $event['task']['project_id']; ?>
            <?php } ?>

            <?php $rgb = $this->model->kanextDashboardModel->getColorByName($event['author_name'] ?: $event['author_username']); ?>

            <div class="table-list-row color-<?php echo $event['task']['color_id']; ?> dashboard-activity-content" style="border-left-color: <?php echo sprintf('rgb(%d, %d, %d)', $rgb[0], $rgb[1], $rgb[2]); ?>;">
                <div>
                    <?php echo $event['event_content']; ?>
                </div>
            </div>

            <?php $next_key = $key + 1;
            if ($next_key === $nr_events || $events[$next_key]['task']['project_id'] !== $current_project_id) { ?>
                </div>
            <?php } ?>

        <?php } ?>
    <?php } ?>
</div>
