<?php
namespace App\Services;

use GuzzleHttp\Client;
use Log;
use App\Repositories\ProjectRepository;
use App\Models\Project;
use Carbon\Carbon;
/**
 * 
 * 
 * @author shoubin@iscas.ac.cn
 *
 */
class ProjectService
{
    function __construct(ProjectRepository $projectRepository){
        $this->projectRepository = $projectRepository;
//         $this->git_secret = config("app.git_secret");
//         $this->api_host = config("app.git_api_host") ;
//         $this->api = new Client([
//             //根域名
//             'base_uri'  => $this->api_host,
//             // 超时
//             'timeout'   => 5.0,
//             'verify'    => false,
//             'headers'   =>  [
//                 'PRIVATE-TOKEN'  => $this->git_secret
//             ],
//         ]);
//         Log::debug('app.git_secret: ' . $this->git_secret);
//         Log::debug('app.$api_host: '  . $this->api_host);
    }
    
    function getProjectList() {
        $projects =  $this->projectRepository->getAll();
        return  $projects;
    }
    function  getProjectInfo($projectId){
        $project =  $this->projectRepository->getById($projectId);
        return  $project;
    }
    
    function addProject($project){
     
        $this->projectRepository->save($project);
        return true;
    }
    function deleteProject($project_id){
        $this->projectRepository->delete($project_id);
        return true;
    }
    
    /**
     * 向数据库追加记录并获取添加后的id
     * @date: 2018年11月21日 下午8:10:52
     * @author: wongwuchiu
     * @param: 要追加的model
     * @return: 添加成功返回id，否则返回0
     */
    public function appendID($tModel)
    {
        $res =  $this->projectRepository->save($tModel);
        $id = 0;
        if($res){
            $id = $tModel->id;
        }
        return $id;
    }
}

?>