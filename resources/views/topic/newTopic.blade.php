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
				<div class="panel-heading" style="background-color: #1ABC9C;color:white"> <b>Create your topic </b></div>
				<div class="panel-body" style="background-color:#f4f4f4">
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/topic/new') }}">
						
						
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-1 control-label">Title</label>
							<div class="col-md-11">
								<input type="text" name="title" class="form-control" placeholder="How to use ... ?" value="" required>
							</div>
						</div>


						<div class="form-group">
							<label class="col-md-1 control-label">Body</label>
							<div class="col-md-11">
								<textarea style="resize: vertical;" rows="10" class="summernote" enctype="multipart/form-data" name="body" placeholder="I studying about ..." maxlenght="10000" minlenght="10" required></textarea>
							</div>
							<div class="col-md-11 col-md-offset-1">
								<font size="2">You can write maximium lenght 10,000 character.</font>
							</div>
						</div>

						<div class="form-group">
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
                                                            <td><center><input type="checkbox" class="mytag" name="mytag[]" value="{{ $row['tag_id'] }}"></center></td>
                                                            <td>{{$row['tag_name']}}</td>
                                                            <?php $i++; continue; ?>
                                                        @endif   
                                                        @if($i%2 == 1)
                                                            <td><center><input type="checkbox" class="mytag" name="mytag[]" value="{{ $row['tag_id'] }}"></center></td>
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
                                <br>
								<button type="submit" class="btn btn-primary">
									Create topic
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

$(document).ready(function () {
   $("input[name='mytag[]']").change(function () {
        console.log("xx ");
      var maxAllowed = 5;
      var cnt = $("input[name='mytag[]']:checked").length;
      if (cnt > maxAllowed) 
      {
         $(this).prop("checked", "");
         alert('Select maximum ' + maxAllowed + ' tags');
     }
  });
});
</script>

@include('footer')
@endsection

