<!DOCTYPE html>
<html class="iframe-h">
	<head>
		<meta charset="UTF-8">
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>@yield('title')</title>
		<link rel="stylesheet" type="text/css" href="/static/admin/layui/css/layui.css" />
		<link rel="stylesheet" type="text/css" href="/static/admin/css/admin.css" />
        <script type="text/javascript" src="/js/jquery.min.js"></script>
        <script type="text/javascript" src="/js/dialog.js"></script>
		@yield('css')
	</head>

	<body>
		@yield('content')
		<script src="/static/admin/layui/layui.js" type="text/javascript" charset="utf-8"></script>
		<script src="/static/admin/js/common.js" type="text/javascript" charset="utf-8"></script>
		@yield('script')
	</body>
</html>
