<?php
/**
 * User: shoubin@iscas.ac.cn
 * Date: 2018/10/14
 * Time: 17:17
 */

namespace App\Http\Controllers;

use App\Models\Commit;
use App\Models\User;
use App\Models\Version;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;

use App\Services\ComponentService;

use App\Models\ItechsProductIndex;
use App\Models\Component;
use App\Models\ProductDevices;
use Illuminate\Support\Facades\DB;

class IndexController extends BaseController
{
    public function __construct(ComponentService $componentService)
    {
        //$this->middleware('auth');
        $this->middleware('auth');
        $this->componentService = $componentService;
    }
    
 
    public function index(Request $request)
    {
        $procNum = ItechsProductIndex::all();
        $compNum = Component::all()->count();
        $devNum = ProductDevices::all()->count();
        $apprNum = Component::where("appr_status",10001)->count();
        $testNum = Component::where("test_status",2001)->count();
        $devices =  ProductDevices::select('devicesname')->get();
        $verNum = Version::where("type",1)->count();
//         $verNum = DB::table("version")->select('type')->where("type",1)->distinct()->count();
        $devices11[] = null;
        for ($i = 0;$i < count($devices);$i++){
            $devices11[$i] = $devices[$i]->devicesname;
        }
        $dev_unique = count(array_unique($devices11));
        //dd($dev_unique);

        
        $mComponents = null;
        $mComponents = $this->componentService->getAll();
        $perPage = 7;
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $mComponents->count();
        $result = $mComponents->sortByDesc("appr_status")->sortByDesc("appr_updated")->forPage($currentPage, $perPage);
        $components= new LengthAwarePaginator($result,$total,$perPage,$currentPage,[
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page']);
        
        return view('home',compact('procNum','compNum','devNum','components','dev_unique','apprNum','testNum','verNum'));
    }
    
    /**
     * 鐢ㄦ埛A 鎸夋椂闂村垎甯冨睍绀� 浠ｇ爜鎻愪氦閲忋�乧ommit 鎻愪氦娆℃暟銆� 鏁版嵁鍚堣锛氱敤鎴峰悎璁℃彁浜や唬鐮佹鏁帮紝鍚堣鎻愪氦commit娆℃暟锛岃繃鍘讳竴鍛ㄥ唴鐨勫钩鍧囧�笺��
     * @return unknown
     */
    public function user()
    {
        
        
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