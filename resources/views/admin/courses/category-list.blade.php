@extends('admin.layouts.layout')
@section('title')
角色列表
@endsection

@section('content')
<style type="text/css">
    td img{
        width: 100px;
        height: 100px;
    }
</style>
<div class="page-content-wrap">
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <div class="layui-inline tool-btn">
                <button class="layui-btn layui-btn-small layui-btn-normal go-btn"
                        data-url="category-add"><i class="layui-icon">&#xe654;</i></button>
            </div>
            <div class="layui-inline">
                <input type="text" name="key" placeholder="请输入要查找的分类名称" autocomplete="off" class="layui-input" id="key">
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
                <th>分类名</th>
                <th style="width: 200px">该分类图标</th>
                <th style="width: 100px">排序号</th>
                <th style="width: 200px">添加时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($categorylist as $category)
            <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->category_name}}</td>
                <td><img src="{{$category->category_img}}"></td>
                <td>{{$category->sort_val}}</td>
                <td>{{ date('Y-m-d',$category->add_time) }}</td>
                <td>
                    <div class="layui-inline">
                        <button class="layui-btn layui-btn-mini layui-btn-normal  go-btn" data-id="{{$category->id}}"
                                data-url="category-edit"><i class="layui-icon">&#xe642;</i></button>
                        <button class="layui-btn layui-btn-mini layui-btn-danger del-btn" data-id="{{$category->id}}" onclick="tDel({{$category->id}})"><i
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
    layui.use(['form', 'layer', 'dialog','laypage'], function () {//分页插件
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
                window.location.href='category-list?page='+obj.curr;
            }else{
                return 0;
            }
        }
    });
    });
    function tDel(pid) {
        $.ajax({
            type: "POST",
            url: "categoryDelById",
            data: {'id':pid,'_token':'{{ csrf_token() }}'},
            dataType: "json",
            success: function (data) {
                if (data.status == 0) {
                    dialog.error("删除失败");
                } else if (data.status == 1) {
                    dialog.success("删除成功", "category-list");
                }
            }
        });
    }

</script>
@endsection
