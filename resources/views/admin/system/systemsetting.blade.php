@extends('admin.layouts.layout')
@section('title')
系统修改
@endsection
@section('content')
<style type="text/css">
    .imgBox{
        width: 224px;
        height: 134px;
        border: 1px dashed #e2e2e2;
        background: white;
        padding: 1px;
        display: inline-block;
    }
    .imgDelBtn{
        left: 3px;
        top: 3px;
        position: absolute;
    }
    .layui-elem-field {
        background: #f9f9f9;
    }
    .layui-btn {
        height: 39px;
    }
    @media (min-width: 1000px) {
        #form {
            width: 1000px;
        }
    }
</style>
<div class="page-content-wrap clearfix">
    <form class="layui-form column-content-detail layui-form layui-form-pane" id="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="imgList" id="imgList">
        <div class="layui-tab" >
            <!-- 倒模 -->
            <fieldset class="layui-elem-field" style="margin-bottom: 10px;width: 996px;">
                <legend>常规设置</legend>
                <div class="layui-field-box">
                    <div class="layui-form-item" style="margin-bottom: 10px">
                        <label class="layui-form-label">app名称</label>
                        <div class="layui-input-inline" style="width: 130px">
                            <input type="text" name="app_name" placeholder="请输入应用名称" autocomplete="off"
                                   class="layui-input" value="{{$setting->app_name}}">
                        </div>
                    </div>
                    <div class="layui-form-item" style="margin-bottom: 10px">
                            <label class="layui-form-label">网站地址</label>
                            <div class="layui-input-inline" style="width: 80%">
                                <input type="text" name="app_url" placeholder="请输入网站的地址如:www.xxxx.com" class="layui-input" value="{{$setting->app_url}}">
                            </div>
                    </div>
                    <div class="layui-form-item" style="margin-bottom: 10px">
                        <label class="layui-form-label" style="height: 44px;line-height: 26px;">关于我们</label>
                        <div class="layui-input-inline" style="width: 80%;height: 200px">
                                    <textarea class="layui-textarea layui-hide" name="content" lay-verify="content" id="content">{{$setting->about_me}}</textarea>
                        </div>
                    </div>

                    <div class="layui-form-item" style="margin-bottom: 10px">
                        <label class="layui-form-label" style="height: 44px;line-height: 26px;">平台规则</label>
                        <div class="layui-input-inline" style="width: 80%;height: 200px">
                            <textarea class="layui-textarea layui-hide" name="content2" lay-verify="content" id="content2">{{$setting->platform_rules}}</textarea>
                        </div>
                    </div>
                </div>
        </div>
        </fieldset>
        <div class="layui-form-item" style="padding-left: 10px;">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo" type="button">立即提交</button>
            </div>
        </div>
    </form>
</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    var addImgNum = 0;
    var addImgId = 0;
    var addArray = new Array();
    function delImgBox(pId){
        for (var i=0;i<addArray.length;i++){
            if (addArray[i]==$("#imgBox"+pId).attr('src')){
                addArray.splice(i,1);
                $("#lineImgBox"+pId).remove();
                addImgNum--;
            }
        }
    }
    function addImgBox(pId){
        $('#imgListBox').append("<div class=\"layui-input-inline\" style=\"width: 250px\" id=\"lineImgBox"+pId+"\">\n" +
            "<img id=\"imgBox"+pId+"\" class=\"imgBox\">\n" +
            "<button class=\"layui-btn layui-btn-danger imgDelBtn\" onclick='delImgBox("+pId+")' type=\"button\"><i class=\"layui-icon\"></i></button>\n" +
            "</div>");
    }
    layui.use(['form', 'jquery', 'laydate', 'layer', 'laypage', 'dialog', 'tool', 'element', 'upload', 'layedit','upload'], function() {
        var form = layui.form,
            layedit = layui.layedit,
            upload = layui.upload;
        layedit.set({
            uploadImage: {
                url: '/admin/uploadBannerImg' //接口url
                ,type: 'post' //默认post
            }
        });
        var editIndex = layedit.build('content', {
            tool: ['strong' //加粗
                , 'italic' //斜体
                , 'underline' //下划线
                , 'del' //删除线
                , '|' //分割线
                , 'left' //左对齐
                , 'center' //居中对齐
                , 'right' //右对齐
                , 'link' //超链接
                , 'unlink' //清除链接
                , 'image' //插入图片
            ],
            height: 160
        })

        var editIndex2 = layedit.build('content2', {
            tool: ['strong' //加粗
                , 'italic' //斜体
                , 'underline' //下划线
                , 'del' //删除线
                , '|' //分割线
                , 'left' //左对齐
                , 'center' //居中对齐
                , 'right' //右对齐
                , 'link' //超链接
                , 'unlink' //清除链接
                , 'image' //插入图片
            ],
            height: 160
        })
        upload.render({
            elem: '#test10'
            ,url: '/admin/uploadBannerImg'
            , headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            }
            ,done: function(res){
                if (addImgNum>=3){
                    dialog.error("最多上传3张");
                    return;
                }
                addImgId++;
                addImgBox(addImgId);
                $('#imgBox'+addImgId)[0].src=res.data.src;
                addArray[addImgNum] = res.data.src;
                console.log(addArray);
                addImgNum++;
            }
        });
            $(document).ready(function () {
                $.ajax({
                    type: "GET",
                    url: "/admin/getBannerList",
                    data:{id:$("#id").val(),_token:"{{ csrf_token() }}"},
                    dataType: "json",
                    success: function(data){
                        if (data.status==0){
                            dialog.error(data.data.msg);
                        }
                        if (data.status==1){
                            var addArra= new Array();
                            $("#imgList").val(data.data);
                            for (var i=0;i<data.data.length;i++){
                                addArra[i]=data.data[i];
                            }
                            addArray = addArra;
                            console.log(addArray);
                            for (var i=0;i<data.data.length;i++){
                                addImgId++;
                                addImgBox(addImgId);
                                $('#imgBox'+addImgId)[0].src = data.data[i];
                                addImgNum++;
                            }
                        }
                    },
                    error:function(){
                        dialog.error("请选择正确的选项");
                    }
                });
            $("#sVice_amount").click(function () {
                $("#vice_amount").val(parseFloat($("#vice_weight").val())*parseFloat($("#vice_univalent").val()));
            })
            $("#sVice_machining_amount").click(function () {
                $("#vice_machining_amount").val(parseFloat($("#vice_num").val())*parseFloat($("#vice_inlayunitprice").val()));
            })

            $("#sGold_value").click(function () {
                $("#gold_value").val(parseFloat($("#gold_price").val())*parseFloat($("#loss_weight").val()));
            })
            });
        form.on('submit(formDemo)', function(data){
            $("input[name='imgList']").val(JSON.stringify(addArray));
            var d = data.field;
            console.log(d);
            var contentText = layedit.getContent(editIndex);
            var contentText2 = layedit.getContent(editIndex2);
            $.ajax({
                type: "POST",
                url: "/admin/updataSystemsetting",
                data: {_token:'{{ csrf_token() }}',app_name:d.app_name,app_url:d.app_url,about_me:contentText,platform_rules:contentText2},
                dataType: "json",
                success: function(data){
                    if (data.status==0){
                        dialog.error(data.msg);
                    }else if (data.status==1){
                        dialog.success(data.msg,"systemsetting");
                    }
                },
                error:function(){
                    dialog.error("错误请检查表单正确以及完整性");
                }
            });
        });
        //全选
    });

</script>
@endsection
