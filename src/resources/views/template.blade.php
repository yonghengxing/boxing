<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>波形管理平台</title>
<meta name="description" content="##">
<meta name="keywords" content="index">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="renderer" content="webkit">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="Cache-Control" content="no-siteapp" />
<meta name="apple-mobile-web-app-title" content="波形管理" />

<link rel="icon" type="image/png"
	href="{{ asset('assets/i/favicon.png') }}">
<link rel="apple-touch-icon-precomposed"
	href="{{ asset('assets/i/app-icon72x72@2x.png') }}">
<link rel="stylesheet" href="{{ asset('assets/css/amazeui.min.css') }}" />
<link rel="stylesheet"
	href="{{ asset('assets/css/amazeui.datatables.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/echarts.min.js') }}"></script>


</head>

<body data-type="widgets">
	<script src="{{ asset('assets/js/theme.js') }}"></script>
	<div class="am-g tpl-g">
		<!-- 头部 -->
		<header>
			<!-- logo -->
			<div class="am-fl tpl-header-logo">
				<a href="javascript:;"><img src="{{ asset('assets/img/logo.png') }}"
					alt=""></a>
			</div>
			<!-- 右侧内容 -->
			<div class="tpl-header-fluid">
				<!-- 侧边切换 -->
				<div class="am-fl tpl-header-switch-button am-icon-list">
					<span> </span>
				</div>

				<!-- 其它功能-->
				<div class="am-fr tpl-header-navbar">
					<ul>
						<!-- 欢迎语 -->
						<li class="am-text-sm tpl-header-navbar-welcome"><a
							href="javascript:;">欢迎你,{{Auth::user()->true_name}} <span></span>
						</a></li>

						<!-- 退出 -->
						<li class="am-text-sm"><a href="{{ asset('/bxLogout')}}"> <span
								class="am-icon-sign-out"></span> 退出
						</a></li>
					</ul>
				</div>
			</div>

		</header>
		<!-- 风格切换 -->
		<div class="tpl-skiner">
			<div class="tpl-skiner-toggle am-icon-cog"></div>
			<div class="tpl-skiner-content">
				<div class="tpl-skiner-content-title">选择主题</div>
				<div class="tpl-skiner-content-bar">
					<span class="skiner-color skiner-white" data-color="theme-white"></span>
					<span class="skiner-color skiner-black" data-color="theme-black"></span>
				</div>
			</div>
		</div>
		<!-- 侧边导航栏 -->
		<div class="left-sidebar">
			<!-- 用户信息 -->

			<!-- 菜单 -->
			<ul class="sidebar-nav">

				<li class="sidebar-nav-link"><a href="{{ asset('/index')}}"> <i
						class="am-icon-home sidebar-nav-link-logo"></i> 首页
				</a></li>


				@if(Auth::user()->admin || config('app.admin_mode',false) || Auth::user()->user_role == 3000)
				<li class="sidebar-nav-link"><a href="javascript:;"
					class="sidebar-nav-sub-title"> <i
						class="am-icon-users sidebar-nav-link-logo"></i> 用户 <span
						class="am-icon-chevron-down am-fr am-margin-right-sm sidebar-nav-sub-ico"></span>
				</a>
					<ul class="sidebar-nav sidebar-nav-sub">
