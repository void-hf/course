@extends('admin.layouts.layout')
@section('title')
公司添加
@endsection

@section('content')
<div class="page-content-wrap clearfix">
    <form class="layui-form column-content-detail" id="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{$category->id }}">
        <div class="layui-tab">
            <div class="layui-tab-content">
                <div class="layui-tab-item"></div>
                <div class="layui-tab-item layui-show">
                    <div class="layui-form-item">
                        <label class="layui-form-label">分类名称：</label>
                        <div class="layui-input-block">
                            <input type="text" name="category_name" required lay-verify="required" placeholder="请输入分类名称" autocomplete="off" class="layui-input" value="{{$category->category_name}}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">分类排序号：</label>
                        <div class="layui-input-block">
                            <input type="text" name="sort_val" required lay-verify="required" placeholder="请输入分类排序号" autocomplete="off" class="layui-input" value="{{$category->sort_val}}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">分类图标：</label>
                        <div class="layui-input-block" style="margin-left: 0px;">
                            <div class="layui-upload">
                                <input name="category_img" type="hidden" id="logo" value="{{$category->category_img}}">
                                <button type="button" class="layui-btn layui-btn-normal" id="logoUpload">
                                    选择文件
                                </button>
                            </div>
                            <div class="layui-input-block" style="margin-top: 5px;">
                                <img class="layui-upload-img" id="img" src="{{$category->category_img}}"
                                     style="height: 60px;width: 60px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item" style="padding-left: 10px;">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo" type="button">立即提交</button>
                <a class="layui-btn layui-btn-primary" href="category-list">返回</a>
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
                url: "categoryEditById",
                data: $("form").serialize(),
                dataType: "json",
                success: function(data){
                    if (data.status==0){
                        dialog.error(data.msg);
                    }else if (data.status==1){
                        dialog.success(data.msg,"category-list");
                    }
                }
            });
        });
        //全选
    });
</script>
@endsection
