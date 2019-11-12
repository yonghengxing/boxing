<?php
/**
 * User: shoubin@iscas.ac.cn
 * Date: 2018/10/14
 * Time: 17:17
 */

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Contracts\View\View;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Project;
use App\Models\Group;
use App\Models\Commit;
use DB;
use Illuminate\Console\Command;



class RepositoryController extends BaseController
{
    
 
    public function repository_list()
    {
        return view('repository/list');
    }
    
    public function repository_new()
    {
        return view('repository/new');
    }
    
    
}
class stdObject {
    public function __construct(array $arguments = array()) {
        if (!empty($arguments)) {
            foreach ($arguments as $property => $argument) {
                $this->{$property} = $argument;
            }
        }
    }
    
    public function __call($method, $arguments) {
        $arguments = array_merge(array("stdObject" => $this), $arguments); // Note: method argument 0 will always referred to the main class ($this).
        if (isset($this->{$method}) && is_callable($this->{$method})) {
            return call_user_func_array($this->{$method}, $arguments);
        } else {
            throw new Exception("Fatal error: Call to undefined method stdObject::{$method}()");
        }
    }
}