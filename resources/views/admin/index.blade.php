@extends('admin.layouts.layout')
@section('title')
    首页
@endsection
@section('content')
        <div class="main-layout" id='main-layout'>
			<!--侧边栏-->
			<div class="main-layout-side">
				<div class="m-logo">
				</div>
				<ul class="layui-nav layui-nav-tree" lay-filter="leftNav">
                    <!--   <li class="layui-nav-item layui-nav-itemed">
                        <a href="javascript:;"><i class="iconfont">&#xe607;</i>菜单管理</a>
                        <dl class="layui-nav-child">
                          <dd><a href="javascript:;" data-url="menu1.html" data-id='1' data-text="后台菜单"><span class="l-line"></span>后台菜单</a></dd>
                          <dd><a href="javascript:;" data-url="menu2.html" data-id='2' data-text="前台菜单"><span class="l-line"></span>前台菜单</a></dd>
                        </dl>
                      </li>-->
				  <li class="layui-nav-item">
				    <a href="javascript:;"><i class="iconfont">&#xe60a;</i>管理员管理</a>
				    <dl class="layui-nav-child">
				      <dd>
				      	<a href="javascript:;" id="/admin/user-list" data-id='2' data-text="用户列表">
				      	<span class="l-line"></span>管理员列表</a>
				      </dd>
				      <dd>
				      	<a href="javascript:;" id="/admin/permissions-list" data-id='3' data-text="权限列表">
				      	<span class="l-line"></span>权限列表</a>
				      </dd>
				      <dd>
				      	<a href="javascript:;" id="/admin/roles-list" data-id='4' data-text="角色列表">
				      	<span class="l-line"></span>角色列表</a>
				      </dd>
				    </dl>
				  </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;"><i class="iconfont">&#xe60a;</i>课程管理</a>
                        <dl class="layui-nav-child">
                            <dd>
                                <a href="javascript:;" id="/admin/courses/category-list" data-id='5' data-text="分类设置">
                                    <span class="l-line"></span>分类设置</a>
                            </dd>
                            <dd>
                                <a href="javascript:;" id="/admin/courses/school-list" data-id='6' data-text="学校管理">
                                    <span class="l-line"></span>学校管理</a>
                            </dd>
                            <dd>
                                <a href="javascript:;" id="/admin/courses/series-list" data-id='7' data-text="系列管理">
                                    <span class="l-line"></span>系列管理</a>
                            </dd>
                            <dd>
                                <a href="javascript:;" id="/admin/courses/activity-list" data-id='8' data-text="活动管理">
                                    <span class="l-line"></span>活动管理</a>
                            </dd>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;" id="/admin/travel/travel-list" data-id='95' data-text="行程列表"><i
                                class="iconfont">&#xe600;</i>行程列表</a>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;" id="/admin/travel/systemsetting" data-id='99' data-text="系统设置"><i
                                class="iconfont">&#xe60b;</i>系统设置</a>
                    </li>

<!--                    <li class="layui-nav-item">-->
<!--                        <a href="javascript:;" data-url="system.html" data-id='98' data-text="备份管理"><i class="iconfont">&#xe600;</i>备份管理</a>-->
<!--                    </li>-->

                        </ul>
                    </div>
                    右侧内容-->
			<div class="main-layout-container">
				<!--头部-->
				<div class="main-layout-header">
					<div class="menu-btn" id="hideBtn">
						<a href="javascript:;">
							<span class="iconfont">&#xe60e;</span>
						</a>
					</div>
					<ul class="layui-nav" lay-filter="rightNav">
					  <li class="layui-nav-item"><a style="font-size: 18px;color: #0C0C0C;" href="javascript:outLogin();">退出</a></li>
					</ul>
				</div>
				<!--主体内容-->
				<div class="main-layout-body">
					<!--tab 切换-->
					<div class="layui-tab layui-tab-brief main-layout-tab" lay-filter="tab" lay-allowClose="true">
					  <ul class="layui-tab-title">
					    <li class="layui-this welcome">后台主页</li>
					  </ul>
					  <div class="layui-tab-content">
					    <div class="layui-tab-item layui-show" style="background: #f5f5f5;">
					    	<!--1-->
					    	<iframe src="/admin/main" width="100%" height="100%" name="iframe" scrolling="auto" class="iframe" framborder="0"></iframe>
					    	<!--1end-->
					    </div>
					  </div>
					</div>
				</div>
			</div>
			<!--遮罩-->
			<div class="main-mask">
			</div>
		</div>
@endsection
@section('script')
        <script src="/static/admin/js/main.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript">
			var scope={
				link:'/admin/main'
			}
            function outLogin() {
                $.ajax({
                    type: "POST",
                    url: "/admin/outlogin",
                    data:{'_token':'{{ csrf_token() }}'},
                    dataType: "json",
                    success: function (data) {
                        if (data.status == 0) {
                            dialog.error(data.msg);
                        } else if (data.status == 1) {
                            dialog.success(data.msg, "/admin/index");
                        }
                    }
                });
            }
		</script>
@endsection