<!-- 						<li class="sidebar-nav-link"><a href="{{ asset('/user/list')}}"> <span -->
<!-- 								class="am-icon-list sidebar-nav-link-logo"></span> 列表 -->
<!-- 						</a></li> -->
						<li class="sidebar-nav-link"><a href="{{ asset('/user/new')}}"> <span
								class="am-icon-plus sidebar-nav-link-logo"></span> 新增
						</a></li>
						<li class="sidebar-nav-link"><a href="{{ asset('/user/role/0/0')}}"> <span
								class="am-icon-list sidebar-nav-link-logo"></span> 类型列表
						</a></li>
					</ul></li>
				@endif
				@if(Auth::user()->admin || config('app.admin_mode',false) || Auth::user()->user_role == 3000)
				<li class="sidebar-nav-link"><a href="javascript:;"
					class="sidebar-nav-sub-title"> <i
						class="am-icon-sitemap sidebar-nav-link-logo"></i>单位<span
						class="am-icon-chevron-down am-fr am-margin-right-sm sidebar-nav-sub-ico"></span>
				</a>
					<ul class="sidebar-nav sidebar-nav-sub">
						<li class="sidebar-nav-link"><a href="{{ asset('/group/new')}}"> <span
								class="am-icon-plus sidebar-nav-link-logo"></span> 新增
						</a></li>
						<li class="sidebar-nav-link"><a href="{{ asset('/group/list')}}">
								<span class="am-icon-list sidebar-nav-link-logo"></span> 列表
						</a></li>
					</ul></li>
				@endif
				@if(Auth::user()->admin || config('app.admin_mode',false))
				<li class="sidebar-nav-link"><a href="javascript:;"
					class="sidebar-nav-sub-title"> <i
						class="am-icon-sitemap sidebar-nav-link-logo"></i>组件<span
						class="am-icon-chevron-down am-fr am-margin-right-sm sidebar-nav-sub-ico"></span>
				</a>
					<ul class="sidebar-nav sidebar-nav-sub">
						<li class="sidebar-nav-link"><a href="{{ asset('/component/new')}}"> <span
								class="am-icon-plus sidebar-nav-link-logo"></span> 新增
						</a></li>
						<li class="sidebar-nav-link"><a href="{{ asset('/component/list/0/0')}}">
								<span class="am-icon-list sidebar-nav-link-logo"></span> 列表
						</a></li>
						<li class="sidebar-nav-link"><a href="{{ asset('/template/show/100')}}"> <span
								class="am-icon-plus sidebar-nav-link-logo"></span> 审批模板
						</a></li>
						<li class="sidebar-nav-link"><a href="{{ asset('/moban/show/100/10000')}}"> <span
								class="am-icon-plus sidebar-nav-link-logo"></span> 审批模板(新的)
						</a></li>
					</ul></li>
				@endif
				@if(Auth::user()->admin || config('app.admin_mode',false) || Auth::user()->user_role == 1000)
				<li class="sidebar-nav-link"><a href="javascript:;"
					class="sidebar-nav-sub-title"> <i
						class="am-icon-paper-plane sidebar-nav-link-logo"></i> 开发方入库 <span
						class="am-icon-chevron-down am-fr am-margin-right-sm sidebar-nav-sub-ico"></span>
				</a>
					<ul class="sidebar-nav sidebar-nav-sub">
						<li class="sidebar-nav-link"><a href="{{ asset('/developer/complist/0/0/1001')}}"> <span
								class="am-icon-list sidebar-nav-link-logo"></span> 组件列表
						</a></li>
						<li class="sidebar-nav-link"><a href="{{ asset('/developer/eventlist')}}"> <span
								class="am-icon-list sidebar-nav-link-logo"></span> 我的入库记录
						</a></li>
					</ul></li>
				@endif
				@if(Auth::user()->admin || config('app.admin_mode',false) || Auth::user()->user_role == 2000)
				<li class="sidebar-nav-link"><a href="javascript:;"
					class="sidebar-nav-sub-title"> <i
						class="am-icon-share-square-o sidebar-nav-link-logo"></i> 组件测试 <span
						class="am-icon-chevron-down am-fr am-margin-right-sm sidebar-nav-sub-ico"></span>
				</a>
					<ul class="sidebar-nav sidebar-nav-sub">
						<li class="sidebar-nav-link"><a href="{{ asset('/tester/complist/0/0')}}"> <span
								class="am-icon-list sidebar-nav-link-logo"></span> 组件列表
						</a></li>
						<li class="sidebar-nav-link"><a href="{{ asset('/tester/eventlist')}}"> <span
								class="am-icon-list sidebar-nav-link-logo"></span> 我的测试列表
						</a></li>
					</ul></li>
				@endif
				@if(Auth::user()->admin || config('app.admin_mode',false) || Auth::user()->user_role == 3000)	
				<li class="sidebar-nav-link"><a href="javascript:;"
					class="sidebar-nav-sub-title"> <i
						class="am-icon-cubes sidebar-nav-link-logo"></i> 审批事件 <span
						class="am-icon-chevron-down am-fr am-margin-right-sm sidebar-nav-sub-ico"></span>
				</a>
					<ul class="sidebar-nav sidebar-nav-sub">
						<li class="sidebar-nav-link"><a href="{{ asset('/approver/complist/0/0')}}"> <span
								class="am-icon-list sidebar-nav-link-logo"></span> 组件列表
						</a></li>
						<li class="sidebar-nav-link"><a href="{{ asset('/approver/eventlist')}}"> <span
								class="am-icon-list sidebar-nav-link-logo"></span> 我的审批记录
						</a></li>
					</ul></li>
				@endif
				@if(Auth::user()->admin || config('app.admin_mode',false) || Auth::user()->user_role == 1000 || Auth::user()->user_role == 2000)
				<li class="sidebar-nav-link"><a href="javascript:;"
					class="sidebar-nav-sub-title"> <i
						class="am-icon-exclamation-circle sidebar-nav-link-logo"></i> 问题 <span
						class="am-icon-chevron-down am-fr am-margin-right-sm sidebar-nav-sub-ico"></span>
				</a>
					<ul class="sidebar-nav sidebar-nav-sub">
						<li class="sidebar-nav-link"><a
							href="{{ asset('/issue/list')}}"> <span
								class="am-icon-list sidebar-nav-link-logo"></span> 列表
						</a></li>
					</ul></li>
				@endif
				@if(Auth::user()->admin || config('app.admin_mode',false) || Auth::user()->user_role == 4000)
				<li class="sidebar-nav-link"><a href="javascript:;"
					class="sidebar-nav-sub-title"> <i
						class="am-icon-cubes sidebar-nav-link-logo"></i> 产品库 <span
						class="am-icon-chevron-down am-fr am-margin-right-sm sidebar-nav-sub-ico"></span>
				</a>
