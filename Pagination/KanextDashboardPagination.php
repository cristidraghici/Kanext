<?php

namespace Kanboard\Plugin\Kanext\Pagination;

use Kanboard\Model\ProjectModel;
use Kanboard\Model\TaskModel;
use Kanboard\Pagination\DashboardPagination;

class KanextDashboardPagination extends DashboardPagination
{
    /**
     * Get user listing pagination.
     *
     * @param int $userId
     *
     * @return array
     */
    public function getOverview($userId)
    {
        $paginators = [];
        $projects = $this->projectUserRoleModel->getActiveProjectsByUser($userId);

        $limit = (int) $this->configHelper->get('kanext_feature_kanext_dashboard_project_limit', 0);
        $order = $this->configHelper->get('kanext_feature_kanext_dashboard_project_order', 'name');
        $direction = $this->configHelper->get('kanext_feature_kanext_dashboard_project_order_direction', 'ASC');

        if ('name' === $order) {
            if ('DESC' === $direction) {
                $projects = array_reverse($projects, true);
            }
        } elseif ('id' === $order) {
            if ('DESC' === $direction) {
                krsort($projects); // Highest ID first (newest)
            } else {
                ksort($projects); // Lowest ID first (oldest)
            }
        } elseif ('assigned_tasks' === $order) {
            $task_counts = [];
            foreach ($projects as $projectId => $projectName) {
                $task_counts[$projectId] = $this->kanextDashboardModel->countTasksByProjectIdAndUserId($projectId, $userId, [TaskModel::STATUS_OPEN]);
            }
            if ('DESC' === $direction) {
                arsort($task_counts);
            } else {
                asort($task_counts);
            }
            $sorted_projects = [];
            foreach ($task_counts as $projectId => $count) {
                $sorted_projects[$projectId] = $projects[$projectId];
            }
            $projects = $sorted_projects;
        }

        if ($limit > 0) {
            $projects = array_slice($projects, 0, $limit, true);
        }

        foreach ($projects as $projectId => $projectName) {
            $query = $this->taskFinderModel->getUserQuery($userId)->eq(ProjectModel::TABLE . '.id', $projectId);
            $this->hook->reference('pagination:dashboard:task:query', $query);

            $paginator = $this->paginator
                ->setUrl('DashboardController', 'show', ['user_id' => $userId, 'pagination' => 'tasks-' . $projectId], 'project-tasks-' . $projectId)
                ->setMax(15)
                ->setOrder(TaskModel::TABLE . '.priority')
                ->setDirection('DESC')
                ->setFormatter($this->taskListSubtaskAssigneeFormatter->withUserId($userId))
                ->setQuery($query)
                ->calculateOnlyIf($this->request->getStringParam('pagination') === 'tasks-' . $projectId);

            if ($paginator->getTotal() > 0) {
                $paginators[] = [
                    'project_id' => $projectId,
                    'project_name' => $projectName,
                    'paginator' => $paginator,
                ];
            }
        }

        return $paginators;
    }
}
