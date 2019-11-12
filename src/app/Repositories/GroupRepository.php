<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\User;
use App\Models\Project;
use App\Models\Group;

class GroupRepository extends BaseRepository
{
    /**
     * Create a new WorkReuqestRepository instance.
     *
     * @param  App\Models\WorkRequest $request
     * @return void
     */
    public function __construct(Group $group)
    {
        $this->model = $group;
    }

    /**
     * Save request
     * @param  App\Models\WorkRequest $workRequest
     */
    public function save($group)
    {
        $group->update_time = date('y-m-d h:i:s',time());;
        $group->save();
    }
    
    public function getAll()
    {
        $groups=  $this->model->all();
        return $groups;
    }
}

?>