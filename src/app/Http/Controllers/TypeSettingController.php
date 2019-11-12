<?php
/**
 * User: shoubin@iscas.ac.cn
 * Date: 2018/10/14
 * Time: 17:17
 */

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Contracts\View\View;
use App\Models\TypeSetting;
use Illuminate\Http\Request;
use App\Services\TypeSettingService;
use Illuminate\Support\Facades\Auth;


class TypeSettingController extends BaseController
{
    
    
    function __construct(TypeSettingService $tsService){
        $this->middleware('auth');
        $this->tsService = $tsService;
    }
    
    public function type_showcomp()
    {
        $types = $this->tsService->getCompAll();
        return view('typesetting/showcomp', compact("types"));
    }
    
    public function type_showuser()
    {
        $types = $this->tsService->getUserAll();
        return view('typesetting/showuser', compact("types"));
    }
    
    //2018_10_30,创建新公司
    public function type_new($type)
    {
        return view('typesetting/newtype', compact("type"));
    }
    
    public function type_new_do($type,Request $request)
    {
        $name = $request->get("name");
        $mType = new TypeSetting;
        $mType->name = $name;
        $mType->type = $type;
        $saveRes = $this->tsService->append($mType);
        $url = null;
        if ($type == 0){
            $url="typesetting/showcomp";
        } else {
            $url="typesetting/showuser";
        }
        if(!$saveRes){            
            $msg = "新建失败";
            return view('error', compact("url","msg"));
        } else {
            return view('success', compact("url"));
        }
    }
    
    //2018_10_30，删除公司
    public function type_delete($type_id){
        $mType = $this->tsService->getById($type_id);
        $type = $mType->type;
        if ($type == 0){
            $url="typesetting/showcomp";
        } else {
            $url="typesetting/showuser";
        }
        $deleteRes = $this->tsService->delete($type_id);
        if(!$deleteRes){
            $msg = "新建失败";
            return view('error', compact("url","msg"));
        } else {
            return view('success', compact("url"));
        }
    }
    

}
