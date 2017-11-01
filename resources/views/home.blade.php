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
<br>
<br>
<br>
<!--
  <div class="container-fluid">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default" style="border-color:#1ABC9C">
        <div class="panel-heading" style="background-color: #1ABC9C;color:white"><b>News</b></div>
        <div class="panel-body" style="background-color:#f4f4f4">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <div class="col-xs-10">
          <h6 class="demo-panel-title"><span class='glyphicon glyphicon-exclamation-sign' style='color:lime'></span> 
          Benznest Forum version 0.7</h6>
  </div>
</div> 


</div>
</div>
</div>
</div>
</div>
-->


<div class="container-fluid">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default" style="border-color:#1ABC9C">
        <div class="panel-heading" style="background-color: #1ABC9C;color:white"><b>Forum</b></div>
        <div class="panel-body">
<!--
        <div class="col-xs-2">
          <a href="{{url('/topic/new')}}" class="btn btn-block btn-lg btn-info">New topic</a>
        </div>
-->
       <table class="table table-bordered table-striped table-condensed">
          <thead>
            <tr>
              <th width="10%"> Type</th>
              <th width="70%"> Category</th>
            </tr>
           </thead>
          <tbody>
            <?php 
              foreach ($data_category as $row) {
                $category_id = $row['category_id'];
                $category_name = $row['category_name'];
              echo"<tr>
                <td>";?>
                  <center><span class="glyphicon glyphicon-question-sign fa-2x" style="margin-top:5px"></span></center>
                  <?php echo"</td>
                <td><a style='margin-left:10px' href='".url('category/'.$category_id.'')."'>$category_name</a></td>
              </tr>";
            }
            ?>
         </tbody>
      </table>
</div> <!-- /.col-xs-3 -->

</div>
</div>
</div>
</div>
</div>

@include('footer')
@endsection