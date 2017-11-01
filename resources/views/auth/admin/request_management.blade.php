@extends('app')
@extends('auth.admin.nav_admin')
@section('content')

<?php 
    function printColor($msg){
        if($msg=="available"){
            echo"<b><font color='green'>$msg</font></b>";
        }
        else if($msg=="not available"){
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
                            Request <small style="color:grey">management</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Total request is {{ count($data_request)}}
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-10 col-md-offset-1">
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
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-10 col-md-offset-1">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"> Requeest</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <label class="col-md-1 control-label" align="right">Filter</label>
                                    <div class="col-lg-4">
                                        <input id="filter" type="text" class="form-control" placeholder="ID category , Name , status">
                                        <br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="10%">ID #</th>
                                                        <th width="10%">Date</th>
                                                        <th width="10%">Request</th>
                                                        <th width="10%">Sender</th>
                                                        <th width="5%">Status</th>
                                                        <th width="10%">Target</th>
                                                        <th width="5%" colspan="2">Manage</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="searchable">
                                                @foreach($data_request as $row)
                                                    <tr>
                                                        <td>{{$row['request_id']}}</td>
                                                        <td>{{$row['created_at']}}</td>   
                                                        <td>{{$row['request_name']}}</td>
                                                        <td>{{$row['users_id']}}</td>
                                                        <td>{{$row['request_status']}}</td>
                                                        <td><a href="" class="btn btn-warning" style="width:100%"> Target</a></td>
                                                        
                                                        <!-- <td><a href="" class="btn btn-warning" style="width:100%"><i class="glyphicon glyphicon-remove"></i> Hide</a></td> -->
                                                        <!-- data-target="#modalEditCategory"  -->
                                                            <td>
                                                            <a href="" id="btnEditCategory" class="btn btn-info" style="width:100%" data-toggle="modal" 
                                                                data-category-name  ="" 
                                                                data-category-status=""
                                                                data-category-id    ="">
                                                                <i class="glyphicon glyphicon-file"></i> Description</a></td>
                                                            <td><a href="" class="btn btn-primary" style="width:100%"><i class="glyphicon glyphicon-saved"></i> Mark checked</a></td>  
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
                    
                </div>
                <!-- /.row -->

            </div>


<!-- Modal edit-->

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalEditCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog modal-sm"  role="document">
    <div class="modal-content">
      <div class="modal-header" >
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel" >Edit category</h4>
      </div>
      <form action="{{ url('admin/category/edit')}}" method="post">
          <div class="modal-body">
                <input type="hidden" id="new_token" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="new_category_id" name="category_id" value="">
                <div class="form-group">
                    Category name
                    <input type="text" class="form-control" id="new_category_name" name="category_name"  required>
                </div>
                <div class="form-group">
                    Public
                    <select class="form-control" id="new_category_status" name="category_status" required>
                        <option value="available">Available public</option>
                        <option value="not available">Not available</option>
                    </select>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save change</button>
          </div>
       </form>
    </div>
  </div>
</div>




<script type="text/javascript">

    $(document).on("click", "#btnEditCategory", function () {
         var category_name = $(this).data('category-name');
         var category_status = $(this).data('category-status');
         var category_id = $(this).data('category-id');
         

         $(".modal-body #new_category_name").val( category_name );
         $(".modal-body #new_category_status").val(category_status);
         $(".modal-body #new_category_id").val(category_id);
         $('#modalEditCategory').modal('show');
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