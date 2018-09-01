@extends('admin.layouts.layout')
@section('title')
学校添加
@endsection

@section('content')
<div class="page-content-wrap clearfix">
    <form class="layui-form column-content-detail" id="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="layui-tab">
            <div class="layui-tab-content">
                <div class="layui-tab-item"></div>
                <div class="layui-tab-item layui-show">
                    <div class="layui-form-item">
                        <label class="layui-form-label">选择用用户：</label>
                        <div class="layui-input-inline">
                            <select name="user_id" lay-verify="required" lay-search="">
                                <option value="">选择用户</option>
                                @foreach ($userlist as $user)
                                <option value="{{$user->id}}" selected="">{{$user->user_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">选择活动：</label>
                        <div class="layui-input-block">
                            <select name="activity_id" lay-verify="required" lay-search="">
                                <option value="">请选择活动</option>
                                @foreach ($activitylist as $activity)
                                <option value="{{$activity->id}}" selected="">{{$activity->activity_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item" style="padding-left: 10px;">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo" type="button">立即提交</button>
                <a class="layui-btn layui-btn-primary" href="travel-list">返回</a>
            </div>
        </div>
</div>
</form>
</div>
@endsection

@section('script')
<script type="text/javascript">
    layui.use(['form', 'jquery', 'laydate', 'tool', 'element', 'upload'], function () {
        var form = layui.form,
            upload = layui.upload;
        form.on('submit(formDemo)', function (data) {
            $.ajax({
                type: "POST",
                url: "travelAddById",
                data: $("form").serialize(),
                dataType: "json",
                success: function (data) {
                    if (data.status == 0) {
                        dialog.error(data.msg);
                    } else if (data.status == 1) {
                        dialog.success(data.msg, "travel-list");
                    }
                }
            });
        });
        //全选
    });
</script>
@endsection
