@extends('app')

@section('content')
<?php
function getPictureDiary(){
    echo"<img src='diary.png' width='30%'>";
  }
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default" style="border-color:#1ABC9C">
        <div class="panel-heading" style="background-color: #1ABC9C;color:white">เข้าสู่บันทึกส่วนตัว</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">

							<div class="col-md-10 col-md-offset-2">
							<h3><?php echo getPictureDiary(); ?>
							<?php echo Auth::user()->name; ?></h3>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">PIN CODE</label>
							<div class="col-md-2">
								<input type="password" class="form-control" name="password" maxlength="4">
							</div>
						
							<div class="col-md-2 ">
								<button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>

								<a class="btn btn-link" href="{{ url('/password/email') }}">ลืมรหัสผ่าน</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
