@extends('admin.layouts.layout')
@section('title')
反馈列表
@endsection

@section('content')
<style type="text/css">
    body{
        padding: 40px;
        background: #fbfbfb;
        margin: 0px;
    }
    .top {
        width: 100%;
        height: 130px;
    }
    .top .top-left-img{
        float: left;
        display: inline-block;
    }

    .top .top-right-title{
        margin-right: 40px;
        height: 100px;
        width: 60%;
        float: right;
        display: inline-block;
    }
    .bommot{
        height: 130px;
        width: 100%;
    }
    ul{
        height: 120px;
        width: 100%;
        display: inline-block;
    }

    ul li{
        width: 30%;
        height: 90px;
        margin-left: 2%;
        display: inline-block;
    }
    ul li img{
        width: 100%;
        display: inline-block;
        height: 120px;
        border: solid 1px #8D8D8D;
    }
</style>
<div class="top">
    <div class="top-left-img">
        <img src="{{$feedBack->headimg}}" class="layui-circle" style="width: 120px;height: 120px">
    </div>
    <div class="top-right-title">
        <fieldset class="layui-elem-field" style="width: 100%;height: 100%">
            <legend>反馈内容</legend>
            <div class="layui-field-box">
                {{$feedBack->content}}
            </div>
        </fieldset>
    </div>
</div>
<fieldset class="layui-elem-field layui-field-title">
    <legend>相关图片</legend>
</fieldset>
<div class="bommot">
    <ul>
        @foreach ($feedBackImgList as $feedBackImg)
        <li><img src="{{$feedBackImg->feedback_img}}" ></li>
        @endforeach
    </ul>
</div>
@endsection
@section('script')
<script type="text/javascript">

</script>
@endsection