<!-- 					<ul class="sidebar-nav sidebar-nav-sub"> -->
<!-- 						<li class="sidebar-nav-link"><a href="{{ asset('/product/show')}}"> <span -->
<!-- 								class="am-icon-list sidebar-nav-link-logo"></span> 产品创建 -->
<!-- 						</a></li> -->
<!-- 					</ul> -->
<!-- 					<ul class="sidebar-nav sidebar-nav-sub"> -->
<!-- 						<li class="sidebar-nav-link"><a href="{{ asset('/product/proclistview')}}"> <span -->
<!-- 								class="am-icon-list sidebar-nav-link-logo"></span> 产品模板详情 -->
<!-- 						</a></li> -->
<!-- 					</ul> -->
					<ul class="sidebar-nav sidebar-nav-sub">
						<li class="sidebar-nav-link"><a href="{{ asset('/product/newproc')}}"> <span
								class="am-icon-list sidebar-nav-link-logo"></span> 产品创建
						</a></li>
					</ul>
					<ul class="sidebar-nav sidebar-nav-sub">
						<li class="sidebar-nav-link"><a href="{{ asset('/product/proceditlist/0')}}"> <span
								class="am-icon-list sidebar-nav-link-logo"></span> 产品详情
						</a></li>
					</ul></li>
					
					@endif
				@if(Auth::user()->admin || config('app.admin_mode',false) || Auth::user()->user_role == 4000 || Auth::user()->user_role == 5000)
				<li class="sidebar-nav-link"><a href="javascript:;"
					class="sidebar-nav-sub-title"> <i
						class="am-icon-cubes sidebar-nav-link-logo"></i> 设备处理 <span
						class="am-icon-chevron-down am-fr am-margin-right-sm sidebar-nav-sub-ico"></span>
				</a>
					<ul class="sidebar-nav sidebar-nav-sub">
						<li class="sidebar-nav-link"><a href="{{ asset('/product/devices')}}"> <span
								class="am-icon-list sidebar-nav-link-logo"></span> 设备产品关联
						</a></li>
					</ul>
					<ul class="sidebar-nav sidebar-nav-sub">
						<li class="sidebar-nav-link"><a href="{{ asset('/product/inputIp')}}"> <span
										class="am-icon-list sidebar-nav-link-logo"></span> 推送产品文件到设备
							</a></li>
					</ul>
					<ul class="sidebar-nav sidebar-nav-sub">
						<li class="sidebar-nav-link"><a href="{{ asset('/product/showsendrec')}}"> <span
								class="am-icon-list sidebar-nav-link-logo"></span> 产品推送记录
						</a></li>
					</ul>
					<ul class="sidebar-nav sidebar-nav-sub">
						<li class="sidebar-nav-link"><a href="{{ asset('/product/authfile')}}"> <span
								class="am-icon-list sidebar-nav-link-logo"></span> 推送授权文件到设备
						</a></li>
					</ul>
				</li>
				@endif
				@if(Auth::user()->admin || config('app.admin_mode',false))
				<li class="sidebar-nav-link"><a href="javascript:;"
					class="sidebar-nav-sub-title"> <i
						class="am-icon-exclamation-circle sidebar-nav-link-logo"></i> 设定 <span
						class="am-icon-chevron-down am-fr am-margin-right-sm sidebar-nav-sub-ico"></span>
				</a>
					<ul class="sidebar-nav sidebar-nav-sub">
						<li class="sidebar-nav-link"><a
							href="{{ asset('/typesetting/showcomp')}}"> <span
								class="am-icon-list sidebar-nav-link-logo"></span> 设定组件类型
						</a></li>
					</ul>
					<ul class="sidebar-nav sidebar-nav-sub">
						<li class="sidebar-nav-link"><a
							href="{{ asset('/typesetting/showuser')}}"> <span
								class="am-icon-list sidebar-nav-link-logo"></span> 设定人员角色
						</a></li>
					</ul>
				</li>
				@endif

			</ul>
		</div>

		<!-- 内容区域 -->
		<div class="tpl-content-wrapper">@yield('content')</div>

	</div>
	<script src="{{ asset('assets/js/amazeui.min.js') }}"></script>
	<script src="{{ asset('assets/js/amazeui.datatables.min.js') }}"></script>
	<script src="{{ asset('assets/js/dataTables.responsive.min.js') }}"></script>
	<script src="{{ asset('assets/js/app.js') }}"></script>
</body>

</html>