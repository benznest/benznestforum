@extends('app')
@section('content')


        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-10 col-md-offset-1">
                        <h1 class="page-header">
                            Search <small style="color:grey">topic</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> You can search topic by input keyword here.
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-10 col-md-offset-1">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"> Search Topic</h3>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" role="form" method="get" action="{{ url('search/topic/') }}" >
                                   
                                    <!--<input type="hidden" name="_token" value="{{ csrf_token() }}" >
                         -->
                                    <div class="form-group">
                                      <label class="col-md-4 control-label">Keyword</label>
                                      <div class="col-md-5">
                                        <input type="text" class="form-control" name="keyword" value="" required placeholder="keyword">
                                      </div>
                                    </div>

                                    <div class="form-group">
                                      <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                          Search
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
            </div>




@include('footer')
@endsection