<?php $projects = $this->model->kanextDashboardModel->getProjectsWhereUserHasNoTasks(); ?>

<?php if (count($projects) > 0): ?>
    <?php foreach ($projects as $result): ?>
        <div class="page-header">
            <h2 id="project-tasks-<?= $result['project_id'] ?>"><?= $this->url->link($this->text->e($result['project_name']), 'BoardViewController', 'show', array('project_id' => $result['project_id'])) ?></h2>
        </div>

        <div class="c3_project_stats" id="c3_project_stats_<?= $result['project_id'] ?>_no_tasks" data-stats='<?= $result['project_stats']; ?>'></div>

        <div class="kanext_dashboard-add-new-task">
            <small>
                <?php if ($this->projectRole->canCreateTaskInColumn($result['project_id'], null)): ?>

                    <?= $this->helper->modal->large(
                        'plus',
                        t('Add a new task in ') . $this->text->e($result['project_name']),
                        'TaskCreationController',
                        'show', array(
                            'project_id'  => $result['project_id'],
                            'column_id'   => null,
                            'swimlane_id' => null,
                        )
                    ); ?>

                <?php endif ?>
            </small>
        </div>
    <?php endforeach ?>
<?php endif ?>
