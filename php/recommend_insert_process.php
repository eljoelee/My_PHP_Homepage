<?php
  $conn = mysqli_connect('localhost','root','1111','onside','3307');
  mysqli_select_db($conn, "onside");

  $title = $_POST['title'];
  $writer = $_POST['writer'];
  $content = $_POST['content'];
  $link = $_POST['link'];

  $title = addslashes($title);
  $content = addslashes($content);

  if(!empty($title) && !empty($content) && !empty($link)){
    $query = "insert into recommend(title, link, content, writer, wdate) values('$title','$link','$content', '$writer', now())";
    $result = mysqli_query($conn, $query);
  }else{
    header("Content-Type: text/html; charset=UTF-8");
    echo "<script>alert('제목과 소개글, 링크를 입력하세요.');history.back();</script>";
    exit;
  }
  if($result){
    header("Content-Type: text/html; charset=UTF-8");
	  echo "<script>location.replace('recommend_board.php');</script>";
	  exit;
 }
 mysqli_close($conn);
?>
