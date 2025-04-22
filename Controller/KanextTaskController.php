<?php
namespace Kanboard\Plugin\Kanext\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Core\Controller\AccessForbiddenException;
use Kanboard\Filter\TaskProjectFilter;

class KanextTaskController extends BaseController
{
    public function allTasksInColumn()
    {
        $project_id =  $this->request->getIntegerParam('project');
        $swimlane_id =  $this->request->getIntegerParam('swimlane');
        $column_id =  $this->request->getIntegerParam('column');

        if (! $project_id || ! $column_id || ! $swimlane_id || ! $this->request->isAjax()) {
            throw new AccessForbiddenException(e('You don\'t have the permission to complete this action', 'kanext'));
        }

        $project = $this->getProject($project_id);
        $not_editable = !empty($project['is_public']);

        $swimlanes = $this->taskLexer
            ->build($this->userSession->getFilters($project_id))
            ->format($this->boardFormatter->withProjectId($project_id));
        $filtered_swimlanes = array_filter($swimlanes, function ($item) use ($swimlane_id) { return $item['id'] === $swimlane_id; });

        if (empty($filtered_swimlanes) || !is_array($filtered_swimlanes)) {
            throw new AccessForbiddenException(e('You don\'t have the permission to complete this action because of the swimlanes.', 'kanext'));
        }

        $swimlane = array_values($filtered_swimlanes)[0];

        if (empty($swimlane)) {
            throw new AccessForbiddenException(e('You don\'t have the permission to complete this action because of the swimlane.', 'kanext'));
        }

        $filtered_columns = array_filter($swimlane['columns'], function ($item) use ($column_id) { return $item['id'] === $column_id; });

        if (empty($filtered_columns) || !is_array($filtered_columns)) {
            throw new AccessForbiddenException(e('You don\'t have the permission to complete this action because of the columns.', 'kanext'));
        }

        $column = array_values($filtered_columns)[0];

        if (empty($column)) {
            throw new AccessForbiddenException(e('You don\'t have the permission to complete this action because of the column.', 'kanext'));
        }

        $board_highlight_period = null; // TODO: improve on this

        $this->response->html($this->template->render('Kanext:kanext_limit_tasks/kanext_tasks', array(
            'project' => $project,
            'swimlane' => $swimlane,
            'column' => $column,

            'board_highlight_period' => $board_highlight_period,
            'not_editable' => $not_editable,
        )));
    }
}
