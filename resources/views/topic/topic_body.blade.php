@extends('app')

@section('content')

<style type="text/css">

label {
  width: 90%;
  border-radius: 3px;
  border: 1px solid #1ABC9C
}

/* hide input */
input.radio:empty {
  margin-left: -999px;
}

/* style label */
input.radio:empty ~ label {
  position: relative;
  float: left;

  text-indent: 6em;
  cursor: pointer;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

input.radio:empty ~ label:before {
  position: absolute;
  display: block;
  top: 0;
  bottom: 0;
  left: 0;
  content: '';
  width: 2.8em;
  font-size: 25px;
  background: #D1D3D4;
  border-radius: 3px 0 0 3px;
}

/* toggle hover */
input.radio:hover:not(:checked) ~ label:before {
  content:'\2714';
  font-size: 25px;
  vertical-align: middle;
  text-indent: .9em;
  color: #1ABC9C;
}

input.radio:hover:not(:checked) ~ label {
  color: #1ABC9C;
}

/* toggle on */
input.radio:checked ~ label:before {
  content:'\2714';
  font-size: 25px;
  vertical-align: middle;
  text-indent: .9em;
  color: white;
  background-color: #1ABC9C;
}

input.radio:checked ~ label {
  color: #777;
}

/* radio focus */
</style>


<?php
function getPictureMoney(){
    echo"<img src='wallet/money.png' width='5%'>";
  }

function getPictureDiary(){
    echo"<img src='diary/diary.png' width='5%'>";
  }

function toDate($date){
  return "".date("H:i , l d F Y",strtotime($date));
}


function isPersonLoginCurrent($users_id){
  if(!Auth::guest()){
      if(Auth::user()->id == $users_id){
        return true;
      }
  }
  return false;
}

?>
<?php 
  if(isset($msg)){
    echo"<div class='alert alert-success' role='alert'>$msg</div>";
  }


?>



<!--
  //Body topic.
-->

<?php
$topic_id = $data_topic['topic_id'];

$title = $data_topic['title'];
$body = $data_topic['body'];
$topic_users_id = $data_topic['users_id'];
$topic_username = $data_topic['name'];
$created_at = toDate($data_topic['created_at']);

//
?>
<a name="top"></a>

<br><br>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default" style="border-color:#1ABC9C">
        <!--<div class="panel-heading" >     
        
        </div>-->
         <div class="panel-body" style="background-color:#f4f4f4">
          <h3 style="padding-left:20px;"><?php echo"$title";?></h3>

          <?php 
            foreach ($data_tag as $row) {
              $tag_name = $row['tag_name'];
              echo"<a style='margin-left:20px;border:1px solid #1ABC9C ;background-color:#f0f0f0;' 
              href='".url('/tag/'.$tag_name.'')."'>$tag_name</a>";
            }
          ?>

          <br><br>
          <div class="row">
            <div class="col-md-1" >
              <center>
                <?php 
                    if(isPersonLoginCurrent($data_topic['users_id'])){
                      echo"<span class='fui-triangle-up fa-2x'></span>";
                    }
                    else{
                      echo"<a href='".url('/topic/'.$topic_id.'/vote/useful')."'><span class='fui-triangle-up fa-2x'></span></a>";
                    }
                  ?>
                <br><b><?php echo"$data_vote";?></b>
                <br>
                <?php
                    if(isPersonLoginCurrent($data_topic['users_id'])){
                      echo"<span class='fui-triangle-down fa-2x'></span>";
                    }
                    else{
                      echo"<a href='".url('/topic/'.$topic_id.'/vote/unuseful')."'><span class='fui-triangle-down fa-2x'></span></a>";
                    }
                ?>
              </center>
            </div>
            <div class="col-md-11" >
              <?php
                if($data_poll_choice != null){ 
                  if($vote_available){
                  ?> 

                  <form action="{{ url('poll/vote/') }}" method="post">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="topic_id" value="<?php echo "$topic_id";?>">
                  <div class="container-fluid">
                   
                    <?php
                    $i=1;
                    foreach ($data_poll_choice as $choice) {

                    echo"
                      <div class='col-md-10' style='padding:0px;'> 
                        <input type='radio' name='choice[]' id='radio".$i."' class='radio' required value='".$choice['poll_id']."'/>
                        <label for='radio".$i."'<b><font size='5'>".$choice['name']."</font></b> : ".$choice['detail']."</label>

                      </div>
                    ";
                    $i++;
                    }
                    ?>

                  </div>
                  <div class='col-md-10' style="margin-bottom:40px;">
                    <button type="submit" class="btn btn-primary" style="width:400px;margin-top:30px;"><h6>Send answer</h6></button>
                  </div>
                  </form>
               <?php
                  }
                  else{ // was voted.
              ?>
               <div class="container-fluid">
                 <div class='col-md-10' style="margin-bottom:40px;">
                    <!-- 
                      Show Result poll
                    -->
                    <div id="container" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
                  </div>
               </div>
              <?php
                  }
                }
              ?>
              <div class='col-md-11'>
              <p style="padding-left:20px;padding-right:20px;"><?php echo"$body";?></p>
              </div>
            </div>
          </div>
          <hr style="border-color:#1ABC9C">
            <div class="col-md-1" style="margin-right:0px;"><img src="" width="50" height="50"></div>
            <div class="col-md-5">
            <p style="padding-left:20px;padding-right:20px;"><font size="3"><?php echo"<a href='".url('profile/'.$topic_users_id)."'> $topic_username";?></a>
            <br><?php echo"$created_at ";?>
            </font></p>
          </div>
          <div class="col-md-6" style="text-align:right">
          @if (!Auth::guest()) 
          @if (Auth::user()->level == "admin")
            <button type="button" class="btn btn-success mypopover" data-toggle="popover"
             data-placement='top' title="Admin tool" >
             <span class="glyphicon glyphicon-check"></span> Admin tool</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              

            <div id="popover_content_wrapper" style="display: none">
              <div>
                <a href="" id="btnRemoveTag" class="btn btn-info" style="width:100%" data-toggle="modal"
                                                                data-tag-id      ="{{$row['tag_id']}}" 
                                                                data-tag-name    ="{{$row['tag_name']}}">
                <i class="glyphicon glyphicon-wrench"></i> Edit content</a>

                <a href="" id="btnRemoveTag" class="btn btn-danger" style="width:100%;margin-top:10px" data-toggle="modal"
                                                                data-tag-id      ="{{$row['tag_id']}}" 
                                                                data-tag-name    ="{{$row['tag_name']}}">
                <i class="glyphicon glyphicon-trash"></i> Delete topic</a>
                
              </div>
            </div>
          @endif
          @endif 
            <a href="{{ url('favorite/add/topic/'.$topic_id)}}" class="smoothScroll btn btn-warning <?php if($flag_favorite==true){echo"disabled";}?>"><span class="glyphicon glyphicon-star"></span> Add favorite</a>
            <a class="btn btn-danger" data-toggle="modal" data-target="#modalRequestRemove" 
                  data-whatever=""><span class="glyphicon glyphicon-trash" style="aligh:right"></span> Remove</a>
            <a href="#addcommenttopost" class="smoothScroll btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Reply topic</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!--
  //Body Comment.
-->
<?php 
  $index_comment=0;
  foreach ($data_comment as $row_comment) {
     $comment_id = $row_comment['comment_id'];
     $comment_body  = $row_comment['comment_body'];
     $comment_users_id = $row_comment['users_id'];
     $comment_username = $row_comment['name'];
     $created_at  = toDate($row_comment['created_at']);
?>
  <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default" style="border-color:#1ABC9C"><a name="comment<?php echo $index_comment+1?>"></a>
        <div class="panel-body" style="background-color:#f4f4f4">
        <h6 style="padding-left:20px;">Comment : <?php echo "".($index_comment+1); ?></h6>
        <div class="row">
          <div class="col-md-1" >
              <center>
              <?php
                if(isPersonLoginCurrent($row_comment['users_id'])){
                  echo"<span class='fui-triangle-up fa-2x'></span><br>";
                }
                else{
                  echo"<a href='".url('/topic/'.$topic_id.'/'.$comment_id.'/vote/useful')."'><span class='fui-triangle-up fa-2x'></span></a><br>";
                }
                ?>
                <b><?php echo"".$row_comment['vote_comment_sum'];?></b><br>
                <?php 
                if(isPersonLoginCurrent($row_comment['users_id'])){
                  echo"<span class='fui-triangle-down fa-2x'></span><br>";
                }
                else{
                  echo"<a href='".url('/topic/'.$topic_id.'/'.$comment_id.'/vote/unuseful')."'><span class='fui-triangle-down fa-2x'></span></a>";
                }
                ?>
              </center>
            </div>
          <div class="col-md-11" >
            <p style="padding-left:20px;padding-right:20px;"><?php echo"$comment_body";?></p>
          </div>
        </div>
      <hr style="border-color:#1ABC9C">
      <div class="col-md-1" style="margin-right:0px;"><img src="" width="50" height="50"></div>
      <div class="col-md-7">
        <p style="padding-left:20px;padding-right:20px;"><font size="3"><?php echo"<a href='".url('profile/'.$comment_users_id)."'> $comment_username";?></a>
        <br><?php echo"$created_at ";?>
        </font></p>
      </div>
      
      <div class="col-md-4" style="text-align:right">
        <a id="btnRequestRemoveComment" class="btn btn-danger" data-comment-id="{{$comment_id}}" ><span class="glyphicon glyphicon-trash" style="aligh:right"></span> Remove</a>
        <a  <?php echo"href='#addsubcommenttocomment"."$index_comment"."'";?> class="modalComment btn btn-primary" data-id-comment="<?php echo "$index_comment";?>" ><span class="glyphicon glyphicon-pencil"></span> Reply this comment</a>
       </div>
     </div>
    </div>
  </div>
</div>


<?php 
$sub_comment = $row_comment['sub_comment'];
$count_subcomment = count($sub_comment);

if($count_subcomment > 0){
?>
<div class="col-md-9 col-md-offset-2 showSubComment" data-id-comment="<?php echo "$index_comment";?>">
  <div class="panel panel-default" style="border-color:#1ABC9C" >
     <div class="panel-body" style="background-color:#551A8B; color:white"> 
      <div class="col-md-5 col-md-offset-5"><span class="fui-triangle-down"></span>
      <?php echo"Show reply this comment ($count_subcomment)";?>
      </div>
     </div>
  </div>
</div>

<?php 
}
?>


<!--
  //Body SubComment.
-->

<div class="col-md-12" <?php echo"id='subcomment-".$index_comment."'"; ?> style="display: none;">

<?php 
  $index_sub_comment = 0;
  $sub_comment = $row_comment['sub_comment'];
  if(count($sub_comment) > 0){
    foreach ($sub_comment as $row_sub_comment) {
       $sub_comment_id       = $row_sub_comment['sub_comment_id'];
       $sub_comment_body     = $row_sub_comment['sub_comment_body'];
       $sub_comment_users_id = $row_sub_comment['users_id'];
       $sub_comment_username = $row_sub_comment['name'];
       $sub_comment_created_at  = toDate($row_sub_comment['created_at']);
  ?>
    <div class="col-md-9 col-md-offset-2 subComment" >
        <div class="panel panel-default" style="border-color:#1ABC9C">
          <div class="panel-body" style="background-color:#f4f4f4">
          <h6 style="padding-left:20px;">Comment : <?php echo "".($index_comment+1)."-".($index_sub_comment+1); ?></h6>
          <div class="row">
            <div class="col-md-1" >
                <center>
                  <?php
                  if(isPersonLoginCurrent($row_sub_comment['users_id'])){
                    echo"<span class='fui-triangle-up fa-2x'></span><br>";
                  }
                  else{
                  }
                  ?>
                  <b>0</b><br>
                  <?php
                  if(isPersonLoginCurrent($row_sub_comment['users_id'])){
                    echo"<span class='fui-triangle-down fa-2x'></span><br>";
                  }
                  else{
                  }
                  ?>
                </center>
              </div>
            <div class="col-md-11" >
              <p style="padding-left:20px;padding-right:20px;"><?php echo"$sub_comment_body";?></p>
            </div>
          </div>
        <hr style="border-color:#1ABC9C">
        <div class="col-md-1" style="margin-right:0px;"><img src="" width="50" height="50"></div>
        <div class="col-md-5">
          <p style="padding-left:20px;padding-right:20px;"><font size="3"><?php echo"<a href='".url('profile/'.$sub_comment_users_id)."'> $sub_comment_username";?></a>
          <br><?php echo"$sub_comment_created_at ";?>
          </font></p>
        </div>
         <div class="col-md-6" style="text-align:right">
          <a id="btnRequestRemoveSubComment" class="btn btn-danger" data-comment-id="{{$comment_id}}" data-sub-comment-id="{{$sub_comment_id}}" ><span class="glyphicon glyphicon-trash" style="aligh:right"></span> Remove</a>
          <a style="margin-left:2px" <?php echo"href='#addsubcommenttocomment"."$index_comment"."'";?> class="modalComment btn btn-primary" style="float: right;"  
              data-id-comment="<?php echo "$index_comment";?>" ><span class="glyphicon glyphicon-pencil"></span> Reply this comment</a>
          <!--
            <a class="modalComment btn btn-primary" href="#modalSubComment" data-toggle="modal" data-id-topic="ASSS" >Reply</a>
         -->
         </div>

       </div>
      </div>
    </div>
  </div>

  <?php
    $index_sub_comment++;
    }
  }
?>

</div>


<div class="col-md-9 col-md-offset-2">
 <?php echo"<a name='addsubcommenttocomment"."$index_comment"."'></a>"; ?>
</div>
<!--
  //Add SubComment.
-->
    <div class="col-md-9 col-md-offset-2 comment-textarea" <?php echo"id='comment-$index_comment'";?> >
      
      <div class="panel panel-default" style="background-color: #1ABC9C;">
        <div class="panel-heading" style="background-color: #1ABC9C;color:white"> 
          <b>Reply to this comment</b>
         
        </div>
        <div class="panel-body" style="background-color:#f4f4f4">

        @if (Auth::guest())
        <div class="col-md-11 col-md-offset-1">
          Please login.<br>
          <a  href="{{ url('/login') }}" class="btn btn-primary">Login</a>
        </div>
        @else
          <form class="form-horizontal" role="form" method="POST" action="{{ url('/subcomment/new') }}">
            <input type="hidden" name="topic_id"   value="<?php echo"$topic_id";?>">
            <input type="hidden" name="comment_id" value="<?php echo"$comment_id";?>">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
              <div class="col-md-12">
                <textarea style="resize: vertical;" rows="3" class="summernote" name="sub_comment_body" placeholder="Comment ..." maxlenght="10000" minlenght="3" required></textarea>
              </div>
              <div class="col-md-11">
                <font size="2">You can write maximium lenght 10,000 character.</font>
              </div>
            </div>

            <div class="form-group">
              <button type="button" class="comment-textarea-close btn btn-default" 
                      style="margin-left:20px" data-id-comment="<?php echo "$index_comment";?>">Close</button>
              <button type="submit" class="btn btn-primary">
                Send
              </button>
            </div>
          </form>
          @endif
        </div>
      </div>
    </div>



<?php
  $index_comment++; 
  }
?>


<!--
  //Input add comment.
-->

<div class="col-md-10 col-md-offset-1"><a name="addcommenttopost"></a>
      <div class="panel panel-default" style="background-color: #1ABC9C;">
        <div class="panel-heading" style="background-color: #1ABC9C;color:white"> <b>Comment</b></div>
        <div class="panel-body" style="background-color:#f4f4f4">
        @if (Auth::guest())
        <div class="col-md-11 col-md-offset-1">
          Please login.<br>
          <a  href="{{ url('/login') }}" class="btn btn-primary">Login</a>
        </div>
        @else
          <form class="form-horizontal" id="form_new_comment" role="form" enctype="multipart/form-data" 
                method="POST" action="{{ url('/comment/new') }}"
                >
            
            <input type="hidden" name="topic_id" value="<?php echo"$topic_id";?>">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
              <div class="col-md-12">
                <textarea class="summernote"  id="#contentsNewComment" title="Contents"
                 name="comment_body" enctype="multipart/form-data"
                placeholder="Comment ..."  required></textarea>
              </div>
              <div class="col-md-11">
                <font size="2">You can write maximium lenght 10,000 character.</font>
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-11 ">
                <button type="submit" class="btn btn-primary" id="submitNewComment">
                  Send 
                </button>
              </div>
               <div class="col-md-1 ">
                <a href="#top" class="smoothScroll">Top</a>
               </div>
            </div>
          </form>
          @endif
        </div>
      </div>
    </div>

    

<script type="text/javascript">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

   $(function() {
      $('.summernote').summernote({
        height: 500,
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

      //$('#form_new_comment').on('submit', function (e) {
      //  e.preventDefault();
      //  alert($('.summernote').code());
      //});


    });


$(function() {
  // This will select everything with the class smoothScroll
  // This should prevent problems with carousel, scrollspy, etc...
  $('.smoothScroll').click(function() {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top
        }, 1000); // The number here represents the speed of the scroll in milliseconds
        return false;
      }
    }
  });
});


