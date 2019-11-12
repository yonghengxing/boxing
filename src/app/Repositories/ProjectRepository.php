<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\User;
use App\Models\Project;

class ProjectRepository extends BaseRepository
{
    /**
     * Create a new WorkReuqestRepository instance.
     *
     * @param  App\Models\WorkRequest $request
     * @return void
     */
    public function __construct(Project $project)
    {
        $this->model = $project;
    }

    /**
     * Save request
     * @param  App\Models\WorkRequest $workRequest
     */
    public function save($project)
    {
        //$project->update_time = date('y-m-d h:i:s',time());;
        $project->save();
    }
    
    public function getAll()
    {
        $projects=  $this->model->all();
        return $projects;
    }
}

?>