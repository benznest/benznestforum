@extends('app')

@section('content')

<?php
$mydate = date("Y-m-d");
?>

<?php 
	if(isset($msg)){
		echo"<div class='alert alert-success' role='alert'>$msg</div>";
	}
?>

<br><br>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default" style="background-color: #1ABC9C;">
				<div class="panel-heading" style="background-color: #1ABC9C;color:white"> <b>Create your poll topic </b></div>
				<div class="panel-body" style="background-color:#f4f4f4">
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/poll/new') }}">
						
						
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-1 control-label">Title</label>
							<div class="col-md-11">
								<input type="text" name="title" class="form-control" placeholder="How to use ... ?" value="" required maxlength="70">
							</div>
						</div>

						<div class="form-group">
						   
							<label for="dtp_input1" class="col-md-1 control-label">Duration</label>
							<div class="col-md-2" style="text-align:center;">
						   		<input class="form-control" type="number" max="30" min="1" value="3" a>
			                </div>
			                <div class="col-md-1" style="padding-left:0px"><label class="control-label">Days</label></div>
							<!--
			                <div style="padding-left:15px;" class="input-group date form_datetime col-md-5" data-date="1979-09-16T05:25:07Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
			                    <input class="form-control" size="16" type="text" value="" readonly required style="color:black;border-color:grey;">
			                    <span class="input-group-addon" style="background-color:#1ABC9C;border-color:grey"><span class="glyphicon glyphicon-remove"></span></span>
								<span class="input-group-addon" style="background-color:#1ABC9C;border-color:grey"><span class="glyphicon glyphicon-th"></span></span>
			                </div>
			               
							<input type="hidden" id="dtp_input1" value="" /><br/>
 								-->

 						</div>

 						<div class="form-group">
						<label class="col-md-1 control-label">Option</label>
			              <div class="col-md-5">
						   		<input type="checkbox"> &nbsp;&nbsp;Display result when join and voted only.
			               </div>
									    
						</div>




						<div class="form-group">
							<label class="col-md-1 control-label">Body</label>
							<div class="col-md-11">
								<table id="myTable">
								  <tr>
								    <td>Choice </td>
								    <td style="padding-left:30px"><input type="text" name="option_name[]" class="form-control" placeholder="name option" size="20" required ></td>
								    <td style="padding-left:10px"><input type="text" name="option_detail[]" class="form-control" placeholder="choice description" size="60"></td>
								    <td>&nbsp;&nbsp; <a href="#" onclick="deleteRow(this)"> <span class="glyphicon glyphicon-remove"></span></a></td>
								  </tr>
								  <tr>
								    <td>Choice </td>
								    <td style="padding-left:30px"><input type="text" name="option_name[]" class="form-control" placeholder="name option" size="20" required></td>
								    <td style="padding-left:10px"><input type="text" name="option_detail[]" class="form-control" placeholder="choice description" size="60"></td>
								    <td>&nbsp;&nbsp; <a href="#" onclick="deleteRow(this)"> <span class="glyphicon glyphicon-remove"></span></a></td>
								  </tr>
								  <tr>
								</table>
								<a style="margin-top:10px;" class="btn btn-info" onclick="addRow()"><span class="glyphicon glyphicon-plus"></span> &nbsp;&nbsp;add choice</a>
								<br><font size="2">maximium choice in poll is 10.</font>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-1 control-label">Body</label>
							<div class="col-md-11">
								<textarea style="resize: vertical;" rows="10" class="form-control" name="body" placeholder="I studying about ..." maxlenght="10000" minlenght="10" required></textarea>
							</div>
							<div class="col-md-11 col-md-offset-1">
								<font size="2">You can write maximium lenght 10,000 character.</font>
							</div>
						</div>

						<label class="col-md-1 control-label">Tag</label>
							<div class="col-md-11">
							
								<div class="col-lg-4">
                                        <input id="filter" type="text" class="form-control" placeholder="Filter by keyword">
                                        <br>
                                </div>
							</div>
						<div class="row" style="width: 100%;
											    height: 400px;
											    overflow-y: scroll;
											    overflow-x:hidden;">

                                <div class="col-lg-10 col-md-offset-1">
                                <font size="2">You should choose tag least 1 tag , and you can choose maximium 5 tag.</font>
                                        <br>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">Choose</th>
                                                        <th width="45%">Tag</th>
                                                        <th width="5%">Choose</th>
                                                        <th width="45%">Tag</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="searchable">
                                                	<?php $i=0;?>
                                                	@foreach($data_tag as $row)
	                                                	@if($i%2 == 0)
	                                                    <tr>  
	                                                    	<td><center><input type="checkbox" name="mytag[]" value="{{ $row['tag_id'] }}"></center></td>
	                                                        <td>{{$row['tag_name']}}</td>
	                                                        <?php $i++; continue; ?>
	                                                    @endif   
	                                                    @if($i%2 == 1)
	                                                        <td><center><input type="checkbox" name="mytag[]" value="{{ $row['tag_id'] }}"></center></td>
	                                                        <td>{{$row['tag_name']}}</td>  
	                                                    </tr>
	                                                    <?php $i++; continue; ?>
	                                                    @endif@
                                                    @endforeach
                                                </tbody>
                                        </table>
                                   	</div>
                                </div>
                        </div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-1">
								<button type="submit" class="btn btn-primary">
									<span class="glyphicon glyphicon-ok"></span> &nbsp;&nbsp;Create topic
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<br>

<script>
var myrow = 2;
function addRow() {
	if(myrow <10){
	    var table = document.getElementById("myTable");
	    var row = table.insertRow(-1); // insert to last row.
	    var cell1 = row.insertCell(0);
	    var cell2 = row.insertCell(1);
	    var cell3 = row.insertCell(2);
	    var cell4 = row.insertCell(3);
	    cell2.setAttribute("style","padding-left:30px");
	    cell3.setAttribute("style","padding-left:10px");
	    cell1.innerHTML = "Choice";
	    cell2.innerHTML = "<input type='text' name='option_name[]' class='form-control' placeholder='name option' size='20' required>";
	    cell3.innerHTML = "<input type='text' name='option_detail[]' class='form-control' placeholder='choice description' size='60'>";
	    cell4.innerHTML = "&nbsp;&nbsp; <a href='#' onclick='deleteRow(this)'> <span class='glyphicon glyphicon-remove'></span></a>";
		myrow++;
	}
}

function deleteRow(t) {
	if(myrow>2){
		var row = t.parentNode.parentNode;
	    document.getElementById("myTable").deleteRow(row.rowIndex);
	    console.log("delete row.");
		myrow--;
	}
}
</script>

<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
	$('.form_date').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	$('.form_time').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0
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

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

   $(function() {
      $('.summernote').summernote({
        height: 300,
        onImageUpload: function(files, editor, welEditable) {
                sendFile(files[0], editor, welEditable);
            }
      });

      function sendFile(file, editor, welEditable) {
            data = new FormData();
            data.append("file", file);
            $.ajax({
                data: data,
                type: "POST",
                url: "{{ url('upload/image') }}",
                cache: false,
                contentType: false,
                processData: false,
                success: function(url) {
                    console.log(url);
                    //editor.insertImage(welEditable, url);
                    //var img = window.location.hostname+"/"+url;
                    $('.summernote').summernote('editor.insertImage', "../"+url);
                }
            });
        }

     });
</script>
@include('footer')
@endsection



