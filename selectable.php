<?php
session_start();
if(!isset($_SESSION["username"])){
	header("Content-Type: text/html; charset=UTF-8");
	echo "<script>alert('로그인 하세요!');location.replace('../index.php');</script>";
	exit;
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset='utf-8' />
	<link href='./fullcalendar/fullcalendar.css' rel='stylesheet' />
	<link href='./fullcalendar/fullcalendar.print.min.css' rel='stylesheet' media='print' />
	<script src='./fullcalendar/moment.min.js'></script>
	<script src='./fullcalendar/jquery.min.js'></script>
	<script src='./fullcalendar/fullcalendar.min.js'></script>
	<script src='./fullcalendar/locale-all.js'></script>
	<script>
		$(document).ready(function() {
			var d = new Date();
			var calendar = $('#calendar').fullCalendar({
				defaultDate: d,
				locale: 'ko',
				editable: true,
				events: "./event.php",
				selectable: true,
				selectHelper: true,
				displayEventTime: false,
				select: function(start, end, allDay) {
					var title = prompt('Event Title:');
					if (title) {
						start = moment(start).format('YYYY-MM-DD');
						end = moment(end).format('YYYY-MM-DD');
						$.ajax({
							url: './add_event.php',
							dataType: 'json',
							type: "POST",
							data: {
								title: title,
								start: start,
								end: end,
								username: '<?=$_SESSION["username"]?>'
							},
							success: function(data) {
								alert('OK');
							}
						});
						calendar.fullCalendar('renderEvent', {
								title: title,
								start: start,
								end: end,
								allDay: allDay
							},
							true
						);
					}
					calendar.fullCalendar('unselect');
				}
			});
		});
	</script>
	<style>
		@import url("http://fonts.googleapis.com/earlyaccess/jejugothic.css");
		body {
			margin: 40px 10px;
			padding: 0;
			font-family: 'Jeju Gothic', serif;
			font-size: 16px;
		}

		#calendar {
			max-width: 1200px;
			margin: 0 auto;
		}
	</style>
</head>

<body>
	<div id='calendar'></div>
</body>

</html>
