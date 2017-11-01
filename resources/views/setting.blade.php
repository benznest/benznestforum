@extends('app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading" style="background-color: #1ABC9C;color:white"><b>Profile</b></div>
        <div class="panel-body" style="background-color:#f4f4f4">

          <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
              <label class="col-md-4 control-label">Name</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="name" value="" required>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label">E-Mail Address</label>
              <div class="col-md-6">
                <input type="email" class="form-control" name="email" value="" readonly="">
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                  Save
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>


     <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading" style="background-color: #1ABC9C;color:white"><b>Change password</b></div>
        <div class="panel-body" style="background-color:#f4f4f4">

          <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
              <label class="col-md-4 control-label">Old password</label>
              <div class="col-md-6">
                <input type="password" class="form-control" name="password" required>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label">New password</label>
              <div class="col-md-6">
                <input type="password" class="form-control" name="password_confirmation" required>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label">Confirm new password</label>
              <div class="col-md-6">
                <input type="password" class="form-control" name="password_confirmation" required>
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                  Save password
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
