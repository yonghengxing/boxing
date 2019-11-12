<?php
/**
* User: danqi@iscas.ac.cn
* Date: 2018/11/26
* Time: 14:48
*/
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Contracts\View\View;
use App\Models\Group;
use App\Models\Event;
use App\Models\Component;
use App\Models\SendRecord;
use Illuminate\Http\Request;
use App\Services\GroupService;
use App\Services\SendRecordService;
use App\Services\UserService;
use App\Services\CompAuthorityService;
use App\Services\ComponentService;
use App\Services\EventService;
use App\Services\ProductIndexService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use phpDocumentor\Reflection\Types\Null_;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\ItechsProductIndex;
use App\Models\ItechsProduct;
use App\Models\ProductDevices;
use App\Models\ProcToComp;

use App\Services\ItechsProductService;
use App\Services\ProductServices;
use App\Services\VersionServices;
use App\Services\IpRecordService;
use Symfony\Component\Finder\Glob;
use App\Services\ApprRecordService;

use Chumper\Zipper\Zipper;
use App\Models\Version;
use App\Services\ProctocompService;
use App\Services\ProductdevicesService;

class ProductController extends BaseController
{
    /**
     * User: danqi@iscas.ac.cn
     * Date: 2018/11/29
     * Time: 11:08
     * 实例化容器
     */
    function __construct(IpRecordService $ipRecordService,ItechsProductService $itechsProductService,SendRecordService $sendRecordService,ProductIndexService $productIndexService,ProductServices $productService,ComponentService $componentService,GroupService $groupService,ProctocompService $proctocompService,ProductdevicesService $productdevicesService,ApprRecordService $apprRecordService)
    {
        $this->productService = $productService;
        $this->productIndexService = $productIndexService;
        $this->sendRecordService = $sendRecordService;
        $this->componentService = $componentService;
        $this->groupService = $groupService;
        $this->proctocompService = $proctocompService;
        $this->productdevicesService = $productdevicesService;
        $this->itechsProductService = $itechsProductService;
        $this->ipRecordService = $ipRecordService;
        $this->apprRecordService = $apprRecordService;
    }
    
    /**
    * 打开批量删除的页面
    * @date: 2019年2月22日 下午7:34:19
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    public function procDeleMulitComp($proid){
        //获取产品ID
        $promessage = ProcToComp::all()->where("proid",$proid); //获取组件与产品的关联信息显示在产品编辑页面
        
        return view('product/removemulticomp',compact('promessage','proid'));
    }
    
    public function procDeleMulitCompDo($proid,Request $request){
        //获取产品ID
        $res = $request->all();
        // dd($res);
        foreach ($res as $key => $value){
            $pos = strpos($key,'checkbox');
            if($pos !== false){
                if($value == "on"){
                    $id = substr($key,8);
                    $message = $this->proctocompService->getById($id);
                    $files = $message->Files;
                    foreach ($files as $file){
                        $removeRes = $file->delete();
                        if (!$removeRes){
                            $url = "product/message/" . $proid;
                            $msg = "移除错误！";
                            return view('error', compact("url","msg"));
                        }
                        
                    }
                    $removeRes = $this->proctocompService->delete($id);
                    if (!$removeRes){
                        $url = "product/message/" . $proid;
                        $msg = "移除错误！";
                        return view('error', compact("url","msg"));
                    }
                }
            }
        }
        $url = "product/message/" . $proid;
        return view('success', compact("url"));
    }
    
    /**
    * 新的新建产品，输入产品名、描述、公司信息
    * @date: 2019年1月15日 下午8:33:57
    * @author: wongwuchiu
    * @param: null
    * @return: 
    */
    public function procNew(){
        $groups = $this->groupService->getAll();
        return view('product/newproc', compact("groups"));
    }
    
    /**
     * 新的新建产品数据处理
     * @date: 2019年1月15日 下午8:33:57
     * @author: wongwuchiu
     * @param: null
     * @return:
     */
    public function procNewDo(Request $request){
        if ($request->get("sub1") != null)
        {
            if ($request->get("proname") != null && $request->get("prodespt") != null)
            {
                $proname = $request->get("proname");
                $prodespt = $request->get("prodespt");
                $group_id = $request->get("group_id");
//                 echo $proname . '<br>' . $prodespt . '<br>' . $group_id . '<br>';
                // 去重查询
                $id = 0;
                $event = ItechsProductIndex::select('id')
                ->where('proname', '=', $proname)
                ->get();
                foreach ($event as $event)
                {
                    $id = $event->id;
                }
                
                // 创建表项
                if ($id == 0)
                {
                    $proindex = new ItechsProductIndex();
                    $proindex->proname = $proname;
                    $proindex->prodespt = $prodespt;
                    $proindex->group_id = $group_id;
                    $procID = $this->productIndexService->appendID($proindex);
//                     echo $procID;
                    $url = "product/message/" . $procID;
                    return view('success', compact("url"));
                }
                
                //产品信息
            } else
                echo "empty message";
        }
        $proall = ItechsProductIndex::all();
        //         var_dump($proall);
        return view('product/show',compact('proall'));
    }
    
