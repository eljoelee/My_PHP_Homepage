<?php
  $conn = mysqli_connect('localhost','root','1111','onside','3307');
  mysqli_select_db($conn, "onside");

  $title = $_POST['title'];
  $content = $_POST['content'];
  $bid = $_GET['bid'];

  $resultContent = str_ireplace("\r\n","<br>",$content);
  $resultContent = addslashes($resultContent);
  
  if(!empty($title) && !empty($content)){
    $query = "update board set title='$title', content='$resultContent' where bid = $bid";
    $result = mysqli_query($conn, $query);
  }else{
    header("Content-Type: text/html; charset=UTF-8");
    echo "<script>alert('제목과 글내용을 입력하세요.');history.back();</script>";
    exit;
  }
  if($result){
    header("Content-Type: text/html; charset=UTF-8");
	  echo "<script>location.replace('board_list.php');</script>";
	  exit;
 }
 mysqli_close($conn);
?>
