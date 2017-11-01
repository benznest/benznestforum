@extends('app')

@section('content')


<?php
function getPictureMoney(){
    echo"<img src='wallet/money.png' width='5%'>";
  }

function getPictureDiary(){
    echo"<img src='diary/diary.png' width='5%'>";
  }
?>


<?php 
  if(isset($msg)){
    echo"<div class='alert alert-success' role='alert'>$msg</div>";
  }
?>
<!--
<br><br>
<br>
<center><h1>Coming soon</h1></center>
<center><h4>Project in Human Computer Interaction course</h4></center>
<br>
<br><a href="{{url('/index')}}"></a>
<br>
<br>
<br>
<br>
<br>
-->
<br><br>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default" style="border-color:#1ABC9C">
        <div class="panel-heading" style="background-color: #1ABC9C;color:white"><b><a href="{{url('/')}}" style="color:white;">Forum</a> > <?php echo"$category_name";?></b></div>
        <div class="panel-body">
            <div class="col-md-4">
              <a href="<?php echo url('/topic/new') ?>" class="btn btn-lg btn-info"><span class="glyphicon glyphicon-comment"></span>  &nbsp;&nbsp;new topic</a>
              <!--<a href="<?php //echo url('/poll/new') ?>" class="btn btn-lg btn-info"><span class="glyphicon glyphicon-stats"></span> &nbsp;&nbsp;new poll </a>
            -->
            </div>
        <br><br>
       <table class="table table-bordered table-striped table-condensed">
          <thead>
            <tr>
              <th width="10%"> Type</th>
              <th width="80%"> Topic</th>
              <th width="10%"> Comment</th>
            </tr>
           </thead>
          <tbody>
            <?php 

              if(count($data_topic)==0){
                echo"<tr>
                <td colspan='3'>Not found any topic.</td>
                </tr>";
              }

              foreach ($data_topic as $row) {
                $topic_id = $row['topic_id'];
                $title = $row['title'];
                $created_at = $row['created_at'];
                $created_at = date("H:i , l d F Y",strtotime($created_at ));
                $username = $row['name'];
                $count_comment = $row['count_comment'];
            ?>
              <tr>
                <td><center><span class="glyphicon glyphicon-question-sign fa-2x" style="margin-top:5px"></span></center></td>
                <td><b><a href=" {{ url('topic/'.$topic_id) }}">{{$title}}</a></b>
                  <table width="100%">
                    <tr>
                      <td width="50%"><font size='2'>by {{$username}} , {{$created_at}} </font></td>
                      <td style="text-align: right;">
                        @foreach($row['tag'] as $row_tag)
                          <font size='2' style="padding-right:2px"><a href="{{ url('tag/'.$row_tag['tag_name'])}}">{{$row_tag['tag_name']}}</a></font>
                        @endforeach
                      </td>
                    </tr>
                  </table></td>
                <td>{{$count_comment}}</td>
              </tr>
            <?php
            }
            ?>
         </tbody>
      </table>
      <!--
      <form action="{{ url('upload/image')}}" enctype="multipart/form-data" method="post">
      <input type="file" name="file">
       <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="submit">
      </form>
      -->
</div> <!-- /.col-xs-3 -->

</div>
</div>
</div>
</div>
</div>

@include('footer')
@endsection