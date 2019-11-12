<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\User;
use App\Models\Project;
use App\Models\Group;
use App\Models\Issue;
use App\Models\Commit;

class CommitRepository extends BaseRepository
{
    /**
     * Create a new WorkReuqestRepository instance.
     *
     * @param  App\Models\WorkRequest $request
     * @return void
     */
    public function __construct(Commit $commit)
    {
        $this->model = $commit;
    }

    /**
     * Save request
     * @param  App\Models\WorkRequest $workRequest
     */
    public function save($commit)
    {
        $commit->update_time = date('y-m-d h:i:s',time());;
        $commit->save();
    }
    
    public function getAll()
    {
        $commits =  $this->model->all();
        return $commits;
    }
}

?>