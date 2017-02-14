<?php
  session_start();

  $conn = mysqli_connect('localhost','root','1111','onside','3307');
  mysqli_select_db($conn, "onside");

  $query = "select * from event where username = '".$_SESSION["username"]."' ORDER BY id";

  $result = mysqli_query($conn,$query);
  $json = array();
  while ($row = mysqli_fetch_object($result)) {
    $t = new stdClass();
    $t->bid = $row->bid;
    $t->title = $row->title;
    $t->start = $row->start;
    $t->end = $row->end;
    $json[] = $t;
    unset($t);
  }

  echo json_encode($json);
?>
