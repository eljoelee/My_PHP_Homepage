<?php
session_start();
echo "<script>alert('로그아웃하셨습니다.');location.replace('../index.php');</script>";
session_destroy();
exit;
?>
