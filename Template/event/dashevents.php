<?php if (empty($events)): ?>
    <p class="alert"><?= t('There is no activity yet.') ?></p>
<?php else: ?>
    <?php $current_project_id = null; ?>
    <?php foreach ($events as $event): ?>
        <?php if ($current_project_id !== $event['task']['project_id']) : ?>
        <summary class="accordion-title">
          <a href="?controller=BoardViewController&action=show&project_id=<?= $event['task']['project_id'] ?>"><?= $event['task']['project_name'] ?></a>
        </summary>
        <?php endif; ?>

        <div class="activity-event">
            <?= $this->avatar->render(
                $event['creator_id'],
                $event['author_username'],
                $event['author_name'],
                $event['email'],
                $event['avatar_path']
            ) ?>

            <div class="activity-content">
                <?= $event['event_content'] ?>
            </div>

        </div>
        <?php $current_project_id = $event['task']['project_id']; ?>
    <?php endforeach ?>
<?php endif ?>
