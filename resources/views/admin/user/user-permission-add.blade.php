@extends('admin.layouts.layout')
@section('title')
用户修改或添加
@endsection

@section('content')
		<div class="page-content-wrap clearfix">
				<form class="layui-form" id="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="layui-tab">
                        <div class="layui-tab-content">
                            <div class="layui-tab-item"></div>
                            <div class="layui-tab-item layui-show">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">权限名称：</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="names" required lay-verify="required" placeholder="请输入权限名称" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">角色名：</label>
                                    <div class="layui-input-block">
                                        <input type="password" name="route_name" required lay-verify="required" placeholder="请输入角色名" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="layui-form-item" style="padding-left: 10px;">
						<div class="layui-input-block">
							<button class="layui-btn layui-btn-normal" id="sub" lay-filter="formDemo" type="button">立即提交</button>
                            <a class="layui-btn layui-btn-primary" href="permissions-list">返回</a>
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
                        url: "/admin/permissionsAddById",
                        data: $("#form").serialize(),
                        dataType: "json",
                        success: function(data){
                            if (data.status==0){
                                dialog.error(data.msg);
                            }else if (data.status==1){
                                dialog.success(data.msg,"permissions-list");
                            }
                        }
                    });
                });
            });
			layui.use(['form', 'jquery', 'laydate', 'layer', 'laypage', 'dialog', 'element', 'upload', 'layedit'], function() {
				var form = layui.form,
					$ = layui.jquery;
				//全选
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
