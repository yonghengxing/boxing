<?php
/**
 * 公司service
 * @date: 2018年11月19日 下午5:05:46
 * @author: wongwuchiu
 */
namespace App\Services;
use App\Services\BaseService;
use App\Models\ApprNode;

class ApprNodeService extends BaseService
{
    function __construct(ApprNode $apprNode){
        $this->model = $apprNode;
    }
    
    /**
    * 依据审批模板查找当前审批层次节点的对应节点号
    * @date: 2018年11月22日 下午2:45:29
    * @author: wongwuchiu
    * @param: 审批层次level，产品类别comp_type
    * @return: 节点id
    */
    public function getApprNode($comp_type,$level){
        $node = $this->model->where("comp_type",$comp_type)->where("level",$level)->first();
        if ($node == null){
            return 0;
        } else {
            return $node->id;    
        }
    }
    
    /**
     * 获取某一类型的审批节点
     * @date: 2018年11月22日 下午2:45:29
     * @author: wongwuchiu
     * @param: 审批层次level，产品类别comp_type
     * @return: 节点id
     */
    public function getApprNodeList($comp_type){
        $nodes = $this->model->where("comp_type",$comp_type)->get();
        return $nodes;
    }
    
    /**
     * 获取某一类型的激活的审批节点
     * @date: 2018年11月22日 下午2:45:29
     * @author: wongwuchiu
     * @param: 审批层次level，产品类别comp_type
     * @return: 节点id
     */
    public function getActiveNodeList($comp_type){
        $nodes = $this->model->where("comp_type",$comp_type)->where("active",1)->get();
        return $nodes;
    }
    
    /**
     * 依据组件类型查找对应组建类型模板的入口节点
     * @date: 2018年11月22日 下午2:45:29
     * @author: wongwuchiu
     * @param: 审批层次level，产品类别comp_type
     * @return: 节点id
     */
    public function getFirstActiveNode($comp_type){
        $node = $this->model->where("comp_type",$comp_type)->where("level",1)->where("active",1)->first();
        if ($node == null){
            return 0;
        } else {
            return $node->id;
        }
    }
    
}

?>