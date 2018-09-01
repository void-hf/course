@extends('admin.layouts.layout')
@section('title')
    登陆
@endsection
@section('css')
	<link rel="stylesheet" type="text/css" href="/static/admin/css/login.css" />
@endsection
@section('content')
        <div class="m-login-bg">
			<div class="m-login">
				<h3>后台系统登录</h3>
				<div class="m-login-warp">
					<form class="layui-form">
						@csrf
						<div class="layui-form-item">
							<input type="text" name="username" required lay-verify="required" placeholder="用户名" autocomplete="off" class="layui-input">
						</div>
						<div class="layui-form-item">
							<input type="text" name="password" required lay-verify="required" placeholder="密码" autocomplete="off" class="layui-input">
						</div>
						{{--<div class="layui-form-item">--}}
							{{--<div class="layui-inline">--}}
								{{--<input type="text" name="verity" required lay-verify="required" placeholder="验证码" autocomplete="off" class="layui-input">--}}
							{{--</div>--}}
							{{--<!-- <div class="layui-inline">--}}
								{{--<img class="verifyImg" onclick="this.src=this.src+'?c='+Math.random();" src="/static/admin/images/login/yzm.jpg" />--}}
							{{--</div> -->--}}
						{{--</div>--}}
						<div class="layui-form-item m-login-btn">
							<div class="layui-inline">
								<button class="layui-btn layui-btn-normal" lay-submit lay-filter="login">登录</button>
							</div>
							<div class="layui-inline">
								<button type="reset" class="layui-btn layui-btn-primary">取消</button>
							</div>
						</div>
					</form>
				</div>
				<p class="copyright">Copyright 2015-2016 by XIAODU</p>
			</div>
		</div>
@endsection

@section('script')
        <script>
			layui.use(['form', 'layedit', 'laydate'], function() {
				var form = layui.form,
                    layer = layui.layer,
                    $ = layui.jquery,
                    common = layui.common,
                    tool = layui.tool;

				//自定义验证规则
				form.verify({
					title: function(value) {
						if(value.length < 5) {
							return '标题至少得5个字符啊';
						}
					},
					password: [/(.+){6,12}$/, '密码必须6到12位'],
					verity: [/(.+){6}$/, '验证码必须是6位'],

				});

				//监听提交
				form.on('submit(login)', function(data) {
					$.post('/admin/login',data.field,function (res) {
                        if(res.status){
                            layer.msg(res.msg, {time: 2000});
                            window.location.href = "/admin/index";
                        }else{
                            layer.msg(res.msg, {time: 2000});
                        }
                    });
					return false;
				});

			});
		</script>
@endsection
