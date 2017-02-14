<?php
  session_start();
  if(!isset($_SESSION["username"])){
    header("Content-Type: text/html; charset=UTF-8");
    echo "<script>alert('로그인 하세요!');location.replace('../index.php');</script>";
    exit;
  }

    $page = (!empty($_GET['page']))?$_GET['page']:1;

    $conn = mysqli_connect('localhost','root','1111','onside','3307');
    mysqli_select_db($conn, "onside");

    $query = "select * from reply where bid=".$_GET['bid']." order by wdate DESC";

    $result = mysqli_query($conn,$query);

    $total_post = mysqli_num_rows($result);

    $post_per_page = 50; //한 페이지에 보여줄 게시글 수

    $total_page = ceil($total_post/$post_per_page);

    if($page < 1 && $page > $total_page){
      header("Content-Type: text/html; charset=UTF-8");
      echo "<script>alert('존재하지않는 페이지입니다!');history.back();</script>";
      exit;
    }

    $block = 5;

    $currentBlock = ceil($page/$block);

    $total_block = ceil($total_page/$block);

    $firstPage = ($currentBlock * $block) - ($block - 1);

    if($currentBlock == $total_block){
      $lastPage = $total_page;
    }elseif($total_block == 0){
      $lastPage = 1;
    }else{
      $lastPage = $currentBlock * $block;
    }

    $prevPage = (($currentBlock - 1) * $block);
    $nextPage = (($currentBlock + 1) * $block) - ($block - 1);

    $paging = '<ul class="pagination">';

    if($page != 1){
      $paging .= '<li><a href="board_content.php?bid='. $_GET['bid'] .'&page=1" class="page">처음</a></li>';
    }
    if($currentBlock  != 1) {
      $paging .= '<li><a href="board_content.php?bid='. $_GET['bid'] .'&page=' . $prevPage . '"class="page">Prev</a></li>';
    }
    for($i = $firstPage; $i <= $lastPage; $i++) {
      if($i == $page) {
        $paging .= '<li>' . $i . '</li>';
      } else {
        $paging .= '<li><a href="board_content.php?bid='. $_GET['bid'] .'&page=' . $i . '"class="page">' . $i . '</a></li>';
      }
    }

    if($currentBlock != $total_block && $total_block != 0) {
      $paging .= '<li><a href="board_content.php?bid='. $_GET['bid'] .'&page=' . $nextPage . '"class="page">다음</a></li>';
    }

    if($page != $total_page && $total_block != 0) {
      $paging .= '<li><a href="board_content.php?bid='. $_GET['bid'] .'&page=' . $total_page . '"class="page">끝</a></li>';
    }
    $paging .= '</ul>';

    $currentLimit = ($post_per_page * $page) - $post_per_page; //몇 번째의 글부터 가져오는지
    $sqlLimit = ' limit ' . $currentLimit . ', ' . $post_per_page; //limit sql 구문

    $sql = 'select * from reply where bid='.$_GET['bid'].' order by wdate desc' . $sqlLimit; //원하는 개수만큼 가져온다. (0번째부터 20번째까지
    $result = mysqli_query($conn,$sql);

    $bquery = "select * from board where bid=".$_GET['bid'];
    $bresult = mysqli_query($conn,$bquery);
    $brow = mysqli_fetch_assoc($bresult);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../assets/css/main.css" />
    <link rel="stylesheet" href="../css/board_content.css" />
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
                        <section>
                            <header class="main">
                                <div class="row">
                                    <div class="6u 12u$(small)">
                                      <h2><?=$brow['title']?></h2>
                                    </div>
                                    <div class="6u$ 12u$(small)">
                                      <h4><?=$brow['writer']?></h4>
                                    </div>
                                </div>
                            </header>
                            <div class="row">
                              <p><?=$brow['content']?></p>
                           </div>
                           <div class="btngroup">
                             <?php if($_SESSION["username"] == $brow['writer']){?>
                                <input type="button" class='modify' onclick='location.replace("../php/board_modify.php?bid=<?=$_GET["bid"]?>")' value="수정">
                                <input type="button" class='delete' onclick='location.replace("../php/board_delete.php?bid=<?=$_GET["bid"]?>")' value="삭제">
                             <?php }?>
                          </div>
                          <hr>
                          <?php
                            date_default_timezone_set("Asia/Seoul");

                            while($row = mysqli_fetch_assoc($result)){
                              $datetime = explode(' ', $row['wdate']);
                              $date = $datetime[0];
                              $time = $datetime[1];
                              if($date == Date('Y-m-d'))
                                $row['wdate'] = $time;
                              else
                                $row['wdate'] = $date;
                          ?>
                          <?php echo "<div class='reply_space'>" ?>
                            <p><?php echo $row['writer']?></p>
                            <p><?php echo $row['comment']?></p>
                            <p><?php echo $row['wdate']?></p>
                          <?php echo "</div><br>";}?>
                          <br>
                          <div class="paging">
  				                    <?php echo $paging ?>
  			                  </div>
                          <div id="reply_enter">
                            <form action="comment_insert_process.php" method="post" role="form" style="display: block;">
                              <input type="hidden" name="bid" value="<?=$_GET['bid']?>">
                              <input type="text" name="writer" id="writer" value="<?=$_SESSION['username']?>" readonly>
                              <input type="text" name="comment" id="comment" placeholder="comment" value="">
                              <input type="submit" name="register" id="register" value="등록">
                            </form>
                          </div>
                        </section>
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
