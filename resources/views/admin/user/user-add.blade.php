@extends('admin.layouts.layout')
@section('title')
用户添加
@endsection

@section('content')
		<div class="page-content-wrap clearfix">
				<form class="layui-form" id="userform">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="layui-tab">
						<div class="layui-tab-content">
							<div class="layui-tab-item"></div>
							<div class="layui-tab-item layui-show">
								<div class="layui-form-item">
									<label class="layui-form-label">用户名称：</label>
									<div class="layui-input-block">
										<input type="text" name="username" required lay-verify="required" placeholder="请输入用户名称" autocomplete="off" class="layui-input" >
									</div>
								</div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">要修改的密码：</label>
                                    <div class="layui-input-block">
                                        <input type="password" name="password" required lay-verify="required" placeholder="请输入新的密码" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">确认密码：</label>
                                    <div class="layui-input-block">
                                        <input type="password" name="en_password" required lay-verify="required" placeholder="请输入新的密码" autocomplete="off" class="layui-input">
                                    </div>
                                </div>

								<div class="layui-form-item">
									<label class="layui-form-label">是否管理员用户：</label>
									<div class="layui-input-block">
										<select name="is_admin" lay-verify="required">
											<option value="">请选择权限</option>
											<option value="2">是</option>
                                            <option value="1">否</option>
										</select>
									</div>
								</div>

								<div class="layui-form-item">
									<label class="layui-form-label">所属角色：</label>
									<div class="layui-input-block">
										<input type="text" name="roles" placeholder="请输入所属角色" autocomplete="off" class="layui-input">
									</div>
								</div>
								<div class="layui-form-item layui-form-text">
									<label class="layui-form-label">权限：</label>
									<div class="layui-input-block">
                                        <input type="text" name="permissions" placeholder="请输入权限" autocomplete="off" class="layui-input">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="layui-form-item" style="padding-left: 10px;">
						<div class="layui-input-block">
							<button class="layui-btn layui-btn-normal" id="sub" lay-filter="formDemo" type="button">立即提交</button>
                            <a class="layui-btn layui-btn-primary" href="user-list">返回</a>
						</div>
					</div>
				</form>
		</div>
@endsection

@section('script')
		<script type="text/javascript">
            $(document).ready(function () {
                $("#sub").click(function () {
                    $.ajax({
                        type: "POST",
                        url: "/admin/userAddById",
                        data: $("#userform").serialize(),
                        dataType: "json",
                        success: function(data){
                            if (data.status==0){
                                dialog.error(data.msg);
                            }else if (data.status==1){
                                dialog.success(data.msg,"user-list");
                            }
                        }
                    });
                });
            });
			layui.use(['form', 'jquery', 'laydate', 'layer', 'laypage', 'dialog', 'element', 'upload', 'layedit'], function() {
				var form = layui.form(),
					$ = layui.jquery,
					layedit = layui.layedit,

				//获取当前iframe的name值
				var iframeObj = $(window.frameElement).attr('name');
				form.on('checkbox(allChoose)', function(data) {
					var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]');
					child.each(function(index, item) {
						item.checked = data.elem.checked;
					});
					form.render('checkbox');
				});
				form.render();
			});
		</script>
@endsection
