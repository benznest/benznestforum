@extends('app')

@section('content')


<br>
<br>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading" style="background-color: #1ABC9C;color:white"><b>Profile</b></div>
        <div class="panel-body" style="background-color:#f4f4f4">

          <?php 
  if(isset($msg)){
    if($status == "success"){
          echo"<div class='alert alert-success' role='alert'>
            <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
            <span class='sr-only'>Successful:</span>
            $msg
          </div>";
    }
    else if($status == "fail"){
      echo"<div class='alert alert-danger' role='alert'>
            <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
            <span class='sr-only'>Error:</span>
            $msg
          </div>";
    }
  }
?>

          <form class="form-horizontal" role="form" method="POST" action="{{ url('profile/save') }}" enctype="multipart/form-data">
            <?php
              $users_id = Auth::user()->id;
              $name     = $data_profile['name'];
              $email    = $data_profile['email'];
              $gender   = $data_profile['gender'];
              $birthday = $data_profile['birthday'];
              $filename_photo    = $data_profile['photo'];
            ?>

            <input type="hidden" name="_token" value="{{ csrf_token() }}" >

            <div class="form-group">
              <label class="col-md-4 control-label">Photo</label>
              <div class="col-md-6">
                <img <?php echo"src='".url('resources/assets/img/profile/' . $filename_photo)."'"?> width="150px" height="150px">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label"></label>
              <div class="col-md-6">
                <input type="file" class="form-control" name="photo">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label">Name</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="name" value="<?php echo"$name";?>" required readonly="" style="color:black;">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label">E-Mail Address</label>
              <div class="col-md-6">
                <input type="email" class="form-control" name="email" value="<?php echo"$email";?>" readonly="" style="color:black;">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label">Gender</label>
              <div class="col-md-6">
                <select class="form-control" name="gender" required>
                  <option value="unidentified">Unidentified</option>
                  <option value="male"    <?php if($gender=="male"){echo"selected";}?>>Male</option>
                  <option value="female"  <?php if($gender=="female"){echo"selected";}?>>Female</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label">Birthday</label>
              <div class="col-md-6">
                <input type="date" max="2005-12-31" class="form-control" name="birthday" value="<?php echo"$birthday";?>" required>
              </div>
            </div>


            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                  Save profile
                </button>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label"></label>
              <div class="col-md-6">
                <a href="<?php echo url('profile/'.$users_id) ?>">See your profile in public.</a>
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

          <form class="form-horizontal" role="form" method="POST" action="{{ url('/profile/changepassword') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
              <label class="col-md-4 control-label">Old password</label>
              <div class="col-md-6">
                <input type="password" pattern=".{6,}" title="lenght should least 6 character" class="form-control" name="old_password" required>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label">New password</label>
              <div class="col-md-6">
                <input type="password" pattern=".{6,}" title="lenght should least 6 character" class="form-control" name="new_password" required>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label">Confirm new password</label>
              <div class="col-md-6">
                <input type="password" pattern=".{6,}" title="lenght should least 6 character" class="form-control" name="new_password_confirm" required>
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                  Save change password
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  <?php
    if(isset($msg)){
     if($status == "success"){
  ?>
      $(function () {
        $('#modalChangePasswordDone').modal('show');
      });
    <?php
    }
  }
    ?>
</script>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalChangePasswordDone" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" style="width: 50%;" role="document">
    <div class="modal-content">
      <div class="modal-header" >
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel" >Done</h4>
      </div>
      <div class="modal-body">
          <div class="form-group"> 
            <h4>Your profile is changed successfully.</h4>
            We will sent email to you about changing profile.
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Finish</button>
      </div>
    </div>
  </div>
</div>

@endsection
