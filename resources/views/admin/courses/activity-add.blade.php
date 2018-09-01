@extends('admin.layouts.layout')
@section('title')
学校添加
@endsection
@section('content')
<div class="page-content-wrap clearfix">
    <div class="page-content-wrap">
        <form class="layui-form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="addFilelist">
            <input type="hidden" name="activity_img">
            <input type="hidden" name="start_time">
            <input type="hidden" name="end_time">
            <input type="hidden" name="activity_des">
            <input type="hidden" name="lat">
            <input type="hidden" name="lng">
            <div class="layui-tab" style="margin: 0;">
                <div class="layui-tab-content">
                    <div class="layui-tab-item"></div>
                    <div class="layui-tab-item layui-show">
                        <div class="layui-form-item">
                            <label class="layui-form-label">活动标题：</label>
                            <div class="layui-input-block">
                                <input type="text" name="activity_name" required lay-verify="required" placeholder="请输入活动标题"
                                       autocomplete="off" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">活动负责人：</label>
                            <div class="layui-input-block">
                                <input type="text" name="up_user_name" required lay-verify="required" placeholder="请输入活动负责人名"
                                       autocomplete="off" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">联系方式：</label>
                            <div class="layui-input-block">
                                <input type="text" name="phone" required lay-verify="required" placeholder="请输入联系方式"
                                       autocomplete="off" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">活动的详细地址：</label>
                            <div class="layui-input-block">
                                <input type="text" name="activity_address" required lay-verify="required" placeholder="请输入活动的地址"
                                       autocomplete="off" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">活动开始时间</label>
                            <div class="layui-input-inline">
                                <input type="text" id="start_time" class="layui-input" id="start_time" placeholder="请选择开始时间">
                            </div>

                            <label class="layui-form-label">活动结束时间</label>
                            <div class="layui-input-inline">
                                <input type="text" id="end_time" class="layui-input" id="end_time" placeholder="请选择结束时间">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">选择经纬度：</label>
                            <div class="layui-input-inline">
                                <input type="text" class="layui-input" id="region" placeholder="城市">
                            </div>
                            <div class="layui-input-inline">
                                <input type="text" class="layui-input" id="keyword" placeholder="地点">
                            </div>
                            <div class="layui-input-inline">
                                <button type="button" class="layui-btn" onclick="searchKeyword()"> 搜索地图</button>
                            </div>
                            <div class="layui-input-inline">
                                <input type="text"  class="layui-input" id="l_num" placeholder="经度" disabled>
                            </div>
                            <div class="layui-input-inline">
                                <input type="text"  class="layui-input" id="n_num" placeholder="纬度" disabled>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <div id="container" style="width: 100%-4px;height: 400px;border:solid 2px #8D8D8D;margin-top: 20px"></div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">周期：</label>
                            <div class="layui-input-block">
                                <input type="checkbox" name="label[1]" title="周一">
                                <input type="checkbox" name="label[2]" title="周二">
                                <input type="checkbox" name="label[3]" title="周三">
                                <input type="checkbox" name="label[4]" title="周四">
                                <input type="checkbox" name="label[5]" title="周五">
                                <input type="checkbox" name="label[6]" title="周六">
                                <input type="checkbox" name="label[7]" title="周日">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">学校选择：</label>
                            <div class="layui-input-block">
                                <select name="school_id" lay-verify="required">
                                    <option value="">请选择学校</option>
                                        @foreach ($schoollist as $school)
                                        <option value="{{$school->id}}" selected="">{{$school->school_name}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">横幅上传：</label>
                            <div class="layui-input-block">
                                <div class="layui-upload-drag" id="bannerUpload">
                                    <i class="layui-icon"></i>
                                    <p>点击上传，或将文件拖拽到此处</p>
                                </div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">附件上传：</label>
                            <div class="layui-input-block">
                                <div class="layui-upload">
                                    <button type="button" class="layui-btn layui-btn-normal" id="testList">选择多文件</button>
                                    <div class="layui-upload-list">
                                        <table class="layui-table">
                                            <thead>
                                            <tr><th>文件名</th>
                                                <th>大小</th>
                                                <th>状态</th>
                                                <th>操作</th>
                                            </tr></thead>
                                            <tbody id="demoList"></tbody>
                                        </table>
                                    </div>
                                    <button type="button" class="layui-btn" id="testListAction">开始上传</button>
                                </div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">是否公开</label>
                            <div class="layui-input-block">
                                <input type="checkbox" checked="" name="is_open" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">标签：</label>
                            <div class="layui-input-block">
                                @foreach ($catelist as $cate)
                                <input type="radio" name="category_id" value="{{$cate->id}}" title="{{$cate->category_name}}">
                                @endforeach
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">是否要求用户实名报名</label>
                            <div class="layui-input-block">
                                <input type="checkbox" name="is_real_name_registration" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">活动简介：</label>
                            <div class="layui-input-block">
                                <textarea class="layui-textarea layui-hide" lay-verify="content" id="content"></textarea>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">活动需要的材料：</label>
                            <div class="layui-input-block">
                                <textarea class="layui-textarea" name="material" placeholder="请输入内容"></textarea>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">报名活动的最多人数：</label>
                            <div class="layui-input-block">
                                <input type="text" name="sign_up_ple_max" required lay-verify="required" placeholder="请输入活动的最大人数"
                                       autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">收取报名的费用(0元为免费)：</label>
                            <div class="layui-input-block">
                                <input type="text" name="pay_money" required lay-verify="required" placeholder="收取报名的费用"
                                       autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">所属系列：</label>
                            <div class="layui-inline">
                                <select name="series_id" lay-verify="required" lay-search="">
                                <option value="">请选择系列名称</option>
                                @foreach ($serieslist as $series)
                                <option value="{{$series->id}}" selected="">{{$series->series_name}}</option>
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
                    <a href="activity-list" class="layui-btn layui-btn-primary">返回</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script src="https://map.qq.com/api/js?v=2.exp"></script>
<script type="text/javascript">
    var upload_file_list = new Array();
    var addNum  = 0;
    layui.use(['form', 'jquery', 'laydate', 'tool', 'element', 'upload','layedit'], function () {
        var form = layui.form,
            upload = layui.upload,
            layedit = layui.layedit,
            laydate = layui.laydate;

        //获取当前iframe的name值
        var iframeObj = $(window.frameElement).attr('name');

        layedit.set({
            uploadImage: {
                url: 'uploadActivityDesImg' //接口url
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
            height: 100
        })

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
            height: 100
        })

        upload.render({
            elem: '#bannerUpload'
            , url: "uploadActivityImg"
            , auto: true
            , field: 'file'
            , multiple: true
            , headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            }
            ,done: function(res){
                console.log(res.data.src);
                $("#bannerUpload").css("background-image","url('"+res.data.src+"')");
                $("input[name='activity_img']").val(res.data.src);
                }
        });
        laydate.render({
            elem: '#start_time'
            , type: 'datetime'
            , format: 'yyyy-MM-dd HH:mm:ss'
        });
        laydate.render({
            elem: '#end_time'
            , type: 'datetime'
            , format: 'yyyy-MM-dd HH:mm:ss'
        });
        //全选
        form.on('submit(formDemo)', function(data){
            var contentText = layedit.getContent(editIndex);
            var start_time = new Date($('#start_time').val());
            var end_time = new Date($('#end_time').val());
            $('input[name="start_time"]').val(start_time.getTime()/1000);
            $('input[name="end_time"]').val(end_time.getTime()/1000);
            $("input[name='activity_des']").val(contentText);
            $("input[name='addFilelist']").val(JSON.stringify(upload_file_list));
            console.log(data.field.title);
            $.ajax({
                type: "POST",
                url: "activityAddById",
                data: $("form").serialize(),
                dataType: "json",
                success: function(data){
                    if (data.status==0){
                        dialog.error(data.msg);
                    }else if (data.status==1){
                        dialog.success(data.msg,"activity-list");
                    }
                },
                error:function(){
                    dialog.error(data.msg);
                }
            });
        });
        var demoListView = $('#demoList')
            ,uploadListIns = upload.render({
            elem: '#testList'
            ,url: 'uploadActivityFollow'
            ,accept: 'file'
            , headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            }
            ,multiple: true
            ,auto: false
            ,bindAction: '#testListAction'
            ,choose: function(obj){
                var files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
                //读取本地文件
                obj.preview(function(index, file, result){
                    var tr = $(['<tr id="upload-'+ index +'">'
                        ,'<td>'+ file.name +'</td>'
                        ,'<td>'+ (file.size/1014).toFixed(1) +'kb</td>'
                        ,'<td>等待上传</td>'
                        ,'<td>'
                        ,'<button class="layui-btn layui-btn-xs demo-reload layui-hide">重传</button>'
                        ,'<button class="layui-btn layui-btn-xs layui-btn-danger demo-delete">删除</button>'
                        ,'</td>'
                        ,'</tr>'].join(''));
                    //单个重传
                    tr.find('.demo-reload').on('click', function(){
                        obj.upload(index, file);
                    });
                    //删除
                    tr.find('.demo-delete').on('click', function(){
                        delete files[index]; //删除对应的文件
                        tr.remove();
                        uploadListIns.config.elem.next()[0].value = ''; //清空 input file 值，以免删除后出现同名文件不可选
                    });
                    demoListView.append(tr);
                });
            }
            ,done: function(res, index, upload){
                if(res.status == 1){ //上传成功
                    var tr = demoListView.find('tr#upload-'+ index)
                        ,tds = tr.children();
                    tds.eq(2).html('<span style="color: #5FB878;">上传成功</span>');
                    tds.eq(3).html(''); //清空操作
                 //   upload_file_list[addNum] = res.data.src;
                        var j = {};
                        j.src = res.data.src;
                        j.title = res.data.title;
                        upload_file_list.push(j);
                    addNum++;
                    return delete this.files[index]; //删除文件队列已经上传成功的文件
                }
                this.error(index, upload);
            }
            ,error: function(index, upload){
                var tr = demoListView.find('tr#upload-'+ index)
                    ,tds = tr.children();
                tds.eq(2).html('<span style="color: #FF5722;">上传失败</span>');
                tds.eq(3).find('.demo-reload').removeClass('layui-hide'); //显示重传
            }
        });
    });

    /////////////////////////////////////////////////////////////////////地图
    var searchService,map,markers = [];
    function init() {
        var myLatlng = new qq.maps.LatLng(39.916527, 116.397128);
        var myOptions = {
            zoom: 17,
            center: myLatlng
        };
        var map = new qq.maps.Map(document.getElementById("container"), myOptions);
        //获取城市列表接口设置中心点
        citylocation = new qq.maps.CityService({
            complete : function(result){
                map.setCenter(result.detail.latLng);
            }
        });
        //调用searchLocalCity();方法    根据用户IP查询城市信息。
        citylocation.searchLocalCity();
        //添加监听事件   获取鼠标单击事件
        qq.maps.event.addListener(map, 'click', function(event) {
            $("#l_num").val(event.latLng.getLat());
            $("#n_num").val(event.latLng.getLng());
            $("input[name='lat']").val(event.latLng.getLat());
            $("input[name='lng']").val(event.latLng.getLng());
            var marker=new qq.maps.Marker({
                position:event.latLng,
                animation:qq.maps.MarkerAnimation.DROP,
                map:map
            });
            qq.maps.event.addListener(map, 'click', function(event) {
                marker.setMap(null);
            });
        });

        searchService = new qq.maps.SearchService({
            complete : function(results){
                var pois = results.detail.pois;
                for(var i = 0,l = pois.length;i < l; i++){
                    var poi = pois[i];
                    latlngBounds.extend(poi.latLng);
                    var marker = new qq.maps.Marker({
                        map:map,
                        position: poi.latLng
                    });
                    marker.setTitle(i+1);
                    markers.push(marker);
                }
                map.fitBounds(latlngBounds);
            }
        });
        var latlngBounds = new qq.maps.LatLngBounds();
        //调用Poi检索类
    }
    //清除地图上的marker
    function clearOverlays(overlays){
        var overlay;
        while(overlay = overlays.pop()){
            overlay.setMap(null);
        }
    }
    function loadScript() {
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = "https://map.qq.com/api/js?v=2.exp&callback=init";
        document.body.appendChild(script);
    }
    function searchKeyword() {
        var keyword = document.getElementById("keyword").value;
        var region = document.getElementById("region").value;
        clearOverlays(markers);
        searchService.setLocation(region);
        searchService.search(keyword);
    }
    window.onload = loadScript;
</script>
@endsection
