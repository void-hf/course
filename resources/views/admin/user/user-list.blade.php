@extends('admin.layouts.layout')
@section('title')
用户列表
@endsection

@section('content')
<div class="page-content-wrap">
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <div class="layui-inline tool-btn">
                <button class="layui-btn layui-btn-small layui-btn-normal go-btn"
                        data-url="user-add"><i class="layui-icon">&#xe654;</i></button>
            </div>
            <div class="layui-inline">
                <input type="text" name="key" placeholder="请输入要查找的用户名" autocomplete="off" class="layui-input" id="key">
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
                <!--<th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose"></th>-->
                <th>ID</th>
                <th style="width: 100px;">用户名</th>
                <th style="width: 100px">添加时间</th>
                <th>是否管理员</th>
                <th>角色</th>
                <th>权限</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($list as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{ $user->username }}</td>
                <td>{{ date('Y-m-d',$user->add_time) }}</td>
                @if ($user->is_admin==1)
                <td>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button id="{{$user->id}}" class="layui-btn layui-btn-mini layui-btn-normal table-list-status" data-status='1'>是
                    </button>
                </td>
                @endif
                @if ($user->is_admin==0)
                <td>
                    <button id="{{$user->id}}" class="layui-btn layui-btn-mini layui-btn-normal table-list-status layui-btn-warm"
                            data-status='2'>否
                    </button>
                </td>
                @endif
                <td>{{$user->roles}}</td>
                <td>{{$user->permissions}}</td>
                <td>
                    <div class="layui-inline">
                        <button class="layui-btn layui-btn-mini layui-btn-normal  go-btn" data-id="{{$user->id}}"
                                data-url="user-edit"><i class="layui-icon">&#xe642;</i></button>
                        <button class="layui-btn layui-btn-mini layui-btn-danger del-btn" data-id="{{$user->id}}" onclick="tDel({{$user->id}})"><i
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
    function tDel(pid) {
        $.ajax({
            type: "POST",
            url: "/admin/userDelById",
            data: {'id':pid,'_token':'{{ csrf_token() }}'},
            dataType: "json",
            success: function (data) {
                if (data.status == 0) {
                    dialog.error("删除失败");
                } else if (data.status == 1) {
                    dialog.success("删除成功", "user-list");
                }
            }
        });
    }
        layui.use(['form', 'jquery', 'layer', 'dialog','laypage'], function () {//分页插件
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
                    window.location.href='user-list?page='+obj.curr;
                }else{
                    return;
                }
            }
        });
        //修改状态
        $('#table-list').on('click', '.table-list-status', function () {
            var That = $(this);
            var  status = That.attr('data-status');
            var id = this.id;
            if (status == 1){
                $.ajax({
                    type: "POST",
                    url: "/admin/userEditIsAdminById",
                    data: {'id':id,'_token':'{{ csrf_token() }}','is_admin':'0'},
                    dataType: "json",
                    success: function (data) {
                        if (data.status == 0) {
                            dialog.error(data.msg);
                        } else if (data.status == 1) {
                            That.removeClass('layui-btn-normal').addClass('layui-btn-warm').html('否').attr('data-status', 2);
                        }
                    }
                });
            } else if (status == 2) {
                $.ajax({
                    type: "POST",
                    url: "/admin/userEditIsAdminById",
                    data: {'id':id,'_token':'{{ csrf_token() }}','is_admin':'1'},
                    dataType: "json",
                    success: function (data) {
                        if (data.status == 0) {
                            dialog.error(data.msg);
                        } else if (data.status == 1) {
                            That.removeClass('layui-btn-warm').addClass('layui-btn-normal').html('是').attr('data-status', 1);
                        }
                    }
                });
            }
        })
    });</script>
@endsection
