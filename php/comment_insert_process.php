<?php
  $conn = mysqli_connect('localhost','root','1111','onside','3307');
  mysqli_select_db($conn, "onside");

  $bid = $_POST['bid'];
  $writer = $_POST['writer'];
  $comment = $_POST['comment'];
  
  $comment = addslashes($comment);

  if(!empty($comment)){
    $query = "insert into reply(bid, comment, writer, wdate)";
    $query = $query."values('$bid','$comment','$writer',now())";
    $result = mysqli_query($conn, $query);
  }else{
    header("Content-Type: text/html; charset=UTF-8");
    echo "<script>alert('내용을 입력하세요.');history.back();</script>";
    exit;
  }
  if($result){
    header("Content-Type: text/html; charset=UTF-8");
	  echo "<script>location.replace('board_content.php?bid=".$bid."');</script>";
	  exit;
 }
 mysqli_close($conn);
?>
