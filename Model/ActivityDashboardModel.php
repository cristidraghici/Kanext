<?php

namespace Kanboard\Plugin\Kanext\Model;

use Kanboard\Core\Base;

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
    }
}
