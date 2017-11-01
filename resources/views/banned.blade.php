@extends('app')
@section('content')


        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-10 col-md-offset-1">
                        <h1 class="page-header">
                            Sorry <small style="color:grey">for your authentication</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> You can contact us from email address.
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-10 col-md-offset-1">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Description</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <h6>Your account is banned.</h6>
                                    {{$email}}<br>
                                    It will be something mistake plaease contact us , benznest.developer@gmail.com
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- /.row -->

            </div>




@include('footer')
@endsection