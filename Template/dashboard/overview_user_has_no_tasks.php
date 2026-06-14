<?php $projects = $this->model->kanextDashboardModel->getProjectsWhereUserHasNoTasks(); ?>

<?php if (count($projects) > 0) { ?>
    <?php foreach ($projects as $result) { ?>
        <div class="page-header">
            <h2 id="project-tasks-<?php echo $result['project_id']; ?>"><?php echo $this->url->link($this->text->e($result['project_name']), 'BoardViewController', 'show', ['project_id' => $result['project_id']]); ?></h2>
        </div>

        <div class="c3_project_stats" id="c3_project_stats_<?php echo $result['project_id']; ?>_no_tasks" data-stats='<?php echo $result['project_stats']; ?>'></div>

        <div class="kanext_dashboard-add-new-task">
            <small>
                <?php if ($this->projectRole->canCreateTaskInColumn($result['project_id'], null)) { ?>

                    <?php echo $this->helper->modal->large(
                        'plus',
                        t('Add a new task in ') . $this->text->e($result['project_name']),
                        'TaskCreationController',
                        'show', [
                            'project_id' => $result['project_id'],
                            'column_id' => null,
                            'swimlane_id' => null,
                        ]
                    ); ?>

                <?php } ?>
            </small>
        </div>
    <?php } ?>
<?php } ?>
