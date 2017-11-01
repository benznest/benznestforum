@extends('app')
@extends('auth.admin.nav_admin')
@section('content')


<style type="text/css">
    .glyphicon-refresh-animate {
    -animation: spin .7s infinite linear;
    -webkit-animation: spin2 .7s infinite linear;
}

@-webkit-keyframes spin2 {
    from { -webkit-transform: rotate(0deg);}
    to { -webkit-transform: rotate(360deg);}
}

@keyframes spin {
    from { transform: scale(1) rotate(0deg);}
    to { transform: scale(1) rotate(360deg);}
}
</style>


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
                            Statistics <small style="color:grey">forum</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> 
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
                                <h3 class="panel-title"> Statistics</h3>
                            </div>
                            <div class="panel-body">
                                
                                <div class="row">

                                    <div class="col-md-12 col-md-offset-2" >
                                        <h4>Number of topic on each tag</h4>
                                        <div id="piechart_3d" style="width: 900px; height: 500px;">
                                        <button class="btn btn-lg btn-default" style="width:700px;height:500px"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Loading...</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- /.row -->

            </div>


    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {

        $.get("{{ url('/report/category') }}",
                    { 
                        
                    })
        .done(function( data ) {
                    if(data.length > 0){
                        var data_array = [['Task', 'Hours per Day']];
                        console.log("data.length = "+data.length);
                        for(var i =0;i< data.length;i++){
                            var sub_array=[];
                            sub_array = [""+data[i].tag_name,data[i].count_topic];
                            data_array.push(sub_array);
                        }
                        console.log(data_array);

                        var data = google.visualization.arrayToDataTable(data_array);

                        var options = {
                          title: '',
                          is3D: true,
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                        chart.draw(data, options);

                    }else{
                        console.log("error");
                    }
        });

      }
    </script>



@include('footer')
@endsection