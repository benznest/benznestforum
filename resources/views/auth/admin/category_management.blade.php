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
                            Category <small style="color:grey">management</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Total category is {{ count($data_category)}}
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
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"> Add Category</h3>
                            </div>
                            <div class="panel-body">
                                <form action="{{ url('admin/category/add') }}" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <label class="col-md-2 control-label" align="right">Category name</label>
                                    <div class="col-lg-4">
                                         <input type="text" class="form-control" name="category_name"  required  placeholder="Category" >
                                    </div>
                                    <label class="col-md-1 control-label" align="right">Public</label>
                                    <div class="col-md-3">
                                        <select class="form-control" name="category_status" required>
                                          <option value="available" selected="">Available public</option>
                                          <option value="not available">Not available</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-1">
                                         <input type="submit" class="btn btn-primary" value="Add">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-10 col-md-offset-1">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"> Category</h3>
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
                                                        <th width="50%">Category</th>
                                                        <th width="10%">Total Tag</th>
                                                        <th width="10%">Status</th>
                                                        <th width="10%" colspan="2">Manage</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="searchable">
                                                @foreach($data_category as $row)
                                                    <tr>
                                                        <td>{{$row['category_id']}}</td>
                                                        <td><a href="{{ url('category/'.$row['category_id'])}}">{{$row['category_name']}}</a></td>   
                                                        <td>{{$row['count_tag']}}</td>
                                                        <td>{{printColor($row['category_status'])}}</td> 
                                                        <!-- <td><a href="" class="btn btn-warning" style="width:100%"><i class="glyphicon glyphicon-remove"></i> Hide</a></td> -->
                                                        <!-- data-target="#modalEditCategory"  -->
                                                            <td>
                                                            <a href="" id="btnEditCategory" class="btn btn-info" style="width:100%" data-toggle="modal" 
                                                                data-category-name  ="{{$row['category_name']}}" 
                                                                data-category-status="{{$row['category_status']}}"
                                                                data-category-id    ="{{$row['category_id']}}">
                                                                <i class="glyphicon glyphicon-wrench"></i> Edit</a></td>
                                                            <td>
                                                            <a href="" id="btnRemoveCategory" class="btn btn-danger" style="width:100%" data-toggle="modal" 
                                                            data-category-name  ="{{$row['category_name']}}" 
                                                            data-category-id    ="{{$row['category_id']}}">
                                                            <i class="glyphicon glyphicon-trash"></i> Remove</a></td>  
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



<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalRemoveCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog modal-sm"  role="document">
    <div class="modal-content">
      <div class="modal-header" >
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel" >Remove category</h4>
      </div>
      <form action="{{ url('')}}" method="post">
          <div class="modal-body">
                <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="category_id" name="category_id" value="">
                <div class="form-group">
                    Are you sure remove <label class="form-group" id="category_name">Java</label> ?   
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">Confirm</button>
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

    $(document).on("click", "#btnRemoveCategory", function () {
         var category_name = $(this).data('category-name');
         var category_id = $(this).data('category-id');
         
         $(".modal-body #category_name").text( category_name );
         $(".modal-body #category_id").val(category_id);
         $('#modalRemoveCategory').modal('show');
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