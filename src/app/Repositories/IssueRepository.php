<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\User;
use App\Models\Project;
use App\Models\Group;
use App\Models\Issue;

class IssueRepository extends BaseRepository
{
    /**
     * Create a new WorkReuqestRepository instance.
     *
     * @param  App\Models\WorkRequest $request
     * @return void
     */
    public function __construct(Issue $issue)
    {
        $this->model = $issue;
    }

    /**
     * Save request
     * @param  App\Models\WorkRequest $workRequest
     */
    public function save($issue)
    {
        $issue->update_time = date('y-m-d h:i:s',time());;
        $issue->save();
    }
    
    public function getAll()
    {
        $issues=  $this->model->all();
        return $issues;
    }
}

?>