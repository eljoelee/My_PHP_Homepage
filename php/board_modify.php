<?php
  session_start();
  if(!isset($_SESSION["username"])){
    header("Content-Type: text/html; charset=UTF-8");
    echo "<script>alert('로그인 하세요!');location.replace('../index.php');</script>";
    exit;
  }

  $conn = mysqli_connect('localhost','root','1111','onside','3307');
  mysqli_select_db($conn, "onside");

  $query = "select * from board where bid=".$_GET['bid'];
  $result = mysqli_query($conn,$query);
  $row = mysqli_fetch_assoc($result);
  $resultContent = str_ireplace("<br>","\r\n",$row['content']);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../assets/css/main.css" />
    <link rel="stylesheet" href="../css/board_insert.css" />
    <title></title>
</head>

<body>
    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Main -->
        <div id="main">
            <div class="inner">
                <!-- Header -->
                <header id="header">
                    <a href="../index.php" class="logo"><strong>Onside</strong> by Eljoe</a>
                </header>
                <!-- Banner -->
                <section id="banner">
                    <div class="content">
                      <form id="insert-form" action="board_modify_process.php?bid=<?=$_GET['bid']?>" method="post" role="form" style="display: block;">
                        <header id="form-header">
                          <input type="text" name="title" id="title" value="<?=$row['title']?>">
                          <input type="text" name="writer" id="writer" value="<?=$row["writer"]?>" readonly>
                        </header>
                        <textarea name="content" id="content"><?=$resultContent?></textarea>
                        <div id="btn-group">
                          <input type="submit" name="modify" id="modify" value="수정">
                          <input type="button" id="cancel" onclick="window.history.go(-1);" value="취소">
                        </div>
                      </form>
                    </div>
                </section>
            </div>
        </div>
        <!-- Sidebar -->
        <div id="sidebar">
            <div class="inner">
                <!-- Menu -->
                <nav id="menu">
                    <header class="major">
                        <h2>Menu</h2>
                    </header>
                    <ul>
                      <li><a href="../php/board_list.php">Board</a></li>
                      <li><a href="../selectable.php">Calendar</a></li>
                      <li><a href="../php/recommend_board.php">Recommend</a></li>
                      <li><a href="../php/logout.php">Log-out</a></li>
                    </ul>
                </nav>
                <!-- Footer -->
                <footer id="footer">
                    <p class="copyright">&copy; Untitled. All rights reserved. Demo Images: <a href="https://unsplash.com">Unsplash</a>. Design: <a href="https://html5up.net">HTML5 UP</a>.</p>
                </footer>
            </div>
        </div>
    </div>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/skel.min.js"></script>
    <script src="../assets/js/util.js"></script>
    <script src="../assets/js/main.js"></script>
</body>

</html>
