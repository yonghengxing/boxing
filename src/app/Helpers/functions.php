<?php


//全局帮助函数
//@lee 20170222

//申报单状态转换,
//不在前端页面直接用$config_request_status[$status]是因为，数据库中的status字段并不都是有效数据，或导致空索引出现
function decodeRequestStatus($status)
{
	$config_request_status = config('app.request_status');
	if (isset($config_request_status[$status])) {
		# code...
		return $config_request_status[$status];
	} else {
		# code...
		return '';
	}
}

//解析工作评价级别
function decodeWorkLevel($level)
{	
	$config_work_level = $_SESSION['work_level'];
	if (isset($config_work_level[$level])) {
	 	return $config_work_level[$level];
	} else {
		return [
			'title' => 'unknown',
		];
	}
}


function decodeResultLevel($level)
{
	$config_work_level = $_SESSION['work_level_ach'];
	if (isset($config_work_level[$level-1])) {
		return $config_work_level[$level-1];
	} else {
		return [
				'title' => 'unknown',
		];
	}
}


function getScoreeRange($level,$score)
{

	$scrArr = array();
	$config_work_level = $_SESSION['work_level'];
	if (isset($config_work_level[$level])) {
		$up = $config_work_level[$level]["score"]["up"];
		//var_dump($up);
		$low = $config_work_level[$level]["score"]["low"];
		//var_dump($low);
		while($low<=$up){
			
			if(strval($low) != strval($score)){
				$scrArr[] = floatval($low);
			}
			$low = $low + 0.1;
		}
		//var_dump($scrArr);
		return $scrArr;
	} 
	return $scrArr;
}


function getCGScoreeRange($level,$score)
{
	$level = $level-1;
	$scrArr = array();
	$config_work_level = $_SESSION['work_level_ach'];
	if (isset($config_work_level[$level])) {
		$up = $config_work_level[$level]["score"]["up"];
		//var_dump($up);
		$low = $config_work_level[$level]["score"]["low"];
		//var_dump($low);
		while($low<=$up){
				
			if(strval($low) != strval($score)){
				$scrArr[] = floatval($low);
			}
			$low = $low + 0.1;
		}
		//var_dump($scrArr);
		return $scrArr;
	}
	return $scrArr;
}


?>