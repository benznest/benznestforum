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
                            Tag <small style="color:grey">management</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Total tag is {{ count($data_tag)}}
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
                                <h3 class="panel-title"> Add Tag</h3>
                            </div>
                            <div class="panel-body">
                                <form action="{{ url('admin/tag/add') }}" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                                    <div class="col-lg-3">
                                        Tag name<br>
                                        <input type="text" class="form-control" name="tag_name"  required  placeholder="Tag" >
                                    </div>
                                    <div class="col-md-3">
                                        Category<br>
                                        <select class="form-control" name="category_id" required>
                                        @foreach($data_category as $row)
                                          <option value="{{$row['category_id']}}">{{$row['category_name']}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        Public<br>
                                        <select class="form-control" name="tag_status" required>
                                          <option value="available">Available</option>
                                          <option value="not available">Not available</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-1">
                                        <br>
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
                                <h3 class="panel-title"> Tag</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <label class="col-md-1 control-label" align="right">Filter</label>
                                    <div class="col-lg-4">
                                        <input id="filter" type="text" class="form-control" placeholder="ID tag , tag , status">
                                        <br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th width="10%">Tag ID#</th>
                                                    <th width="30%">Tag name</th>
                                                    <th width="30%">Category</th>
                                                    <th width="10%">Status</th>
                                                    <th width="10%" colspan="2">Manage</th>
                                                </tr>
                                            </thead>
                                            <tbody class="searchable">
                                                @foreach($data_tag as $row)
                                                    <tr>
                                                        <td>{{$row['tag_id']}}</td>
                                                        <td>{{$row['tag_name']}}</td>
                                                        <td>{{$row['category_name']}}</td>
                                                        <td>{{printColor($row['tag_status'])}}</td>
                                                        <td>
                                                            <a href="" id="btnEditTag" class="btn btn-info" style="width:100%" data-toggle="modal" 
                                                                data-tag-id      ="{{$row['tag_id']}}" 
                                                                data-tag-name    ="{{$row['tag_name']}}" 
                                                                data-tag-status  ="{{$row['tag_status']}}"
                                                                data-category-id ="{{$row['category_id']}}">
                                                                <i class="glyphicon glyphicon-wrench"></i> Edit</a></td>
                                                        <td><a href="" id="btnRemoveTag" class="btn btn-danger" style="width:100%" data-toggle="modal"
                                                                data-tag-id      ="{{$row['tag_id']}}" 
                                                                data-tag-name    ="{{$row['tag_name']}}">
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
                <!-- /.row -->

            </div>


<!-- Modal edit-->

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalEditTag" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog modal-sm"  role="document">
    <div class="modal-content">
      <div class="modal-header" >
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel" >Edit tag</h4>
      </div>
      <form action="{{ url('admin/tag/edit')}}" method="post">
          <div class="modal-body">
                <input type="hidden" id="new_token" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="new_tag_id" name="tag_id" value="">
                <div class="form-group">
                    Tag name
                    <input type="text" class="form-control" id="new_tag_name" name="tag_name" required>
                </div>
                <div class="form-group">
                    Category
                    <select class="form-control" id="new_category_id" name="category_id" required>
                        @foreach($data_category as $row)
                            <option value="{{ $row['category_id'] }}">{{$row['category_name']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    Public
                    <select class="form-control" id="new_tag_status" name="tag_status" required>
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

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalRemoveTag" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog modal-sm"  role="document">
    <div class="modal-content">
      <div class="modal-header" >
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel" >Remove tag</h4>
      </div>
      <form action="{{ url('')}}" method="post">
          <div class="modal-body">
                <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="tag_id" name="category_id" value="">
                <div class="form-group">
                    Are you sure remove <label class="form-group" id="tag_name">Java</label> ?   
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

    $(document).on("click", "#btnEditTag", function () {
         var tag_name = $(this).data('tag-name');
         var tag_status = $(this).data('tag-status');
         var category_id = $(this).data('category-id');
         var tag_id = $(this).data('tag-id');

         $(".modal-body #new_tag_name").val( tag_name );
         $(".modal-body #new_tag_status").val(tag_status);
         $(".modal-body #new_category_id").val(category_id);
         $(".modal-body #new_tag_id").val(tag_id);
         $('#modalEditTag').modal('show');
    });

    $(document).on("click", "#btnRemoveTag", function () {
         var tag_name = $(this).data('tag-name');
         var tag_id = $(this).data('tag-id');

         
         $(".modal-body #tag_name").text( tag_name );
         $(".modal-body #tag_id").val(tag_id);
         $('#modalRemoveTag').modal('show');
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