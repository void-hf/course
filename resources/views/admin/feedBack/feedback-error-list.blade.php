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
                <th>副石石重</th>
                <th>副石粒数</th>
                <th>倒模重</th>
                <th>主石粒数</th>
                <th>商品名称</th>
                <th style="width: 200px">用户纠错时间</th>
                <th style="width: 200px">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($feebackerrorlist as $feebackerror)
            <tr>
                <td>{{$feebackerror->id}}</td>
                <td>{{$feebackerror->nickname}}</td>
                <td>{{($feebackerror->phone)?$feebackerror->phone:""}}</td>
                <td>{{($feebackerror->vice_weight)?$feebackerror->vice_weight."ct":""}}</td>
                <td>{{($feebackerror->vice_num)?$feebackerror->vice_num."粒":""}}</td>
                <td>{{($feebackerror->inverted_weight)?$feebackerror->inverted_weight."ct":""}}</td>
                <td>{{($feebackerror->master_num)?$feebackerror->master_num."粒":""}}</td>
                <td>{{$feebackerror->goods_name }}</td>
                <td>{{date('Y-m-d',$feebackerror->add_time) }}</td>
                <td>
                    <div class="layui-inline">
                        <button class="layui-btn layui-btn-mini layui-btn-danger del-btn" data-id="{{$feebackerror->id}}" onclick="tDel({{$feebackerror->id}})"><i
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
                content: ['/admin/feedbackerror-list?id='+Id, 'no']
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
                window.location.href='feedbackerror-list?page='+obj.curr;
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
            url: "feedbackErrorDelById",
            data: {'id':pid,'_token':'{{ csrf_token() }}'},
            dataType: "json",
            success: function (data) {
                if (data.status == 0) {
                    dialog.error("删除失败");
                } else if (data.status == 1){
                    dialog.success("删除成功", "feedbackerror-list");
                }
            }
        });
    }
</script>
@endsection
