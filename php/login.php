<?php
  session_start();
  $username = $_POST['username'];
  $password = $_POST['password'];

  $conn = mysqli_connect('localhost','root','1111','onside','3307');
  mysqli_select_db($conn, "onside");

  if(!isset($username) || !isset($password)){
    header("Content-Type: text/html; charset=UTF-8");
    echo "<script>alert('아이디와 비밀번호를 입력하세요.');history.back();</script>";
    exit;
  }else{
    $query = "select * from member where username='$username'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    if($row['password'] == $password && !is_null($row['username'])){
      $_SESSION["username"] = $username;
      header("Content-Type: text/html; charset=UTF-8");
      echo "<script>location.replace('../php/board_list.php');</script>";
      exit;
    }else{
      header("Content-Type: text/html; charset=UTF-8");
      echo "<script>alert('비밀번호가 잘못되었거나 없는 아이디입니다.');history.back();</script>";
      exit;
    }
  }
  mysqli_close($conn);
?>
