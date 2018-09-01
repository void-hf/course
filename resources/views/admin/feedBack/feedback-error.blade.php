@extends('admin.layouts.layout')
@section('title')
反馈列表
@endsection

@section('content')
<div class="page-content-wrap">
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <div class="layui-inline">
                <input type="text" name="key" placeholder="请输入要查找的用户名称" autocomplete="off" class="layui-input" id="key">
            </div>
            <button class="layui-btn layui-btn-normal" lay-submit="search">搜索</button>
        </div>
    </form>
    <div class="layui-form" id="table-list">
        <table class="layui-table" lay-even lay-skin="nob">
            <colgroup>
                <col width="50">
                <col class="hidden-xs" width="50">
                <col class="hidden-xs" width="100">
                <col>
                <col class="hidden-xs" width="200">
                <col width="80">
                <col width="150">
            </colgroup>
            <thead>
            <tr>
                <th>ID</th>
                <th>用户名</th>
                <th>手机号码</th>
                <th>反馈内容</th>
                <th style="width: 200px">添加时间</th>
                <th style="width: 200px">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($feebacklist as $feedback)
            <tr>
                <td>{{$feedback->id}}</td>
                <td>{{$feedback->nickname }}</td>
                <td>{{$feedback->phone }}</td>
                <td style="width: 430px">{{$feedback->content }}</td>
                <td>{{date('Y-m-d',$feedback->add_time) }}</td>
                <td>
                    <div class="layui-inline">
                        <button class="layui-btn layui-btn-mini layui-btn-danger" data-id="{{$feedback->id}}" onclick="checkOut({{$feedback->id}})"><i
                                class="layui-icon" style="font-size: 13px">查看</i></button>
                        <button class="layui-btn layui-btn-mini layui-btn-danger del-btn" data-id="{{$feedback->id}}" onclick="tDel({{$feedback->id}})"><i
                                class="layui-icon">&#xe640;</i></button>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        @if(!trim($key))
        <div class="page-wrap">
            <div id="pagef"></div>
        </div>
        @endif
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    function checkOut(Id){
        layui.use(['layer'], function () {//分页插件
            var layer = layui.layer;
            layer.open({
                type: 2,
                skin: 'layui-layer-rim', //加上边框
                area: ['560px', '420px'], //宽高
                title:"反馈信息",
                content: ['/admin/feedback?id='+Id, 'no']
            });
        });
    }
    layui.use(['form', 'layer','laypage','upload'], function () {//分页插件
        var laypage = layui.laypage;
        laypage.render({
            elem: 'pagef',
            pages: {{$pageNumber}},
        limit: 8,
            count: {{$listNumber}},
        curr:{{$pageNow}},
        skip:true,
        layout: ['count', 'prev', 'page', 'next', 'skip','pages'],
            jump: function(obj){
            if ({{$pageNow}}!=obj.curr){
                window.location.href='feedback-list?page='+obj.curr;
            }else{
                return 0;
            }
        }
    });
            //向世界问个好
    });
    function tDel(pid) {
        $.ajax({
            type: "POST",
            url: "feedbackDelById",
            data: {'id':pid,'_token':'{{ csrf_token() }}'},
            dataType: "json",
            success: function (data) {
                if (data.status == 0) {
                    dialog.error("删除失败");
                } else if (data.status == 1){
                    dialog.success("删除成功", "feedback-list");
                }
            }
        });
    }
</script>
@endsection
