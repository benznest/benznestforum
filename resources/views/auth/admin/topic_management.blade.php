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
                            Topic <small style="color:grey">management</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Total topic is 
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
                                <h3 class="panel-title"> Topic</h3>
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