    /**
    * 建立产品时选择已有的组件，展示组件的列表
    * @date: 2019年1月15日 下午9:26:08
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    public function procShowComp($proid,$select_type,$select_group,Request $request)
    {
        $mComponents = null;
        $groups = $this->groupService->getAll();
        if($select_type != 0 && $select_group != 0){
            $mComponents = $this->componentService->getAll()->where('comp_type',$select_type)->where('group_id',$select_group);
        } else if($select_type != 0 && $select_group == 0){
            $mComponents = $this->componentService->getAll()->where('comp_type',$select_type);
        } else if($select_group != 0 && $select_type == 0){
            $mComponents = $this->componentService->getAll()->where('group_id',$select_group);
        } else {
            $mComponents = $this->componentService->getAll();
        }
        //         $mComponents = $user->Component;
        $perPage = 15;
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $mComponents->count();
        $result = $mComponents->sortByDesc("dev_import")->forPage($currentPage, $perPage);
        $components= new LengthAwarePaginator($result,$total,$perPage,$currentPage,[
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page']);
        //         dd($components);
        return view('/product/complist', compact('components','groups','select_type','select_group','proid'));
    }
    
    /**
     * 建立产品时选择已有的组件，多选版本
     * @date: 2019年1月15日 下午9:26:08
     * @author: wongwuchiu
     * @param: variable
     * @return:
     */
    public function procMulitComp($proid,Request $request)
    {
        $currentPage = $request->input('page', 1);
        $select_type = $request->input('type', 0);
        $select_group = $request->input('group', 0);
        $mComponents = null;
        $groups = $this->groupService->getAll();
        if($select_type != 0 && $select_group != 0){
            $mComponents = $this->componentService->getAll()->where('comp_type',$select_type)->where('group_id',$select_group);
        } else if($select_type != 0 && $select_group == 0){
            $mComponents = $this->componentService->getAll()->where('comp_type',$select_type);
        } else if($select_group != 0 && $select_type == 0){
            $mComponents = $this->componentService->getAll()->where('group_id',$select_group);
        } else {
            $mComponents = $this->componentService->getAll();
        }
        //         $mComponents = $user->Component;
        $perPage = 15;
        $offset = ($currentPage - 1) * $perPage;
        $total = $mComponents->count();
        $result = $mComponents->sortByDesc("dev_import")->forPage($currentPage, $perPage);
        $components= new LengthAwarePaginator($result,$total,$perPage,$currentPage,[
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page']);
        //         dd($components);
        $components->appends(['type'=>$select_type])->appends(['group'=>$select_group])->render();
        // echo $proid;
        $hascomps = "|";
        $procomps = $this->proctocompService->getAllComps($proid);
        foreach ($procomps as $procomp){
            $oldId = $procomp->comp_id;
            $hascomps = $hascomps . $oldId . "|";
        }
        return view('/product/choosecomp', compact('components','groups','select_type','select_group','proid','hascomps'));
    }
    
    /**
     * 建立产品时选择已有的组件，多选版本的数据处理
     * @date: 2019年1月15日 下午9:26:08
     * @author: wongwuchiu
     * @param: variable
     * @return:
     */
    public function procMulitCompDo($proid,Request $request){
        $multiComps = $request->get("multicomps","");
        $compArray = explode("|", $multiComps);
        $errorFlag = false;
        $compOld = [];
        $procomps = $this->proctocompService->getAllComps($proid);
        foreach ($procomps as $procomp){
            $oldId = $procomp->comp_id;
            $compOld[] = $oldId;
        }
        foreach ($compArray as $compid){
            if ($compid == "" || $compid == null){
                continue;
            }
            if (in_array($compid, $compOld)){
                continue;
            }
            $component = $this->componentService->getById($compid);
            $mProduct = new ProcToComp();
            $mProduct->proid = $proid;
            $mProduct->comp_id = $compid;
            $mProduct->comp_name = $component->comp_name;
            $mProcbool = $mProduct->save();
            if (!$mProcbool){
                $errorFlag = true;
                break;
            }
        }
        $url = "product/message/" . $proid;
        if ($errorFlag){
            $msg = "选择出错！";
            return view('error', compact("url","msg"));
        } else {
            return view('success', compact("url"));
        }
    }
    
    /**
    * 新建模板时选择已有组件的选择组件处理
    * @date: 2019年1月15日 下午10:03:41
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    public function procChooseComp($proid,$compid,Request $request)
    {
//         echo $proid . "<br>" . $compid;
        $component = $this->componentService->getById($compid);
        $mProduct = new ProcToComp();
        $mProduct->proid = $proid;
        $mProduct->comp_id = $compid;
        $mProduct->comp_name = $component->comp_name;
        $mProcbool = $mProduct->save();
        $url = "product/message/" . $proid;
        return view('success', compact("url"));
    }
    
    /**
    * 从产品模板中移除一个现有的组件
    * @date: 2019年1月15日 下午10:33:17
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    public function procRemoveComp($promessageid,$proid){
        $message = $this->proctocompService->getById($promessageid);
        $files = $message->Files;
//         dd($files);
        foreach ($files as $file){
            $removeRes = $file->delete();
            if (!$removeRes){
                $url = "product/message/" . $proid;
                $msg = "移除错误！";
                return view('error', compact("url","msg"));
            }
            
        }
        $removeRes = $this->proctocompService->delete($promessageid);
        if (!$removeRes){
            $url = "product/message/" . $proid;
            $msg = "移除错误！";
            return view('error', compact("url","msg"));
        }
        $url = "product/message/" . $proid;
        return view('success', compact("url"));
    }
    
    /**
    * 展示产品列表（可编辑）
    * @date: 2019年1月16日 下午3:18:16
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    public function procEditList($select_group,Request $request){
//         $proall = ItechsProductIndex::all()->sortByDesc("created_at");
//         return view('product/proceditlist',compact('proall'));
        $mProducts = null;
        $groups = $this->groupService->getAll();
        if($select_group != 0){
            $mProducts = $this->productIndexService->getAll()->where('group_id',$select_group);
        } else {
            $mProducts = $this->productIndexService->getAll();
        }
        $perPage = 15;
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $mProducts->count();
        $result = $mProducts->sortByDesc("created_at")->forPage($currentPage, $perPage);
        $proalls= new LengthAwarePaginator($result,$total,$perPage,$currentPage,[
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page']);
        return view('product/proceditlist',compact('proalls','groups','select_group'));
    }
    
    /**
    * 新的查看某个产品的文件
    * @date: 2019年1月16日 下午4:05:20
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    public function procFileShow($proid,Request $request){
        $mFileList = ItechsProduct::all()->where("proid",$proid);
        $perPage = 15;
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $mFileList->count();
        $result = $mFileList->sortByDesc("created_at")->forPage($currentPage, $perPage);
        $mProcLists= new LengthAwarePaginator($result,$total,$perPage,$currentPage,[
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page']);
        //         dd($components);
        
        return view('product/procfileshow',compact('mProcLists','proid'));
    }
    
    /**
    * 打开删除文件页面
    * @date: 2019年2月23日 下午1:19:19
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    public function procFileRemove($proid,Request $request){
        $mFileList = ItechsProduct::all()->where("proid",$proid);
        $perPage = 15;
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $mFileList->count();
        $result = $mFileList->sortByDesc("created_at")->forPage($currentPage, $perPage);
        $mProcLists= new LengthAwarePaginator($result,$total,$perPage,$currentPage,[
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page']);
        return view('product/fileremove',compact('mProcLists','proid'));
    }
    
    /**
     * 删除文件数据处理
     * @date: 2019年2月23日 下午1:19:19
     * @author: wongwuchiu
     * @param: variable
     * @return:
     */
    public function procFileRemoveDo($proid,Request $request){
        $multiFiles = $request->get("multifiles","");
        $fileArray = explode("|", $multiFiles);
        $errorFlag = false;
        foreach ($fileArray as $fileId){
            if ($fileId == ""){
                continue;
            }
            $removeRes = $this->itechsProductService->delete($fileId);
            if (!$removeRes){
                $errorFlag = true;
                break;
            }
        }
        $url = "product/procfileshow/" . $proid;
        if ($errorFlag){
            $msg = "删除出错！";
            return view('error', compact("url","msg"));
        } else {
            return view('success', compact("url"));
        }
    }
    
    
    // 产品索引信息插入数据表itechs_productindex
    public function ProIndexCreate(Request $request)
    {
        if ($request->get("sub1") != null) 
        {
            if ($request->get("proname") != null && $request->get("prodespt") != null) 
            {
                $proname = $request->get("proname");
                $prodespt = $request->get("prodespt");
                
                // 去重查询
                $id = 0;
                $event = ItechsProductIndex::select('id')
                ->where('proname', '=', $proname)
                ->get();
                foreach ($event as $event)
                {
                    $id = $event->id;
                }

                // 创建表项
                if ($id == 0) 
                {
                       $proindex = new ItechsProductIndex();
                       $proindex->proname = $proname;
                       $proindex->prodespt = $prodespt;
                       $probool = $proindex->save();
                   
                }
                
                //产品信息
            } else
                echo "empty message";
        }
        $proall = ItechsProductIndex::all();
//         var_dump($proall);
        return view('product/show',compact('proall'));
    }

    
    
    
    /**
     * User: danqi@iscas.ac.cn
     * Date: 2018/11/29
     * Time: 11:08
     * 产品详细信息创建
     */    
    public function ProCreate($proall_id,Request $request)
    {
        
        $component = Component::all();
        $proid = $proall_id;                            //获取产品ID
        
        if ($request->get("sub3") != null)
        {
            $this->copyFiles($proall_id);
        }
        
        $promessage = ProcToComp::all()->where("proid",$proall_id); //获取组件与产品的关联信息显示在产品编辑页面

        return view('product/message',compact('proall','promessage','component','proid'));
    }
    
    /**
     * 产品新建打开创建组件页面
     * @date: 2018年12月8日 22:12:29
     * @author: danqiliu
     * @param: variable
     * @return:
     */
    public function procNewComp()
    {
        $groups = $this->groupService->getAll();
        return view('/product/newcomp',compact('groups'));
    }
    
    /**
     * 产品新建创建组件数据处理
     * 数据入组件表itechs_component
     * @date: 2018年12月8日 22:12:29
     * @author: danqiliu
     * @param: variable
     * @return:
     */
    public function procNewCompDo($proid,Request $request)
    {        
        $compName = $request->get("comp_name");
        $compDesc = $request->get("comp_desc");
        $compType = $request->get("comp_type");
        $groupId = $request->get("group_id");
        //组件信息进组件库component
        $mComponent = new Component();
        $mComponent->comp_name = $compName;
        $mComponent->comp_type = $compType;
        $mComponent->comp_desc = $compDesc;
        $mComponent->group_id = $groupId;
        $comp_id = $this->componentService->appendID($mComponent);
        if ($comp_id == 0){
            $url = "component/list";
            $msg = "新建组件错误！";
            return view('error', compact("url","msg"));
        } else {
            //组件信息进组件产品关联库proctocomp，在前端message页面显示信息
            $mProduct = new ProcToComp();
            $mProduct->proid = $proid;
            $mProduct->comp_id = $comp_id;
            $mProduct->comp_name = $compName;
            $mProcbool = $mProduct->save();
            $url = "authority/adddever/" . $comp_id . "/" . $proid;
            return view('success', compact("url"));
//             $url = "product/message/" . $proid;
//             return view('success', compact("url"));
        }
    }
    
    /**
     * 产品文件信息数据处理
     * @date: 2018年12月9日 0:33
     * @author: danqiliu
     * @param: variable
     * @return:
     */
    function procFile()
    {
        return view('/product/productlist');
    }
    
    function procFileDo($proid,$compid,$p2cid,Request $request)
    {
        //获取本次追加的产品并计入数组
        $fileAppend = array();
        $appendNum = $request->get("file_num");
        $mProcBool = true;
        for ($idx=1; $idx <= $appendNum; $idx++){
            $fileNameKey = "filename_" . $idx;
            $filePathKey = "filepath_" . $idx;
            if (!$request->has($fileNameKey) && !$request->has($filePathKey)){
                break;
            }

            $fileNameAppend =$request->get($fileNameKey);
            $filePathAppend =$request->get($filePathKey);
            $mProcMes = new ItechsProduct();
            $mProcMes->proid = $proid;
            $mProcMes->comp_id = $compid;
            $mProcMes->profile = $fileNameAppend;
            $mProcMes->profilepath = $filePathAppend;
            $mProcMes->p2cid = $p2cid;
            $mProcBool = $mProcMes->save();
        }
        if ($mProcBool == true){
            
            $url = "product/message/" . $proid;
            return view('success', compact("url"));

        } else {
            $url = "component/list";
            $msg = "新建组件错误！";
            return view('error', compact("url","msg"));
        }
    }
    
    /**
     * 组件文件信息展示
     * @date: 2018年12月10日 15:24
     * @author: danqiliu
     * @param: variable
     * @return:
     */
    function compFileList($proid,$compid){
//         $compFile = ItechsProduct::all()->where("proid",$proid)->where("comp_id",$compid);
        $compFile = ItechsProduct::all()->where("proid",$proid)->where("p2cid",$compid);
        return view('/product/compfile',compact('compFile'));
    }
    
    /**
     * 获取组件
     * TODO
     */
    
    public function getComponent($selProcName,Request $request)
    {
        $components = null;
        if($selProcName == '0'){
            // var_dump($selProcName);die(0);
            //组件ID
            $procCompId = ProcToComp::select('comp_id')->get();
            //组件名
            for ($i=0; $i < count($procCompId);$i++){
                //foreach($procCompId as $id){
                //组件名称
                $procCompName[$i] = Component::select('comp_name')->where("id",$procCompId[$i]->comp_id)->get();
                //组件版本
                $procVerNum[$i] = Version::select('ver_num')->where("comp_id",$procCompId[$i]->comp_id)->where("type","1")->get();
            }
        }else{
//             //产品ID
//             $procID = ItechsProductIndex::select('id')->where("proname",$selProcName)->get();
// //             $procID = $selPr->ocName;
//             //组件ID
// //             $procCompId = ProcToComp::select('comp_id')->where("proid",$procID[0]->id)->get();
//             $procCompId = ProcToComp::select('comp_id')->where("proid",$procID)->get();
            $procID = ItechsProductIndex::select('id')->where("proname",$selProcName)->get();
            //缁勪欢ID
            $procCompId = ProcToComp::select('comp_id')->where("proid",$procID[0]->id)->get();
            for ($i=0; $i < count($procCompId);$i++){
                $components[$i] = Component::select('id','comp_name','latest_vernum')->where("id",$procCompId[$i]->comp_id)->get();
                //组件名称
                $procCompName[$i] = Component::select('comp_name')->where("id",$procCompId[$i]->comp_id)->get();
                //组件版本
                $procVerNum[$i] = Version::select('ver_num')->where("comp_id",$procCompId[$i]->comp_id)->where("type","1")->get();
                $components[$i][0]->ver_num = null;
                $components[$i][0]->ver_num = $procVerNum[$i];
                
            }
            
        }
        
        echo json_encode($components);
    }
    
    /**
     * User: danqi@iscas.ac.cn
     * Date: 2018/11/30
     * Time: 16:10
     * 获取组件版本
     */ 
    public function getVersion()
    {
        $test = array();
        $compID=$_POST['selCompName'];
        $component = $this->componentService->getById($compID);
        $version = $component->Version->where("type",1);
        foreach ($version as $version)
        {
            $test[]= $version->ver_num;
        }
        echo json_encode($test);
    }
  
    /**
     * User: danqi@iscas.ac.cn
     * Date: 2018/12/2
     * Time: 1:59
     * 产品文件获取及拷贝到指定路径下
     */
    function copyFiles($proall_id) {
        $event = ItechsProduct::all()->where("proid",$proall_id);
        
        foreach ($event as $event)
        {
            $filename = $event->profile;
            $oriDir = storage_path() . $event->filepath;
            $dstDir = storage_path() . '/' . $proall_id . '/' . $event->profilepath;
            
            $oriDir = $this->replace_separator($oriDir);
            $dstDir = $this->replace_separator($dstDir);

            if (!file_exists($dstDir)) {
                mkdir($dstDir, 0777, true);
            }
            $dstDir = $dstDir.DIRECTORY_SEPARATOR.$filename;
            $this->exportFile($oriDir, $filename, $dstDir);
        }
    }
    
    function exportFile ($dir, $filename, $dstDir) {
        if(!is_dir($dir)) return false;
        $handle = opendir($dir);
        
        $res = null;
        if($handle){
            while(($fl = readdir($handle)) !== false) {
                $temp = $dir.DIRECTORY_SEPARATOR.$fl;
                 if(is_dir($temp) && $fl!='.' && $fl != '..' && $fl!='.git') {
                     $this->exportFile($temp, $filename, $dstDir);
                 } else {
                     if($fl!='.' && $fl != '..') {
                         if ($filename == $fl) {
//                              var_dump('found:'.$temp.'<br>');
                             if (copy($temp, $dstDir)) {
//                                  var_dump('success:'.$filename);
                                 return true;    
                             }
                         }
                     }
                 }
             }
        }
        return false;
    }
    
    function replace_separator($path) {
        while(stripos($path, '//')) {
            $path=str_replace('//', '/', $path);
        }
        while(stripos($path, '////')) {
            $path=str_replace('////', '/', $path);
        }
        while(stripos($path, '\\')) {
            $path=str_replace('\\', '/', $path);
        }
        while(stripos($path, '\\\\')) {
            $path=str_replace('\\\\', '/', $path);
        }
        while(stripos($path, '/')) {
            $path=str_replace('/', DIRECTORY_SEPARATOR, $path);
        }
        return $path;
    }
    
//     /**
//      * User: danqi@iscas.ac.cn
//      * Date: 2018/12/4
//      * Time: 15:03
//      * 产品打包
//      */ 
//     function addFileToZip($path,$zip){
//         $handler=opendir($path); //打开当前文件夹由$path指定。
//         while(($filename=readdir($handler))!==false){
//             if($filename != "." && $filename != ".."){//文件夹文件名字为'.'和‘..'，不要对他们进行操作
//                 if(is_dir($path."/".$filename)){// 如果读取的某个对象是文件夹，则递归
//                     addFileToZip($path."/".$filename, $zip);
//                 }else{ //将文件加入zip对象
//                     $zip->addFile($path."/".$filename);
//                 }
//             }
//         }
//         @closedir($path);
//     }

  
    /**
     * User: danqi@iscas.ac.cn
     * Date: 2018/12/3
     * Time: 10:10
     * 产品与设备关联，完成关联信息入库productdevices
     */
    function getDevices(Request $request)
    {
//        dd($request);
        $devName = null;
        $procNameToDev = null;
        $procDescriptionToDev = null;
        $procCompId = null;
        $procCompName = null;
        $procVerNum =null;
        $procVerNumNow = null;
        $flag = 0;
        if ($request->get("devsub") != null && $request->get("devname") != null)
        {
            $devName = $request->get("devname");
            $devsub = $request->get("devsub");
            $procIDToDev = ProductDevices::select('proid')->where("devicesname",$devName)->get();
//             dd($procIDToDev[0]->proid);
//             $this->copyFiles($procIDToDev[0]->proid);
            if(count($procIDToDev) != 0)
            {
                //产品名称
                $procNameToDev = ItechsProductIndex::select('proname')->where("id",$procIDToDev[0]->proid)->get();
                //组件ID
                $procCompId = ProductDevices::select('comp_id')->where("proid",$procIDToDev[0]->proid)->where("devicesname",$devName)->get();

                //当前组件版本
                $procVerNumNow = ProductDevices::select('ver_num')->where("proid",$procIDToDev[0]->proid)->where("devicesname",$devName)->get();
                
                for ($i=0; $i < count($procCompId);$i++){
                    //foreach($procCompId as $id){
                    //组件名称
                    $procCompName[$i] = Component::select('comp_name')->where("id",$procCompId[$i]->comp_id)->get();
                    //组件版本
                    $procVerNum[$i] = Version::select('ver_num')->where("comp_id",$procCompId[$i]->comp_id)->where("type","1")->get();

                    //处理产品信息表中与复制文件相关的内容
                    $procCopy = ItechsProduct::all()->where("proid",$procIDToDev[0]->proid)->where("comp_id",$procCompId[$i]->comp_id);
                    
                    if($procCopy->first()->vernum != $procVerNumNow[$i])
                    {
                        
                        foreach ($procCopy as $procCopy)
                        {
                            $procCopy->vernum = $procVerNumNow[$i]->ver_num;
                            $filepath = Version::select('file_path')->where("comp_id",$procCompId[$i]->comp_id)->where("ver_num",$procVerNumNow[$i]->ver_num)->where("type",1)->get();
                            $procCopy->filepath = $filepath[0]->file_path;
                            $procbool = $procCopy->save();
                        }                       
                    }
                }

                $flag = 1;

            }
            else
                $flag = 2;
                
                //                 dd($procCompId);
                
        }
        
        
        if($request->get("modify") != null)
        {
            //新选择版本
            $selVersion = $request->get("selVersion");

            //设备名
            $devName = $request->get("devName");
            //产品ID
            $procIDToDev = ProductDevices::select('proid')->where("devicesname",$devName)->get();
            
            //组件ID
            $procCompId = ProductDevices::select('comp_id')->where("proid",$procIDToDev[0]->proid)->where("devicesname",$devName)->get();
            
            for ($i=0; $i < count($procCompId);$i++){
                
                //处理产品信息表中与复制文件相关的内容
                $procCopy = ItechsProduct::all()->where("proid",$procIDToDev[0]->proid)->where("comp_id",$procCompId[$i]->comp_id);

                if($procCopy->first()->vernum != $selVersion)
                {

                    foreach ($procCopy as $procCopy)
                    {
                        $procCopy->vernum = $selVersion[$i];
                        
                        $filepath = Version::select('file_path')->where("comp_id",$procCompId[$i]->comp_id)->where("ver_num",$selVersion[$i])->where("type",1)->get();
                        
                        $procCopy->filepath = $filepath[0]->file_path;
                        $procbool = $procCopy->save();
                    }

                }
                
                $protodev = ProductDevices::select('id')->where("proid",$procIDToDev[0]->proid)->where("comp_id",$procCompId[$i]->comp_id)->where("devicesname",$devName)->get();
                $productdevices=$this->productdevicesService->getById($protodev);
                $productdevices[0]->ver_num = $selVersion[$i];
                $setProductdevices = $this->productdevicesService->update($productdevices[0]);
            

         }
            
        }
        
        if($request->get("devToproc") != null)
        {
            //新设备名
            $devName = $request->get("devName1");
            //产品名
            $ProcName = $request->get("selProcName");
            $procID = ItechsProductIndex::select('id')->where("proname",$ProcName)->get();
            //组件ID
            $comp_id = $request->get("comp_id");
            
            //组件版本
            $ver_num = $request->get("newSelVersion");
            
            for($i = 0;$i<count($request->newSelVersion);$i++){
                $comp_id1[$i] = $comp_id[$i];
                $ver_num1[$i] = $ver_num[$i];                              
                
                $devToProc = new ProductDevices();
                $devToProc->devicesname = $devName;
                $devToProc->proid = $procID[0]->id;
                $devToProc->comp_id = $comp_id1[$i];
                $devToProc->ver_num = $ver_num1[$i];
                $devbool = $devToProc->save();

                //处理产品信息表中与复制文件相关的内容
                $procCopy = ItechsProduct::all()->where("proid",$procID[0]->id)->where("comp_id",$comp_id1[$i]);
                
                foreach ($procCopy as $procCopy)
                {
                    $procCopy->vernum = $ver_num1[$i];
                    
                    $filepath = Version::select('file_path')->where("comp_id",$comp_id1[$i])->where("ver_num",$ver_num1[$i])->where("type",1)->get();
                    
                    $procCopy->filepath = $filepath[0]->file_path;
                    $procbool = $procCopy->save();
                }

            }


            
        }
        
        $procIndex = ItechsProductIndex::all();
        
        return view('product/devices',compact('procNameToDev','procIndex','devName','flag','procCompId','procCompName','procVerNum','procVerNumNow'));
    }


    function inputIp(Request $request){
        $user_id = Auth::user()->id;
        $ip = $this->ipRecordService->getUserIp($user_id);

        return view('product/inputIp',compact('ip'));

    }

    function sendToEqu(Request $request){

        $ip = $request->get('ip');
        $user_id = Auth::user()->id;
        $saveRes = $this->ipRecordService->setUserIp($user_id, $ip);
        if(!$saveRes){
            $msg = "修改用户存储ip错误！";
            $url = "product/inputIp";
            return view('error', compact("url","msg"));
        }
        
        $this->sendZipToEquip($ip);
        
        // 基本上不会走到这一步就跳转了
        return view('product/inputIp',compact('ip'));

    }


    function sendZipToEquip($ip){
        // 连接FTP
        $config = [
            'host'=>'192.168.15.175',
            'user'=>'admin',
            'pass'=>'123456'
        ];
        if($ip)
            $config['host'] = $ip;
        $ftp = new FTPController($config);
        $result = $ftp->connect();
        // 连接失败就返回，并显示出连接失败信息
        if ( !$result){
            $url = "inputIp?ConnectionError=TRUE";
            echo "<script type='text/javascript'>";
            echo "window.location.href='$url'";
            echo "</script>";
        }

        //连接成功就获取下载config.txt文件，获取设备ID和类型
        $local_file = 'config_down.txt';
        $remote_file='config.txt';
        $equType ="";

        $equId = "";
        if ($ftp->download($local_file,$remote_file)){
            $myfile = fopen("config_down.txt", "r") or die();
            $equType = fgets($myfile);
            $equType = str_replace(array("\r\n"),"",$equType);

            $equId = fgets($myfile);
            fclose($myfile);
            unlink($local_file);
        }

        // 根据设备类型获取关联产品，打包文件并推送
        $procIDToDev = ProductDevices::select('proid')->where('devicesname',$equType)->get();
        if(count($procIDToDev) != 0)
        {
            $procNameToDev = ItechsProductIndex::select('proname')->where("id",$procIDToDev[0]->proid)->get();
            
            $this->copyFiles($procIDToDev[0]->proid);
            
            $zip=new Zipper();
            $path =ItechsProduct::select('profilepath')->where("proid",$procIDToDev[0]->proid)->get();
            $filePath = storage_path(). '/' .$procIDToDev[0]->proid;
            $filePath = $this->replace_separator($filePath);
            $zipName = $procNameToDev[0]->proname . '.zip';
            $zipPath = storage_path() . $zipName;
            $zip->make($zipPath)->add($filePath);
            $zip->close();

            // 推送到设备的zip名称为日期格式的
            $remote_file = 'upload'.'/'.date('Y-m-d-H-i-s').'.zip';
            
            //1月16日，新增推送记录部分
            $mSendRecord = new SendRecord();
            $mSendRecord->device_id = $equId;
            $mSendRecord->device_name = $equType;
            $mSendRecord->proid = $procIDToDev[0]->proid;
            
            //上传文件
            if ($ftp->upload($zipPath,$remote_file)){
                $ftp->close();
                unlink($zipPath);
                $mSendRecord->status = 901;
                $saveRes = $this->sendRecordService->append($mSendRecord);
                //推送成功！
                if($saveRes){

                    //关联api 组件集成
                    $user_id = Auth::user()->id;
                    $comp = ProcToComp::select("comp_id","comp_name")->where("proid",$procIDToDev[0]->proid)->get();
                    for ($i=0;$i<count($comp);$i++){
                        $ver_num[$i] = Version::select("ver_num")->distinct()->where("comp_id",$comp[$i]["comp_id"])->get();
                        for ($j=0;$j<count($ver_num[$i]);$j++){
                            $arr = array(
                                "equipmentIp"=>$ip,
                                "score"=>"95",
                                "moduleVersion"=>$ver_num[$i][$j]["ver_num"],
                                "integratorId"=>$user_id,
                                "moduleName"=>$comp[$i]["comp_name"],
                                "equipmentName"=>$equType,
                                "moduleId"=>$comp[$i]["comp_id"],
                                "equipmentId"=>$equId,
                                "productName"=>$procNameToDev[0]->proname
                            );
                            $ret = $this->apprRecordService->add_integration($arr);
                            Log::info("组件集成:".$ret->msg);
                            Log::info($ret->code);
//                            var_dump($ret,$ver_num[$i][$j]["ver_num"],$comp[$i]["comp_name"],"<br>");
                        }
                    }


                    $url = "inputIp?sendSuccess=TRUE";
                    echo "<script type='text/javascript'>";
                    echo "window.location.href='$url'";
                    echo "</script>";
                }

            }else{

                unlink($zipPath);
                $mSendRecord->status = 900;
                $saveRes = $this->sendRecordService->append($mSendRecord);
                if(!$saveRes){
                    echo "<script type='text/javascript'>alert('上传失败！');</script>";
                }

            }
        }
        else
        {
            // 如果设备没有关联产品，返回并提示
            $ftp->close();
            $url = "inputIp?RelationError=TRUE&equType=".$equType;
            echo "<script type='text/javascript'>";
            echo "window.location.href='$url'";
            echo "</script>";
         }




        $ftp->close();
    }
    
    /**
     * User: danqi@iscas.ac.cn
     * Date: 2018/12/10
     * Time: 16:47
     * 显示全部产品列表信息
     */
    function showProcList()
    {
        $mProcList = ItechsProduct::all();
//         $proname = $mProcList->
//         dd($mProcList);
        return view('product/proclistview',compact('mProcList'));
    }
    
    /**
    * 展示推送记录页面
    * @date: 2019年1月16日 下午10:11:36
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    public function showSendRecord(Request $request){
        $records = $this->sendRecordService->getAllByPage(15, $request);
        return view('product/showsendrec',compact('records'));
    }
    
    /**
    * 依据推送记录生成授权文件
    * @date: 2019年1月17日 下午2:16:00
    * @author: wongwuchiu
    * @param: 推送记录id
    * @return: 
    */
    public function genauthfile($record_id){
        $record = $this->sendRecordService->getById($record_id);
        if ($record->status == 901){
            $time = time();
            $deviceID = $record->device_id;
            $deviceName = $record->device_name;
            $proID = $record->proid;
            $authfileDir = "/app/authfile/";
            $filename = $deviceID . "_" . $time . ".authfile";
//             $filename = "ab.txt";
            $fileURL = storage_path() . $authfileDir . $filename;
            $file = fopen($fileURL,"x");
            $fileContent = $this->authFileCreate($deviceID,$deviceName,$proID);
            if(fwrite($file,$fileContent) == 0){
                fclose($file);
                $msg = "生成授权文件错误!";
                $url = "product/showsendrec";
                return view('error', compact("url","msg"));
            }else {
                fclose($file);
                $record->status = 902;
                $record->authfilepath = $authfileDir . $filename;
                $updateRes = $this->sendRecordService->update($record);
                if(!$updateRes){
                    $msg = "已生成授权文件!";
                    $url = "product/showsendrec";
                    return view('error', compact("url","msg"));
                } else  {
                    $url = "product/showsendrec";
                    return view('success', compact("url"));
                }
                
                
            }
            
            
        } else {
            $msg = "已生成授权文件!";
            $url = "product/showsendrec";
            return view('error', compact("url","msg"));
        }
    }
    
    /**
    * 测试的
    * @date: 2019年1月17日 下午2:39:45
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    public function authFileCreate($deviceID,$deviceName,$proID){
        return "测试用的授权文件：\r\n设备编号：" . $deviceID . "\r\n设备名：" . $deviceName . "\r\n产品编号：" . $proID;
    }
    
    /**
    * 将授权文件传送给设备
    * @date: 2019年1月17日 下午4:27:03
    * @author: wongwuchiu
    * @param: 设备ip地址
    * @return: 
    */
    function sendAuthFileToEquip($ip){
        // 连接FTP
        $config = [
            'host'=>'192.168.15.175',
            'user'=>'admin',
            'pass'=>'123456'
        ];
        if($ip)
            $config['host'] = $ip;
            $ftp = new FTPController($config);
            $result = $ftp->connect();
            // 连接失败就返回，并显示出连接失败信息
            if ( ! $result){
                $url = "authfile?ConnectionError=TRUE";
                echo "<script type='text/javascript'>";
                echo "window.location.href='$url'";
                echo "</script>";
            }
            
            //连接成功就获取下载config.txt文件，获取设备ID和类型
            $local_file = 'config_down.txt';
            $remote_file='config.txt';
            $equType ="";
            
            $equId = "";
            if ($ftp->download($local_file,$remote_file)){
                $myfile = fopen("config_down.txt", "r") or die();
                $equType = fgets($myfile);
                $equType = str_replace(array("\r\n"),"",$equType);
                
                $equId = fgets($myfile);
                fclose($myfile);
                unlink($local_file);
            }
            
            // 根据设备ID获取最新一条的已授权记录
            $record = $this->sendRecordService->getLatestAuthRec($equId);
            
            if($record != null)
            {
                //获取授权文件的路径
                $authFilePath = $record->authfilepath;
                
                $zip=new Zipper();
                $filePath = storage_path(). $authFilePath;
                $filePath = $this->replace_separator($filePath);
                $zipName = $equId . '.zip';
                $zipPath = storage_path() . $zipName;
                $zip->make($zipPath)->add($filePath);
                $zip->close();
                
                // 推送到设备的zip名称为日期格式的
                $remote_file = 'upload'.'/'. $equId . '_' . date('Y-m-d-H-i-s').'.zip';

                //上传文件
                if ($ftp->upload($zipPath,$remote_file)){
                    $ftp->close();
                    unlink($zipPath);
                    $url = "authfile?sendSuccess=TRUE";
                    echo "<script type='text/javascript'>";
                    echo "window.location.href='$url'";
                    echo "</script>";
                    
                }else{
                    unlink($zipPath);
                    echo "<script type='text/javascript'>alert('上传失败！');</script>";
                    
                }
            }
            else
            {
                // 如果设备没有生成过授权文件
                $ftp->close();
                $url = "authfile?RelationError=TRUE&equType=".$equType;
                echo "<script type='text/javascript'>";
                echo "window.location.href='$url'";
                echo "</script>";
            }
            
            $ftp->close();
    }
    
    /**
    * 展示授权页面
    * @date: 2019年1月17日 下午4:52:50
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    function authfile(Request $request){
        $user_id = Auth::user()->id;
        $ip = $this->ipRecordService->getUserIp($user_id);
        return view('product/authfile',compact('ip'));
        
    }
    
    
    /**
    * 接受传送授权问页面的IP并调用传送方法
    * @date: 2019年1月17日 下午4:56:40
    * @author: wongwuchiu
    * @param: 
    * @return: 
    */
    function sendAuthToEqu(Request $request){
        
        $ip = $request->get('ip');
        $user_id = Auth::user()->id;
        $saveRes = $this->ipRecordService->setUserIp($user_id, $ip);
        if(!$saveRes){
            $msg = "修改用户存储ip错误！";
            $url = "product/inputIp";
            return view('error', compact("url","msg"));
        }
        
        
        $this->sendAuthFileToEquip($ip);
        
        // 基本上不会走到这一步就跳转了
        return view('product/authfile',compact('ip'));
        
    }
}
?>
