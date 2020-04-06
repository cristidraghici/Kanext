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
    public function activityEvents()
    {
        $max_activity_items = 20;
        $user_id = $this->userSession->getId();
        $projectIds = $this->projectPermissionModel->getProjectIds($user_id);

        return $this->helper->projectActivity->getProjectsEvents($projectIds, $max_activity_items);
    }

    public function commentEvents()
    {
        $limit = 20;
        $user_id = $this->userSession->getId();
        $project_ids = $this->projectPermissionModel->getProjectIds($user_id);

        $queryBuilder = $this->projectActivityQuery
            ->withFilter(new ProjectActivityProjectIdsFilter($project_ids));

        $queryBuilder->getQuery()
            ->ilike(ProjectActivityModel::TABLE.'.event_name', 'comment.%')
            ->desc(ProjectActivityModel::TABLE.'.id')
            ->limit($limit)
        ;

        return $queryBuilder->format($this->projectActivityEventFormatter);
    }
}
