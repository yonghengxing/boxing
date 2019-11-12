<?php
/**
 * 公司service
 * @date: 2018年11月19日 下午5:05:46
 * @author: wongwuchiu
 */
namespace App\Services;
use App\Services\BaseService;
use App\Models\SendRecord;

class SendRecordService extends BaseService
{
    function __construct(SendRecord $sendRecord){
        $this->model = $sendRecord;
    }
    
    public function getLatestAuthRec($device_id){
        $latestRecord = $this->model->where("device_id",$device_id)->where("status",902)->orderByDesc("created_at")->first();
        return $latestRecord;
    }
}

?>