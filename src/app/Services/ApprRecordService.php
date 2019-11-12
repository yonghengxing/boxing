<?php
/**
 * 公司service
 * @date: 2018年11月19日 下午5:05:46
 * @author: wongwuchiu
 */
namespace App\Services;
use App\Services\BaseService;
use App\Models\ApprRecord;

class ApprRecordService extends BaseService
{
    function __construct(ApprRecord $apprRecord){
        $this->model = $apprRecord;
    }

    /**
     * @param $file_path
     * @return bool|string
     * 添加指纹
     */
    function add_fingerprint($file_path){
        $url2 = 'http://localhost:8080/ssdeep';
        $params = array('path' => $file_path);
        if (strripos('?', $url2)) {
            $url = $url2 . http_build_query($params);
        } else {
            $url = $url2 . '?' . http_build_query($params);
        }
        $curlobj = curl_init();
        curl_setopt($curlobj, CURLOPT_URL, $url);
        curl_setopt($curlobj, CURLOPT_HEADER, 0);
        curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, 1);
        $ret = curl_exec($curlobj);
        curl_close($curlobj);
        return $ret;
    }

    /**
     * post请求
     * @param $arr
     * @param $url
     * @return mixed
     */
    function api_post($arr,$url){
        //json也可以
        $data_string =  json_encode($arr);
        //普通数组也行
        //$data_string = $arr;

//        echo $data_string;
        //echo '<br>';

        //curl验证成功
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string)
        ));

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            print curl_error($ch);
        }
        curl_close($ch);

        $result_new = json_decode($result);
        return $result_new;
    }

    /**
     * 组件入库
     * @param $arr
     * @return mixed
     */
    function add_storage($arr){
        $ret = $this->api_post($arr,"http://localhost:8080/storage");
        return $ret;
    }


    /**
     * 组件集成
     * @param $arr
     * @return mixed
     */
    function add_integration($arr){
        $ret = $this->api_post($arr,"http://localhost:8080/integration");
        return $ret;
    }

}

?>
