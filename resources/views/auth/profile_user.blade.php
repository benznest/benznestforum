@extends('app')

@section('content')


<?php
function toDate($date){
  return "".date("d F Y",strtotime($date));
}

function calculateAge($birthDate){
  $birthDate = explode("-", $birthDate); // YYYY-MM-DD

  //get age from date or birthdate
  $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
    ? ((date("Y") - $birthDate[0]) - 1)
    : (date("Y") - $birthDate[0]));
  //echo "Age is:" . $age;
  return $age;
}

$mydate = date("Y-m-d");
?>

<?php 
	if(isset($msg)){
		echo"<div class='alert alert-success' role='alert'>$msg</div>";
	}
?>

 	<?php
              //$users_id = Auth::user()->id;
              $name  = $data_profile['name'];
              $email = $data_profile['email'];
              $gender  = $data_profile['gender'];
              $birthday = $data_profile['birthday'];
              $filename_photo    = $data_profile['photo'];

              if($gender == ""){
              	$gender="Unidentified";
              }
              
              if($birthday == "00-00-0000"){
              	$birthday ="Unidentified";
              }

   ?>

<br>
<br>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default" style="background-color: #1ABC9C;">
				<div class="panel-heading" style="background-color: #1ABC9C;color:white"> <b><?php echo"$name";?></b></div>
				<div class="panel-body" style="background-color:#f4f4f4">
					
						<div class="form-group">
							<div class="container-fluid">
								<div class="row">
									<label class="col-md-1 control-label"></label>
									<div class="col-md-3">
										<img <?php echo"src='".url('resources/assets/img/profile/' . $filename_photo)."'"?> width="200px" height="200px">
									</div>
									<div class="col-md-8">
										<div class="container-fluid">
											<div class="row">
												<div class="col-md-2">
													Gender :
												</div>
												<div class="col-md-8">
													<?php echo"$gender";?>
												</div>
											</div>
											<div class="row">
												<div class="col-md-2">
													Birth day :
												</div>
												<div class="col-md-8">
													<?php echo"".toDate($birthday);?>
												</div>
											</div>
											<div class="row">
												<div class="col-md-2">
													Age :
												</div>
												<div class="col-md-8">
													<?php echo"".calculateAge($birthday);?> years old
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					<div class="form-group" >
						<label class="col-md-1 control-label"></label>
						<div class="col-md-10">
							<div>
							  <!-- Nav tabs -->
							  <ul class="nav nav-tabs" role="tablist">
							    <li role="presentation" class="active"><a href="#topic_created_me" aria-controls="home" role="tab" data-toggle="tab">Topic create by me <span class="badge"><?php echo"$count_topic"?></span></a></li>
							    <li role="presentation"><a href="#comment_by_me" aria-controls="profile" role="tab" data-toggle="tab">Topic comment by me <span class="badge"><?php echo"$count_topic_comment"?></span> </a></li>
							    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">My favorite topic <span class="badge"></span></a></li>
							  </ul>

							  <!-- Tab panes -->
							  <div class="tab-content">
							    <div role="tabpanel" class="tab-pane active" id="topic_created_me">
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
							              echo"<tr>
							                <td>?</td>
							                <td><b><a href='".url('topic/'.$topic_id.'')."'>$title</a></b>
							                <br><font size='2'>by $username , $created_at</font></td>
							                <td>$count_comment</td>
							              </tr>";
							            }
							            ?>
							         </tbody>
							      </table>
							    </div>
							    <div role="tabpanel" class="tab-pane" id="comment_by_me">
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

							              if(count($data_topic_comment)==0){
							                echo"<tr>
							                <td colspan='3'>Not found any topic.</td>
							                </tr>";
							              }

							              foreach ($data_topic_comment as $row) {
							                $topic_id = $row['topic_id'];
							                $title = $row['title'];
							                $created_at = $row['created_at'];
							                $created_at = date("H:i , l d F Y",strtotime($created_at ));
							                $username = $row['name'];
							                $count_comment = $row['count_comment'];
							              echo"<tr>
							                <td>?</td>
							                <td><b><a href='".url('topic/'.$topic_id.'')."'>$title</a></b>
							                <br><font size='2'>by $username , $created_at</font></td>
							                <td>$count_comment</td>
							              </tr>";
							            }
							            ?>
							         </tbody>
							      </table>
							    </div>
							    <div role="tabpanel" class="tab-pane" id="messages">
							    	
							    </div>
							  </div>

							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<br>

<script type="text/javascript">
	$('#home').tab('show');
</script>
@include('footer')
@endsection

