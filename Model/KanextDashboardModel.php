<?php

namespace Kanboard\Plugin\Kanext\Model;

use Kanboard\Core\Base;

use Kanboard\Filter\ProjectActivityProjectIdsFilter;
use Kanboard\Model\ProjectActivityModel;
use PicoDb\Table;
use Kanboard\User\Avatar\LetterAvatarProvider;
use Kanboard\Model\TaskModel;

/**
 * Kanext Controller
 *
 * @package  Kanboard\Plugin\Kanext\Controller
 * @author   Cristi DRAGHICI
 */
class KanextDashboardModel extends Base
{
    const DEFAULT_LIMIT = 20;

    /**
     * These are the events from the comment model
     */
    const EVENT_UPDATE       = 'comment.update';
    const EVENT_CREATE       = 'comment.create';
    const EVENT_DELETE       = 'comment.delete';
    const EVENT_USER_MENTION = 'comment.user.mention';

    public function activityEvents ($user_id = null, $limit = null)
    {
        if (!$user_id) {
            $user_id = $this->userSession->getId();
        }
        if (!$limit) {
            $limit = $this->configHelper->get('kanext_feature_kanext_dashboard_activity_limit', self::DEFAULT_LIMIT);
        }

        $project_ids = $this->memoryCache->proxy($this->projectPermissionModel, 'getActiveProjectIds', $user_id);

        $queryBuilder = $this->projectActivityQuery
            ->withFilter(new ProjectActivityProjectIdsFilter($project_ids));

        if ($this->configHelper->get('kanext_feature_kanext_dashboard_show_comments_separately') === "1") {
            $queryBuilder->getQuery()
                ->beginAnd()
                ->neq(ProjectActivityModel::TABLE.'.event_name', self::EVENT_UPDATE)
                ->neq(ProjectActivityModel::TABLE.'.event_name', self::EVENT_CREATE)
                ->neq(ProjectActivityModel::TABLE.'.event_name', self::EVENT_DELETE)
                ->neq(ProjectActivityModel::TABLE.'.event_name', self::EVENT_USER_MENTION)
                ->closeAnd()
            ;
        }

        $queryBuilder->getQuery()
            ->desc(ProjectActivityModel::TABLE.'.id')
            ->limit($limit)
        ;

        return $queryBuilder->format($this->projectActivityEventFormatter);
    }

    public function commentEvents ($user_id = null, $limit = null)
    {
        if (!$user_id) {
            $user_id = $this->userSession->getId();
        }
        if (!$limit) {
            $limit = $this->configHelper->get('kanext_feature_kanext_dashboard_activity_limit', self::DEFAULT_LIMIT);
        }

        $project_ids = $this->memoryCache->proxy($this->projectPermissionModel, 'getActiveProjectIds', $user_id);

        $queryBuilder = $this->projectActivityQuery
            ->withFilter(new ProjectActivityProjectIdsFilter($project_ids));

        $queryBuilder->getQuery()
            ->beginOr()
            ->eq(ProjectActivityModel::TABLE.'.event_name', self::EVENT_UPDATE)
            ->eq(ProjectActivityModel::TABLE.'.event_name', self::EVENT_CREATE)
            ->eq(ProjectActivityModel::TABLE.'.event_name', self::EVENT_DELETE)
            ->eq(ProjectActivityModel::TABLE.'.event_name', self::EVENT_USER_MENTION)
            ->closeOr()
            ->desc(ProjectActivityModel::TABLE.'.id')
            ->limit($limit)
        ;

        return $queryBuilder->format($this->projectActivityEventFormatter);
    }

    public function getProjectsWhereUserHasNoTasks ($user_id = null) {
        if (!$user_id) {
            $user_id = $this->userSession->getId();
        }

        $project_ids = $this->memoryCache->proxy($this->projectPermissionModel, 'getActiveProjectIds', $user_id);
        $list = array();

        $projects = $this->projectModel->getAllByIds($project_ids);
        foreach ($projects as $project) {
            if (!$this->taskFinderModel->countByProjectId($project['id'], array(TaskModel::STATUS_OPEN))) {
                continue;
            }
            if ($this->countTasksByProjectIdAndUserId($project['id'], $user_id, array(TaskModel::STATUS_OPEN)) > 0) {
                continue;
            }

            $list[] = array(
                'project_id' => $project['id'],
                'project_name' => $project['name'],
                'project_stats' => $this->kanextDashboardModel->getBarChartProjectStats($project['id'])
            );
        }

        return $list;
    }


    public function countTasksByProjectIdAndUserId($project_id, $user_id, array $status = array(TaskModel::STATUS_OPEN, TaskModel::STATUS_CLOSED))
    {
        return $this->db
                    ->table(TaskModel::TABLE)
                    ->eq('project_id', $project_id)
                    ->eq('owner_id', $user_id)
                    ->in('is_active', $status)
                    ->count();
    }

    public function getColorByName ($name='') {
        $avatarProvider = new LetterAvatarProvider( $this->container );
        $rgb = $avatarProvider->getBackgroundColor( $name );

        return $rgb;
    }

    public function getBarChartProjectStats ($project_id) {
        $project_stats = $this->memoryCache->proxy($this->columnModel, 'getAllWithTaskCount', $project_id);
        $stats = array();

        foreach ($project_stats as $stat) {
            // if ($stat['hide_in_dashboard'] === '1') {
            //     continue;
            // }

            $nb_open_tasks = (int)$stat['nb_open_tasks'];

            $stats[] = [$stat['title'], $nb_open_tasks];
        }

        return @json_encode($stats, JSON_HEX_APOS);
    }
}
