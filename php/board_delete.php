<?php
  session_start();
  if(!isset($_SESSION["username"])){
    header("Content-Type: text/html; charset=UTF-8");
    echo "<script>alert('유효하지않은 접근입니다!');location.replace('../index.php');</script>";
    exit;
  }

  $conn = mysqli_connect('localhost','root','1111','onside','3307');
  mysqli_select_db($conn, "onside");

  $bid = $_GET['bid'];

  $query = "select * from board where bid=".$bid;
  $result = mysqli_query($conn,$query);
  $row = mysqli_fetch_assoc($result);

  if($_SESSION["username"] == $row['writer']){
    $query = "delete from board where bid = $bid";
    $result = mysqli_query($conn, $query);
    
    $query = "delete from reply where bid = $bid";
    $result = mysqli_query($conn, $query);
  }else{
    header("Content-Type: text/html; charset=UTF-8");
    echo "<script>alert('유효하지않은 접근입니다!');location.replace('board_list.php');</script>";
    exit;
  }

  if($result){
    header("Content-Type: text/html; charset=UTF-8");
	  echo "<script>location.replace('board_list.php');</script>";
	  exit;
 }

 mysqli_close($conn);
?>
