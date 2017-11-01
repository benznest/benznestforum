@extends('app')
@extends('auth.admin.nav_admin')
@section('content')


<?php 
    function printColor($msg){
        if($msg=="active"){
            echo"<b><font color='green'>$msg</font></b>";
        }
        else if($msg=="banned"){
            echo"<b><font color='red'>$msg</font></b>";
        }
    }
?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-10 col-md-offset-1">
                        <h1 class="page-header">
                            Account <small style="color:grey">management</small>
                        </h1>
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
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Total account is {{ count($data_users)}}.
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-10 col-md-offset-1">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"> Account</h3>
                            </div>
                            <div class="panel-body">
                                <label class="col-md-1 control-label" align="right">Filter</label>
                                <div class="col-lg-4">
                                    <input id="filter" type="text" class="form-control" placeholder="ID , Name , Email , Level , etc..">
                                    <br>
                                </div>
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th width="10%">ID #</th>
                                                    <th width="20%">Name</th>
                                                    <th width="20%">Email</th>
                                                    <th width="10%">Join when</th>
                                                    <th width="10%">Level</th>
                                                    <th width="10%">Status</th>
                                                    <th width="10%">Manage</th>
                                                </tr>
                                            </thead>
                                            <tbody class="searchable">
                                                
                                                @foreach($data_users as $row)
                                                <tr>
                                                    <td>{{$row['id']}}</td>
                                                    <td><a href="{{ url('profile/'.$row['id']) }}">{{$row['name']}}</a></td>
                                                    <td>{{$row['email']}}</td>
                                                    <td>{{$row['created_at']}}</td>
                                                    <td>{{$row['level']}}</td>
                                                    <td>{{printColor($row['status'])}}</td>
                                                    <td>
                                                    @if($row['status']=="active")
                                                    <a href="" id="btnBanUser" class="btn btn-warning" style="width:100%" data-toggle="modal" 
                                                                data-name  ="{{$row['name']}}" 
                                                                data-users-id="{{$row['id']}}">
                                                                <span class="glyphicon glyphicon-remove"></span> Ban</a>
                                                    @else
                                                    <a href="" id="btnRecoverUser" class="btn btn-primary" style="width:100%" data-toggle="modal" 
                                                                data-name  ="{{$row['name']}}" 
                                                                data-users-id="{{$row['id']}}">
                                                                <span class="glyphicon glyphicon-ok"></span> Recover</a>
                                                    @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- /.row -->

            </div>


<!-- Modal Ban-->

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalBanUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog modal-sm"  role="document">
    <div class="modal-content">
      <div class="modal-header" >
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel" >Ban account</h4>
      </div>
      <form action="{{ url('admin/account/ban')}}" method="post">
          <div class="modal-body">
                <input type="hidden" id="new_token" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="users_id" name="users_id" value="">
                <input type="hidden" id="myname"   name="users_name" value="">
                <div class="form-group">
                    Are you sure ban "<b><label id="users_name" style="font-size:20px"></label></b>" ?
                </div>
                <div class="form-group">
                <!--
                    Public 
                    <select class="form-control" id="new_category_status" name="category_status" required>
                        <option value="available">Available public</option>
                        <option value="not available">Not available</option>
                    </select>
                -->
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-warning">Confirm</button>
          </div>
       </form>
    </div>
  </div>
</div>

<!-- Modal Recover-->

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalRecoverUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog modal-sm"  role="document" style="width:400px;">
    <div class="modal-content">
      <div class="modal-header" >
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel" >Account recovery</h4>
      </div>
      <form action="{{ url('admin/account/recover')}}" method="post">
          <div class="modal-body">
                <input type="hidden" id="new_token" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="users_id" name="users_id" value="">
                <input type="hidden" id="myname"   name="users_name" value="">
                <div class="form-group">
                    Are you sure recover "<b><label id="users_name" style="font-size:20px"></label></b>" ?
                </div>
                <div class="form-group">
                <!--
                    Public 
                    <select class="form-control" id="new_category_status" name="category_status" required>
                        <option value="available">Available public</option>
                        <option value="not available">Not available</option>
                    </select>
                -->
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Confirm</button>
          </div>
       </form>
    </div>
  </div>
</div>

<script type="text/javascript">

$(document).on("click", "#btnBanUser", function () {

         var name = $(this).data('name');
         var users_id = $(this).data('users-id');
         

         $(".modal-body #users_name").html(name);
         $(".modal-body #users_id").val(users_id);
         $(".modal-body #myname").val(name);
         $('#modalBanUser').modal('show');
 });

$(document).on("click", "#btnRecoverUser", function () {

         var name = $(this).data('name');
         var users_id = $(this).data('users-id');
         

         $(".modal-body #users_name").html(name);
         $(".modal-body #users_id").val(users_id);
         $(".modal-body #myname").val(name);
         $('#modalRecoverUser').modal('show');
 });


    $(document).ready(function () {

        (function ($) {

            $('#filter').keyup(function () {

                var rex = new RegExp($(this).val(), 'i');
                $('.searchable tr').hide();
                $('.searchable tr').filter(function () {
                    return rex.test($(this).text());
                }).show();

            })

         }(jQuery));
    });

</script>



@include('footer')
@endsection