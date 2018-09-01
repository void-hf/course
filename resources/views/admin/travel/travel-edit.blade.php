@extends('admin.layouts.layout')
@section('title')
公司添加
@endsection

@section('content')
<div class="page-content-wrap clearfix">
    <form class="layui-form column-content-detail" id="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{$travel->id}}">
        <div class="layui-tab">
            <div class="layui-tab-content">
                <div class="layui-tab-item"></div>
                <div class="layui-tab-item layui-show">
                    <div class="layui-form-item">
                        <label class="layui-form-label">活动时间范围：</label>
                        <div class="layui-input-block">
                            <input type="text" name="travel_name" required lay-verify="required" placeholder="请输入分类名称" autocomplete="off" class="layui-input" value="{{$travel->activity_name}}" disabled>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">活动地点</label>
                        <div class="layui-input-block">
                            <input type="text" name="activity_address" required lay-verify="required" placeholder="请输入分类排序号" autocomplete="off" class="layui-input" value="{{$travel->activity_address}}" disabled>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">参加该活动的用户名列表</label>
                        <script type="text/html" id="barDemo">
                            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除报名用户</a>
                        </script>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">活动负责人</label>
                        <div class="layui-input-block">
                            <input type="text" name="sort_val" required lay-verify="required" placeholder="请输入分类排序号" autocomplete="off" class="layui-input" value="{{$travel->up_user_name}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item" style="padding-left: 10px;">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo" type="button">立即提交</button>
                <a class="layui-btn layui-btn-primary" href="travel-list">返回</a>
                <a class="layui-btn layui-btn-normal" href="/admin/courses/activity-edit?id={{$travel->activity_id}}">修改更多</a>
            </div>
        </div>
</div>
</form>
</div>
@endsection
@section('script')
<script type="text/javascript">
    layui.use(['form', 'jquery', 'laydate', 'tool', 'element', 'upload','table'], function() {
        var form = layui.form,
            table = layui.table,
            upload = layui.upload;
        layui.use('table', function(){
            var table = layui.table;
            //监听表格复选框选择
            table.on('checkbox(demo)', function(obj){
                console.log(obj)
            });
            //监听工具条
            table.on('tool(demo)', function(obj){
                var data = obj.data;
                if(obj.event === 'detail'){
                    layer.msg('ID：'+ data.id + ' 的查看操作');
                } else if(obj.event === 'del'){
                    layer.confirm('真的删除行么', function(index){
                        obj.del();
                        layer.close(index);
                    });
                } else if(obj.event === 'edit'){
                    layer.alert('编辑行：<br>'+ JSON.stringify(data))
                }
            });
            var $ = layui.$, active = {
                getCheckData: function(){ //获取选中数据
                    var checkStatus = table.checkStatus('idTest')
                        ,data = checkStatus.data;
                    layer.alert(JSON.stringify(data));
                }
                ,getCheckLength: function(){ //获取选中数目
                    var checkStatus = table.checkStatus('idTest')
                        ,data = checkStatus.data;
                    layer.msg('选中了：'+ data.length + ' 个');
                }
                ,isAll: function(){ //验证是否全选
                    var checkStatus = table.checkStatus('idTest');
                    layer.msg(checkStatus.isAll ? '全选': '未全选')
                }
            };

            $('.demoTable .layui-btn').on('click', function(){
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });
        });

        upload.render({
            elem: '#logoUpload'
            , url: "uploadCategorylogo"
            , auto: true
            , field: 'file'
            , multiple: true
            , headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            }
            , done: function (res) {
                $("#logo").val(res.data.src);
                $("#img")[0].src = res.data.src;
            }
        });
        form.on('submit(formDemo)', function(data){
            $.ajax({
                type: "POST",
                url: "travelEditById",
                data: $("form").serialize(),
                dataType: "json",
                success: function(data){
                    if (data.status==0){
                        dialog.error(data.msg);
                    }else if (data.status==1){
                        dialog.success(data.msg,"travel-list");
                    }
                }
            });
        });
        //全选
    });
</script>
@endsection