$(document).ready(function(){
    $(".comment-textarea").hide();
    //$(".subComment").hide();
    //$(".subComment").hide();

});

// smooth scrolling to textarea and toggle show textarea. 
$(document).on("click", ".modalComment", function () {
    var comment_id = $(this).data('id-comment');

    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        // display textarea.
        if($( "#comment-"+comment_id).is( ":hidden" )){
          $( "#comment-"+comment_id ).slideToggle( "slow", function() {
            // Animation complete.
          });
        }
        // scrolling.
        $('html,body').animate({
          scrollTop: target.offset().top
        }, 1000); // The number here represents the speed of the scroll in milliseconds
        return false;
      }
    } 
});

$(document).on("click", ".comment-textarea-close", function () {
    var comment_id = $(this).data('id-comment');
     $( "#comment-"+comment_id ).slideToggle( "slow", function() {
    // Animation complete.
    });
});

$(document).on("click", ".showSubComment", function () {
    var comment_id = $(this).data('id-comment');
    //console.log(comment_id );
     $( "#subcomment-"+comment_id ).slideToggle("slow", function() {
          console.log(comment_id );
    });
});


/*
$(document).on("click", ".modalComment", function () {
     var myBookId = $(this).data('id-comment');
     $(".modal-body #topicId").val( myBookId );
     $('#modalSubComment').modal('show');
});
*/
$(document).on("click", ".modalRemovePost", function () {
     var myBookId = $(this).data('id-topic');
     $(".modal-body #topicId").val( myBookId );
     $('#modalSubComment').modal('show');
});


