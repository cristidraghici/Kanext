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
        $not_editable = !!$project['is_public'] || !$project['is_private'];

        $swimlanes = $this->taskLexer
            ->build($this->userSession->getFilters($project_id))
            ->format($this->boardFormatter->withProjectId($project_id));
        $filtered_swimlanes = array_filter($swimlanes, function ($item) use ($swimlane_id) { return $item['id'] === $swimlane_id; });
        $swimlane = array_values($filtered_swimlanes)[0];

        $filtered_columns = array_filter($swimlane['columns'], function ($item) use ($column_id) { return $item['id'] === $column_id; });
        $column = array_values($filtered_columns)[0];

        $this->response->html($this->template->render('Kanext:kanext_limit_tasks/kanext_tasks', array(
            'project' => $project,
            'swimlane' => $swimlane,
            'column' => $column,

            'board_highlight_period' => $board_highlight_period,
            'not_editable' => isset($not_editable),
        )));
    }
}
