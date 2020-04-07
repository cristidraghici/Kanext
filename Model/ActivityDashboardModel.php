<?php

namespace Kanboard\Plugin\Kanext\Model;

use Kanboard\Core\Base;

use Kanboard\Filter\ProjectActivityProjectIdsFilter;
use Kanboard\Model\ProjectActivityModel;
use PicoDb\Table;

/**
 * Kanext Controller
 *
 * @package  Kanboard\Plugin\Kanext\Controller
 * @author   Cristi DRAGHICI
 */
class ActivityDashboardModel extends Base
{
    const DEFAULT_LIMIT = 20;

    /**
     * These are the events from the comment model
     */
    const EVENT_UPDATE       = 'comment.update';
    const EVENT_CREATE       = 'comment.create';
    const EVENT_DELETE       = 'comment.delete';
    const EVENT_USER_MENTION = 'comment.user.mention';

    public function activityEvents($user_id = null, $limit = null)
    {
        if (!$user_id) {
            $user_id = $this->userSession->getId();
        }
        if (!$limit) {
            $limit = self::DEFAULT_LIMIT;
        }

        $project_ids = $this->projectPermissionModel->getProjectIds($user_id);

        $queryBuilder = $this->projectActivityQuery
            ->withFilter(new ProjectActivityProjectIdsFilter($project_ids));

        $queryBuilder->getQuery()
            ->beginAnd()
            ->neq(ProjectActivityModel::TABLE.'.event_name', self::EVENT_UPDATE)
            ->neq(ProjectActivityModel::TABLE.'.event_name', self::EVENT_CREATE)
            ->neq(ProjectActivityModel::TABLE.'.event_name', self::EVENT_DELETE)
            ->neq(ProjectActivityModel::TABLE.'.event_name', self::EVENT_USER_MENTION)
            ->closeAnd()
            ->desc(ProjectActivityModel::TABLE.'.id')
            ->limit($limit)
        ;

        return $queryBuilder->format($this->projectActivityEventFormatter);
    }

    public function commentEvents($user_id = null, $limit = null)
    {
        if (!$user_id) {
            $user_id = $this->userSession->getId();
        }
        if (!$limit) {
            $limit = self::DEFAULT_LIMIT;
        }

        $project_ids = $this->projectPermissionModel->getProjectIds($user_id);

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
}
