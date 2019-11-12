@extends('template') @section('content')


            <div class="row-content am-cf">
<!--                 <div class="widget am-cf"> -->
<!--                     <div class="widget-body"> -->
<!--                         <div class="tpl-page-state"> -->
<!--                             <div class="tpl-page-state-title am-text-center tpl-error-title">success</div> -->
<!--                             <div class="tpl-error-title-info">操作成功</div> -->
<!--                             <div class="tpl-page-state-content tpl-error-content"> -->
<!--                                 <p id="tips">页面跳转中</p> -->
<!--                                 <a href="{{asset('')}}{{$url}}" class="am-btn am-btn-secondary am-radius tpl-error-btn">点击跳转</a></div> -->
<!--                         </div> -->
<!--                     </div> -->
<!--                 </div> -->
                <script type="text/javascript">
                	onload = function() {
//                 		setInterval(go, 1000);
                		go();
                	};
                	var x = 3; //利用了全局变量来执行  
                	function go() {
//                     	$("#tips").text("页面跳转中... "+ x);
//                 		x--;
//                 		if (x > 0) {
//                 			document.getElementById("sp").innerHTML = x; //每次设置的x的值都不一样了。  
//                 		} else {
//                 			location.href = '{{asset('')}}{{$url}}';
//                 		}
                		location.href = '{{asset('')}}{{$url}}';
                	}
                </script>
@stop
