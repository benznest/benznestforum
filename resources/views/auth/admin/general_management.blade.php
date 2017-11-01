@extends('app')
@extends('auth.admin.nav_admin')
@section('content')


        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-10 col-md-offset-1">
                        <h1 class="page-header">
                            Forum <small style="color:grey">general management</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> You can change your forum name here.
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-10 col-md-offset-1">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"> General</h3>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/change/nameforum/save') }}" enctype="multipart/form-data">
                                   
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                         
                                    <div class="form-group">
                                      <label class="col-md-4 control-label">Forum name</label>
                                      <div class="col-md-6">
                                        <input type="text" class="form-control" name="forum_name" value="{{$forum_name}}" required>
                                      </div>
                                    </div>

                                    <div class="form-group">
                                      <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                          Save change
                                        </button>
                                      </div>
                                    </div>  
                                  </form>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- /.row -->

            </div>




@include('footer')
@endsection