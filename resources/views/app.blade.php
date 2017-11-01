<!DOCTYPE html>
<?php $forum_name =  App\Http\Controllers\ConfigForumController::getForumName();?>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<title>{{$forum_name}}</title>
	

	<link href="{{ asset('library/css/app.css') }}" rel="stylesheet">
	<script src="{{ asset('library/js/jquery-2.1.4.min.js') }}"></script> 
	
  <!-- include libraries BS3 -->
  <link rel="stylesheet" href="{{ asset('library/css/bootstrap.min.css') }}" />
  <link href="{{ asset('library/css/flat-ui.css') }}" rel="stylesheet">
  <script type="text/javascript" src="{{ asset('library/js/flat-ui.min.js') }}"></script>
  

  <link rel="stylesheet" href="{{ asset('library/css/font-awesome.css') }}" />

  <!-- include summernote -->
  <link rel="stylesheet" href="{{ asset('library/css/summernote.css') }}">
  <script type="text/javascript" src="{{ asset('library/js/summernote.js') }}"></script>

  <link rel="stylesheet" href="{{ asset('library/datepicker/css/bootstrap-datetimepicker.min.css') }}">
  <script type="text/javascript" src="{{ asset('library/datepicker/js/bootstrap-datetimepicker.min.js') }}" charset="UTF-8"></script>

	<!--<script src="{{ asset('library/js/highcharts.js') }}"></script>-->
	
  <script src="{{ asset('library/js/chart-google-api.js') }}"></script>
  <script src="{{ asset('library/js/high-chart/highcharts.js') }}"></script>
  <script src="{{ asset('library/js/high-chart/highcharts-modules-data.js') }}"></script>
  <script src="{{ asset('library/js/high-chart/highcharts-modules-drilldown.js') }}"></script>

<script src="{{ asset('library/js/exporting.js') }}"></script>

	<style type="text/css">
	.spanningMenu a:link, .spanningMenu a:visited, .spanningMenu a:active {
    	color: #fff !important;
	}

	.spanningMenu a:hover {
    	color: #1ABC9C !important;
	}
	
</style>
<!--
.spanningMenu a:hover {
    background-color: #1ABC9C !important;
	}
-->


<!--
	<link href="{{ asset('library/css/app.css') }}" rel="stylesheet">


    <link href="{{ asset('library/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('library/css/flat-ui.css') }}" rel="stylesheet">

    <link href="{{ asset('library/css/table-responsive.css') }}" rel="stylesheet">
	<link href="{{ asset('library/css/font-awesome.css') }}"rel="stylesheet"> 
-->
  	<!-- 
  	<link  href="{{ asset('library/css/summernote.css') }}">

  	<script type="text/javascript" src="{{ asset('library/js/vendor/jquery.min.js') }}"></script>
	
	<script type="text/javascript" src="{{ asset('library/js/vendor/video.js') }}"></script>
	<script type="text/javascript" src="{{ asset('library/js/flat-ui-more.js') }}"></script>
	<script type="text/javascript" src="{{ asset('library/js/flat-ui.min.js') }}"></script>
	
	<script type="text/javascript" src="{{ asset('library/js/summernote.js') }}"></script>
-->
	
	
	<!--<script src="{{ asset('library/js/vendor/bootstrap.min.js') }}"></script>-->

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body style="padding-top: 40px;">

	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">{{$forum_name}}</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i> Home</a></li>
					<li><a href="{{ url('/search') }}"><i class="glyphicon glyphicon-search"></i> Search</a></li>
					<li><a href="{{ url('/topic/new') }}"><i class="glyphicon glyphicon-edit"></i> New topic</a></li>
					
					<?php $data_category =  App\Http\Controllers\ConfigForumController::getAllCategory();?>
					<li class="dropdown">
			            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Category <span class="fui-triangle-down-small"></span></b></a>
			            <ul class="dropdown-menu multi-column columns-2 " style="width:500px;">
				            <div class="row">
					            <div class="col-sm-6">
						            <ul class="multi-column-dropdown spanningMenu nav" >

							            <?php 
							            for($i=0;$i<count($data_category);$i++) {
							            	if($i%2==0){
							            ?>
							            <li><a href="{{ url('category/'.$data_category[$i]['category_id'])}}" style="color:white">{{$data_category[$i]['category_name']}}</a></li>
							            <?php
							            	}
							            }
							            ?>
							            
						            </ul>
					            </div>
					            <div class="col-sm-6">
						            <ul class="multi-column-dropdown spanningMenu nav">
							            <?php 
							            for($i=0;$i<count($data_category);$i++) {
							            	if($i%2==1){
							            ?>
							            <li><a href="{{ url('category/'.$data_category[$i]['category_id'])}}" style="color:white">{{$data_category[$i]['category_name']}}</a></li>
							            <?php
							            	}
							            }
							            ?>
							           
						            </ul>
					            </div>
				            </div>
			            </ul>
			        </li>
					<li><a href="{{ url('/contact') }}">Contact</a></li>
					@if (!Auth::guest())
					<!--
					<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">กระเป๋าเงิน <span class="caret"></a>
							
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/wallet/addTransactions') }}">เพิ่มรายการในกระเป๋า</a></li>
								<li><a href="{{ url('/wallet/1/10') }}">รายการทั้งหมด</a></li>
								<li><a href="{{ url('/wallet/search') }}">ค้นหา</a></li>
								<li><a href="{{ url('/wallet/summary') }}">รายงานสรุป</a></li>
							</ul>
							
					</li>
					<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">ไดอารี่ <span class="caret"></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/diary/addDiary') }}">เพิ่มรายการในไดอารี่</a></li>
								<li><a href="{{ url('/diary/1/10') }}">รายการทั้งหมด</a></li>
								<li><a href="{{ url('/diary/search') }}">ค้นหา</a></li>
								<li><a href="{{ url('/diary/summary') }}">รายงานสรุป</a></li>
							</ul>
					</li>
					-->
					@endif
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">Login</a></li>
						<li><a href="{{ url('/auth/register') }}">Register</a></li>
					@else
						<!--
						<li><a href="{{ url('/wallet/1/10') }}">คงเหลือ {{ number_format(Auth::user()->balance,2) }} บาท</a></li>
						-->
						@if (Auth::user()->level == "admin")
						<li  <?php if(isset($admin_tab)){echo"class='active'";} ?>><a href="{{ url('/admin') }}"><i class="glyphicon glyphicon-th"></i> Administrator panel</a></li>
						@endif
						<!--
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <span class="fa fa-bell"></span> Notification  <span class="fui-triangle-down-small"></span></a>
							<ul class="dropdown-menu" role="menu" style="width:500px;">
								<li><a href="{{ url('/profile') }}">My profile</a></li>
								<li><a href="{{ url('/') }}">Show all</a></li>
							</ul>
						</li>
						-->
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }}  <span class="fui-triangle-down-small"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/profile') }}">My profile</a></li>
								<li><a href="{{ url('/favorite') }}">My favorite topic</a></li>
								<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')

	<!-- Scripts -->


	</body>
</html>
