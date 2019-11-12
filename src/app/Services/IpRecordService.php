<?php
/**
 * 组件类型人员角色设置service
 * @date: 2018年11月19日 下午5:05:46
 * @author: wongwuchiu
 */
namespace App\Services;
use App\Services\BaseService;
use App\Models\IpRecord;

class IpRecordService extends BaseService
{
    function __construct(IpRecord $ipRecord){
        $this->model = $ipRecord;
    }
    
    public function getUserIp($user_id){
        $ipRecord = $this->model->where("user_id",$user_id)->first();
        if($ipRecord == null){
            return "";
        } else {
            return $ipRecord->ip_str;
        }
    }
    
    public function setUserIp($user_id,$ip_str){
        $ipRecord = $this->model->where("user_id",$user_id)->first();
        if($ipRecord == null){
            $nIpRecord = new IpRecord();
            $nIpRecord->user_id = $user_id;
            $nIpRecord->ip_str = $ip_str;
            $saveRes = $nIpRecord->save();
            return $saveRes;
        } else {
            $ipRecord->ip_str = $ip_str;
            $saveRes = $ipRecord->save();
            return $saveRes;
        }
    }
}

?>