<?php
  function printNameVoteResult($data_poll_result){
    for($i=0;$i<count($data_poll_result);$i++){
      if($i<count($data_poll_result)){
        echo"'".$data_poll_result[$i]['name']."',";
      }else{
        echo"'".$data_poll_result[$i]['name']."'";
      }
    }
  }
?>

<?php
  function printValueVoteResult($data_poll_result){
    for($i=0;$i<count($data_poll_result);$i++){
      if($i<count($data_poll_result)){
        echo"".$data_poll_result[$i]['vote_count'].",";
      }else{
        echo"".$data_poll_result[$i]['vote_count']."";
      }
    }
  }
?>


// poll chart.
$(function () {
  event.preventDefault()
    $('#container').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Poll result'
        },
        subtitle: {
            text: '<?php echo"$title";?>'
        },
        xAxis: {
            categories: [<?php echo printNameVoteResult($data_poll_result);?>],
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'vote',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' millions'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Vote',
            //data: [107,100,100,100,100]
            data : [<?php echo printValueVoteResult($data_poll_result);?>]
        }]
    });
});

   $(document).on("click", "#btnRequestRemoveComment", function () {
          $("#modalRequestRemove #request_comment_id").val("none");
         $("#modalRequestRemove #request_sub_comment_id").val("none");

         var  comment_id = $(this).data('comment-id');
         console.log(comment_id);
         $("#modalRequestRemove #request_comment_id").val(comment_id);
         $('#modalRequestRemove').modal('show');
    });

    $(document).on("click", "#btnRequestRemoveSubComment", function () {
         $("#modalRequestRemove #request_comment_id").val("none");
         $("#modalRequestRemove #request_sub_comment_id").val("none");

        var  comment_id = $(this).data('comment-id');
         var  sub_comment_id = $(this).data('sub-comment-id');
         console.log(sub_comment_id);
         $("#modalRequestRemove #request_comment_id").val(comment_id);
         $("#modalRequestRemove #request_sub_comment_id").val(sub_comment_id);
         $('#modalRequestRemove').modal('show');
    });

    // modal response request remove.
    <?php
    if($flag_request){
    ?>
      $(function () {
        $('#modalRequestDone').modal('show');
      });
    <?php
    }
    ?>

    // modal response add favorite.
    <?php
    if($flag_add_favorite){
    ?>
      $(function () {
        $('#modalAddFavoriteDone').modal('show');
      });
    <?php
    }
    ?>



    $(document).ready(function(){
      $('.mypopover').popover({ 
        html : true,
        content: function() {
          return $('#popover_content_wrapper').html();
        }
      });
    });
