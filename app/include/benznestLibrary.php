<?php 
  // for print icon rating.
  function echoRatingHappy($count,$size,$print_count){
    $str="";
    if($count == 0){
      $str="ไม่ระบุ";
    }else{
      if($print_count){
        $str .="$count ";
      }
      $color = array('#ff7f7f','#ff6666','#ff4c4c','#ff3232','#ff0000');
      for($i=0;$i<$count;$i++){
        $str .= " <span class='glyphicon glyphicon-heart fa-".$size."x' style='color:".$color[$i]."'></span>";
      }
    }
    return $str;
  }

  // for print icon priority.
  function echoPriority($count,$size,$print_count){
    $str="";
    if($count == 0){
      $str="ไม่ระบุ";
    }
    else{
      if($print_count){
        $str .="$count ";
      }
      $color = array('#feff99','#feff7f','#fdff66','#fdff4c','gold');
      for($i=0;$i<$count;$i++){

         $str .= " <span class='glyphicon glyphicon-star fa-".$size."x' style='color:".$color[$i]."'></span>";
      }
    }
    return $str;
  }

  function getIconweather($weather,$size){
    $str="";
    if($weather == 0 || $weather=="ไม่ระบุ"){

    }else if($weather == 1 || $weather=="อากาศดี"){
       $str="<span class='wi wi-day-cloudy fa-".$size."x' style='color:#1d99d4'></span>";
    }else if($weather == 2 || $weather=="อากาศร้อน"){
       $str="<span class='wi wi-day-sunny fa-".$size."x' style='color:#ffff00'></span>";
    }else if($weather == 3 || $weather=="พายุ"){
       $str="<span class='wi wi-thunderstorm fa-".$size."x' style='color:#373C31'></span>";
    }else if($weather == 4 || $weather=="ฝนตก"){
       $str="<span class='wi wi-rain-mix fa-".$size."x' style='color:#b2b1ce'></span>";
    }else if($weather == 5 || $weather=="เมฆมาก"){
       $str="<span class='wi wi-cloudy fa-".$size."x' style='color:#1d99d4'></span>";
    }else if($weather == 6 || $weather=="หนาวเย็น"){
       $str="<span class='wi wi-snowflake-cold fa-".$size."x' style='color:#1d99d4'></span>";
    }
    return $str;
  }

  function getWeather($weather){
    $str="ไม่ระบุ";
    if($weather == 0 ){
      $str=="ไม่ระบุ";
    }else if($weather == 1 ){
       $str="อากาศดี";
    }else if($weather == 2 ){
       $str="อากาศร้อน";
    }else if($weather == 3 ){
       $str="พายุ";
    }else if($weather == 4 ){
       $str="ฝนตก";
    }else if($weather == 5 ){
       $str="เมฆมาก";
    }else if($weather == 6 ){
       $str="หนาวเย็น";
    }
    return $str;
  }
?>