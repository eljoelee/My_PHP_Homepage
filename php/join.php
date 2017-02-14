<?php
  $conn = mysqli_connect('localhost','root','1111','onside','3307');
  mysqli_select_db($conn, "onside");

  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  if($password == $confirm_password){
    $pass = $password;
  }else{
    header("Content-Type: text/html; charset=UTF-8");
	  echo "<script>alert('비밀번호가 맞지 않습니다.');history.back();</script>";
	  exit;
  }

  if(!empty($username) && !empty($email) && !empty($password) && !empty($confirm_password)){
    $query = "insert into member(username, email, password)";
    $query = $query."values('$username','$email','$pass')";
    $result = mysqli_query($conn, $query);

    if($result){
      header("Content-Type: text/html; charset=UTF-8");
    	echo "<script>alert('회원가입을 축하드립니다.');history.back();</script>";
    	exit;
    }else{
      header("Content-Type: text/html; charset=UTF-8");
      echo "<script>alert('존재하는 아이디입니다.');history.back();</script>";
      exit;
    }
  }else{
    header("Content-Type: text/html; charset=UTF-8");
    echo "<script>alert('기입사항을 제대로 입력해주세요.');history.back();</script>";
    exit;
  }
  mysqli_close($conn);
?>
