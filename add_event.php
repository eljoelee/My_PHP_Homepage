<?php
  $title = $_POST["title"];
  $start = $_POST["start"];
  $end = $_POST["end"];
  $username = $_POST["username"];

  $conn = mysqli_connect('localhost','root','1111','onside','3307');
  mysqli_select_db($conn, "onside");

  $query = "insert into event(title, start, end, username)";
  $query = $query."values('$title','$start','$end','$username')";
  mysqli_query($conn, $query);

?>
