<?php
/**
 * 审批节点组员service
 * @date: 2018年11月19日 下午5:05:46
 * @author: wongwuchiu
 */
namespace App\Services;
use App\Services\BaseService;
use App\Models\ApprGroup;

class ApprGroupService extends BaseService
{
    function __construct(ApprGroup $apprGroup){
        $this->model = $apprGroup;
    }
    
    /**
     * 检查特定的审批人员是否是一个特定的组员
     * @date: 2018年11月22日 下午2:45:29
     * @author: wongwuchiu
     * @param: 审批人员approver_id，审批节点组号apprNode_id
     * @return: 节点id
     */
    public function isInNode($approver_id,$node_id){
        $res = $this->model->where("approver_id",$approver_id)->where("node_id",$node_id)->first();
        if($res == null){
            return false;
        } else {
            return true;
        }
    }
    
    public function getNodeUsers($node_id){
        $users = $this->model->where("node_id",$node_id)->get();
        $nodeUsers = array();
        foreach ($users as $user){
            $appr_id = $user->approver_id;
            $nodeUsers[] = $appr_id;
        }
        return $nodeUsers;
    }
    
}

?>