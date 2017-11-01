@extends('app')
@section('content')


        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-10 col-md-offset-1">
                        <h1 class="page-header">
                            My Favorite <small style="color:grey">topic</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> You can find and store your favorite topic here.
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-10 col-md-offset-1">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"> My favorite topic</h3>
                            </div>
                            <div class="panel-body">
                                @if(count($data_topic) > 0)
                                
                            
                                    <div class="row">
                                        <label class="col-md-1 control-label" align="right">Filter</label>
                                        <div class="col-lg-4">
                                            <input id="filter" type="text" class="form-control" placeholder="Title topic , Add favorite date">
                                            <br>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="10%">Type</th>
                                                        <th width="80%">Topic</th>
                                                        <th width="10%">Comment</th>
                                                        <th width="10%">Remove</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="searchable">
                                                @foreach($data_topic as $row)
                                                    <?php $favorite_id = $row['favorite_id']; ?>
                                                <tr>
                                                    <td></td>
                                                    <td><b><a href=" {{ url('topic/'.$row['topic_id']) }}">{{$row['title']}}</a></b>
                                                            <table width="100%">
                                                                <tr>
                                                                  <td width="50%"><font size='2'>by {{$row['users_id']}} , {{$row['created_at']}} </font></td>
                                                                  <td style="text-align: right;">
                                                                    @foreach($row['tag'] as $row_tag)
                                                                      <font size='2' style="padding-right:2px"><a href="{{ url('tag/'.$row_tag['tag_name'])}}">{{$row_tag['tag_name']}}</a></font>
                                                                    @endforeach
                                                                  </td>
                                                                </tr>
                                                            </table>
                                                    </td>
                                                    <td>{{$row['count_comment']}}</td>
                                                    <td style="text-align: right;">
                                                        <a href="{{ url('/favorite/remove/'.$favorite_id) }}" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Remove </a>    
                                                    </td>
                                                </tr>
                                                 @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <h4>You don't have any favorite topic.</h4>
                            @endif       
                            </div>

                        </div>
                    </div>
                    
                </div>
                <!-- /.row -->

            </div>



<script type="text/javascript">
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