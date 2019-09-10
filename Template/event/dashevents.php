<?php if (empty($events)): ?>
    <p class="alert"><?= t('There is no activity yet.') ?></p>
<?php else: ?>
    <?php foreach ($events as $event): ?>
        <summary class="accordion-title">
          <a href="?controller=BoardViewController&action=show&project_id=<?= $event['task']['project_id'] ?>"><?= $event['task']['project_name'] ?></a>
        </summary>

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
    <?php endforeach ?>
<?php endif ?>
