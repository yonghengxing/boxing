<?php
/**
 * 组件状态service
 * @date: 2018年11月19日 下午5:05:46
 * @author: wongwuchiu
 */
namespace App\Services;
use App\Services\BaseService;
use App\Models\Component;

class ComponentService extends BaseService
{
    function __construct(Component $component){
        $this->model = $component;
    }
    
    /**
    * 组件新增一条待审核事件，设置状态为有新审核事件
    * @date: 2018年11月21日 下午7:24:50
    * @author: wongwuchiu
    * @param: 组件id comp_id
    * @return: 
    */
    function apprNew($comp_id){
        $mComp = $this->getById($comp_id);
        $count = $mComp->appr_count;
        $mComp->appr_count = $count + 1;
        $mComp->appr_status = 10001;
        $mComp->appr_updated = date("Y-m-d H:i:s",time());
        $ret = $mComp->save();
        return $ret;
    }
    
    /**
     * 已处理组件待审核事件，检测有无待审核事件并设置状态
     * @date: 2018年11月21日 下午7:24:50
     * @author: wongwuchiu
     * @param: 组件id comp_id
     * @return:
     */
    function apprDone($comp_id){
        $mComp = $this->getById($comp_id);
        $count = $mComp->appr_count;
        if ($count < 1){
            return false;
        } elseif ($count == 1){
            $mComp->appr_count = $count -1;
            $mComp->appr_status = 10000;
            $mComp->appr_updated = date("Y-m-d H:i:s",time());
            $ret = $mComp->save();
            return $ret;
        } else {
            $mComp->appr_count = $count - 1;
            $mComp->appr_updated = date("Y-m-d H:i:s",time());
            $ret = $mComp->save();
            return $ret;
        }
        return false;
    }
    
    /**
     * 组件新增一待测试版本，设置状态为有新待测试版本
     * @date: 2018年11月21日 下午7:24:50
     * @author: wongwuchiu
     * @param: 组件id comp_id
     * @return:
     */
    function testNew($comp_id){
        $mComp = $this->getById($comp_id);
        $count = $mComp->test_count;
        $mComp->test_count = $count + 1;
        $mComp->test_status = 2001;
        $mComp->test_updated = date("Y-m-d H:i:s",time());
        $ret = $mComp->save();
        return $ret;
    }
    
    /**
     * 已测试一个组件新版本，检测有无待测试的版本并设置状态
     * @date: 2018年11月21日 下午7:24:50
     * @author: wongwuchiu
     * @param: 组件id comp_id
     * @return:
     */
    function testDone($comp_id){
        $mComp = $this->getById($comp_id);
        $count = $mComp->test_count;
//         dd($count);
        if ($count < 1){
            return false;
        } elseif ($count == 1){
            $mComp->test_count = $count -1;
            $mComp->test_status = 2000;
            $mComp->test_updated = date("Y-m-d H:i:s",time());
            $ret = $mComp->save();
            return $ret;
        } else {
            $mComp->test_count = $count - 1;
            $mComp->test_updated = date("Y-m-d H:i:s",time());
            $ret = $mComp->save();
            return $ret;
        }
        return false;
    }
    
    /**
     * 组件入库审核中，设置状态为不可上传
     * @date: 2018年11月21日 下午7:24:50
     * @author: wongwuchiu
     * @param: 组件id comp_id
     * @return:
     */
    function devLock($comp_id){
        $mComp = $this->getById($comp_id);
        $mComp->dev_import = 1000;
        $ret = $mComp->save();
        return $ret;
    }
    
    /**
     * 组件入库审核结束，设置状态为可上传
     * @date: 2018年11月21日 下午7:24:50
     * @author: wongwuchiu
     * @param: 组件id comp_id
     * @return:
     */
    function devUnlock($comp_id){
        $mComp = $this->getById($comp_id);
        $mComp->dev_import = 1001;
        $ret = $mComp->save();
        return $ret;
    }
    
    
}

?>