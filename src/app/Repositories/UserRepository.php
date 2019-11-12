<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\User;

class UserRepository extends BaseRepository
{
    /**
     * Create a new WorkReuqestRepository instance.
     *
     * @param  App\Models\WorkRequest $request
     * @return void
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Save request
     * @param  App\Models\WorkRequest $workRequest
     */
    public function save($user)
    {
        $user->save();
    }
    
    public function getAllUsers()
    {
        $users =  $this->model->all();
        return $users;
    }
}

?>