<?php
namespace Kanboard\Pagination;

use Kanboard\Core\Base;
use Kanboard\Core\Paginator;
use Kanboard\Model\ProjectModel;

/**
 * Class ProjectPagination
 *
 * @package Kanboard\Pagination
 * @author  Frederic Guillot
 */
class ProjectPagination extends Base
{
    /**
     * Get dashboard pagination
     *
     * @access public
     * @param  integer $user_id
     * @param  string  $method
     * @param  integer $max
     * @return Paginator
     */
    public function getDashboardPaginator($user_id, $method, $max)
    {
        // if ($this->userSession->isAdmin()) {
        //     $projectIds = $this->projectModel->getAllIds();
        // } else {
        //     $projectIds = $this->projectPermissionModel->getProjectIds($this->userSession->getId());
        // }

        $projectIds = $this->projectPermissionModel->getProjectIds($this->userSession->getId());

        $query = $this->projectModel->getQueryColumnStats($projectIds);
        $this->hook->reference('pagination:dashboard:project:query', $query);

        return $this->paginator
            ->setUrl('DashboardController', $method, array('pagination' => 'projects', 'user_id' => $user_id))
            ->setMax($max)
            ->setOrder(ProjectModel::TABLE.'.name')
            ->setQuery($query)
            ->calculateOnlyIf($this->request->getStringParam('pagination') === 'projects');
    }
}
