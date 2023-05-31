<!doctype Html>
<html class="no-js" lang="" ng-app="app">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf_token" content="{!! csrf_token() !!}" />
		<title>{{ isset($title) ? $title  .' | RTE' : 'RTE' }}</title>
		@yield('before-styles-end')
		{!! Html::style(getAsset('css/vendor.css')) !!}
		{!! Html::style(getAsset('css/admin.css')) !!}
		{!! Html::style(getAsset('css/app.css')) !!}
		@yield('after-styles-end')
		<link rel="shortcut icon" href="{!! url('/img/favicon.png') !!}">
		<link href='https://fonts.googleapis.com/css?family=Raleway:400,400italic,500,500italic,600,900italic,900,800italic,800,700italic,700,600italic,300italic,300|Montserrat:400,700' rel='stylesheet' type='text/css'>
		<link href="https://fonts.googleapis.com/css?family=Muli:300,400,600,700" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">
		<!--[if lt IE 9]>
		{!! Html::script(getAsset('js/html5shiv.min.js')) !!}
		<![endif]-->
	</head>
	<body class="hold-transition sidebar-mini">