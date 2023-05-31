<!doctype html>
<html class="no-js" lang="">
	<head >
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf_token" content="{!! csrf_token() !!}" />
		<meta name="description" content="{{ isset($meta_description) ? $meta_description : 'Right to education' }}">
		<meta name="robots" content="noodp">
		<meta property="og:locale" content="en_US">
		<meta property="og:type" content="website">
		<meta property="og:title" content="{{ isset($og_title) ? $og_title : 'RightToEducation'}}">
		<meta name="og:description" content="{{ isset($og_description) ? $og_description : 'Right To Education' }}">
		<meta property="og:image" content="{{ isset($og_image) ? $og_image : asset('img/rteogimage.png') }}">
		<meta content='378' property='og:image:height'>
		<meta content='image/png' property='og:image:type'>
		<meta content='473' property='og:image:width'>
		<meta property="og:url" content="{{ isset($og_url) ? $og_url : \Request::url() }}">
		<meta property="og:site_name" content="RightToEducation">
		<title>{{ isset($title) ? $title . ' | RightToEducation - RTE': 'RightToEducation - RTE' }}</title>
		@yield('before-styles-end')
		{!! Html::style(getAsset('css/vendor.css')) !!}
		{!! Html::style(getAsset('css/admin.css')) !!}
		{!! Html::style(getAsset('css/app.css')) !!}
		@yield('after-styles-end')
		<link rel="shortcut icon" href="{!! url('/img/favicon.png') !!}">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
		<link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond:300,400,600,700" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
		<!--[if lt IE 9]>
		{!! Html::script(getAsset('js/html5shiv.min.js')) !!}
		<![endif]-->
	</head>
	<body class="hold-transition sidebar-mini" ng-app="app">
		<div class="parent-container">
