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

  $query = "select * from recommend order by rid DESC";

  $result = mysqli_query($conn,$query);

  $total_post = mysqli_num_rows($result);

  $post_per_page = 9; //한 페이지에 보여줄 게시글 수

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
    $paging .= '<li><a href="recommend_board.php?page=1" class="page">처음</a></li>';
  }
  if($currentBlock  != 1) {
		$paging .= '<li><a href="recommend_board.php?page=' . $prevPage . '"class="page">Prev</a></li>';
	}
  for($i = $firstPage; $i <= $lastPage; $i++) {
		if($i == $page) {
			$paging .= '<li>' . $i . '</li>';
		} else {
			$paging .= '<li><a href="recommend_board.php?page=' . $i . '"class="page">' . $i . '</a></li>';
		}
	}

  if($currentBlock != $total_block && $total_block != 0) {
		$paging .= '<li><a href="recommend_board.php?page=' . $nextPage . '"class="page">다음</a></li>';
	}

	if($page != $total_page && $total_block != 0) {
		$paging .= '<li><a href="recommend_board.php?page=' . $total_page . '"class="page">끝</a></li>';
	}
	$paging .= '</ul>';

  $currentLimit = ($post_per_page * $page) - $post_per_page; //몇 번째의 글부터 가져오는지
	$sqlLimit = ' limit ' . $currentLimit . ', ' . $post_per_page; //limit sql 구문

	$query = 'select * from recommend order by rid desc' . $sqlLimit; //원하는 개수만큼 가져온다. (0번째부터 20번째까지
	$result = mysqli_query($conn,$query);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../assets/css/main.css"/>
    <link rel="stylesheet" href="../css/recommend_list.css" />
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
                      <div class="posts">
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

                            $source = explode("v=",$row['link']);

                        ?>
                          <?php echo "<article>"?>
                          <?php echo "<iframe width='350' height='197' src='https://www.youtube.com/embed/".$source[1]."' frameborder='0' allowfullscreen></iframe>"?>
                          <?php echo "<h3>".$row['title']."</h3>"?>
                          <?php echo "<p>".$row['content']."</p>"?>
                          <?php echo "<p>".$row['wdate']."</p>"?>
                          <?php echo "<p>".$row['writer']."님의 추천 트랙</p>"?>
                          <?php echo "</article>";}?>
                        </div>
                      <div class="paging">
                          <?php echo $paging ?>
                      </div>
                      <button type="button" class="btn" Onclick="location.replace('recommend_insert.php')">글쓰기</button>
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
