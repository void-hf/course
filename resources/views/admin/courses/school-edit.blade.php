@extends('admin.layouts.layout')
@section('title')
学校添加
@endsection

@section('content')
<div class="page-content-wrap clearfix">
    <form class="layui-form column-content-detail" id="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{$school->id }}">
        <div class="layui-tab">
            <div class="layui-tab-content">
                <div class="layui-tab-item"></div>
                <div class="layui-tab-item layui-show">
                    <div class="layui-form-item">
                        <label class="layui-form-label">学校名称：</label>
                        <div class="layui-input-block">
                            <input type="text" name="school_name" required lay-verify="required" placeholder="请输入学校名称" autocomplete="off" class="layui-input" value="{{$school->school_name}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item" style="padding-left: 10px;">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo" type="button">立即提交</button>
                <a class="layui-btn layui-btn-primary" href="school-list">返回</a>
            </div>
        </div>
</div>
</form>
</div>
@endsection

@section('script')
<script type="text/javascript">
    layui.use(['form', 'jquery', 'laydate', 'tool', 'element', 'upload'], function() {
        var form = layui.form,
            upload = layui.upload;
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
                url: "schoolEditById",
                data: $("form").serialize(),
                dataType: "json",
                success: function(data){
                    if (data.status==0){
                        dialog.error(data.msg);
                    }else if (data.status==1){
                        dialog.success(data.msg,"school-list");
                    }
                }
            });
        });
        //全选
    });
</script>
@endsection
