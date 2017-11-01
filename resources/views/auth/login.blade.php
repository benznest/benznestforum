@extends('app')

@section('content')
<br>
<br>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default" style="border-color:#1ABC9C">
        <div class="panel-heading" style="background-color: #1ABC9C;color:white"><b>Login</b></div>
				<div class="panel-body" style="background-color:#f4f4f4">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<br>
						<div class="form-group">
							<label class="col-md-4 control-label">Email</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<div class="checkbox">
									<label class="checkbox" for="checkbox2">
										<input type="checkbox" name="remember" value="" id="checkbox2" data-toggle="checkbox">
									  &nbsp;remember me 
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">Login</button>

								<a class="btn btn-link" href="{{ url('/password/email') }}">Forgot password</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<br>
<center>Benznest Studio</center>
@endsection