</script>

<!--  
  //Modal sub comment 
-->

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalSubComment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" style="width: 80%;" role="document">
    <div class="modal-content">
      <div class="modal-header" >
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel" >Reply to comment</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <input type="text" id="topicId" >
            <label for="message-text" class="control-label">Message:</label>
            <textarea class="form-control" id="message-text" style="resize: vertical;" rows="10"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalRequestRemove" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" style="width: 50%;" role="document">
    <div class="modal-content">
      <div class="modal-header" >
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel" >Reqest to remove this</h4>
      </div>
      <form action="{{ url('request/remove')}}" method="post">
      <input type="hidden" name="_token" value="{{ csrf_token() }}" >
      <input type="hidden" name="request_topic_id" id="request_topic_id" value="{{$topic_id}}">
      <input type="hidden" name="request_comment_id" id="request_comment_id" value="">
      <input type="hidden" name="request_sub_comment_id" id="request_sub_comment_id" value="">
      <div class="modal-body">
          <div class="form-group"> 
            <input type="radio" name="reason_main" value="I received direct damage from this" data-toggle="radio" checked="">
                I received direct damage from this.
            <br><input type="radio" name="reason_main" value="It is not appropriate with reader" data-toggle="radio" >
                It is not appropriate with reader.
            <br><input type="radio" name="reason_main" value="Other" data-toggle="radio">
                Other.
          </div>
          <div class="form-group">
            More description or reason for support your request.
            <textarea name="reason_detail" class="form-control" rows="5" placeholder="I think.."></textarea>
          </div>
          <div class="form-group">
            More description for contact you
            <textarea name="contact_detail" class="form-control" rows="2" placeholder="email , phone"></textarea>
            you can send more detail to benznest.developer@gmail.com
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-send"></span>  Send</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalRequestDone" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" style="width: 50%;" role="document">
    <div class="modal-content">
      <div class="modal-header" >
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel" >Done</h4>
      </div>
      <div class="modal-body">
          <div class="form-group"> 
            <h4>Thank you for your request.</h4>
            Please don't sent repeat. and wait feedback from us.
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Finish</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalAddFavoriteDone" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" style="width: 50%;" role="document">
    <div class="modal-content">
      <div class="modal-header" >
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel" >Done</h4>
      </div>
      <div class="modal-body">
          <div class="form-group"> 
            <h4>Add topic to your favorite list done.</h4>
            You can check your topic in menu my favorite topic.
          </div>
      </div>
      <div class="modal-footer">
        <a href="{{ url('/favorite') }}" class="btn btn-success">Go to My favorite topic</a>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Finish</button>
      </div>
    </div>
  </div>
</div>

@include('footer')
@endsection
