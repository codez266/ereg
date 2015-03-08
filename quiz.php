<?php
include_once 'php/function.php';
//require_once 'check.php';
//require_once 'db.php';
?>
<html>
	<head>
		<title>E-WEEK IITP B-QUIZ</title>
		<link rel="stylesheet" type="text/css" href="css/quiz.css" />
	</head>
	<body onload="startTimer();">


		<div class="body">
			<div class="topbar">
				<div class="user">Welcome -username-</div>
				<div class="ops"></div>
			</div>
			<div class="main">
				<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
					<?php
						$current_question = -1;
						if(isset($_POST['StartQuiz'])){
							$current_question = 1;
						}
						else if(isset($_POST['Next']) && isset($_POST['NextQuestion'])){
							$current_question = $_POST['NextQuestion'];
							if(isset($_POST['answer'])){
								$prev_answer = $_POST['answer'];
								// write down the answer for this user somewhere
							}
						}
						else{
							?>
							<!--<script> window.location = 'index.php'; </script>-->
							<?php
						}
						$res = getQuizQuestion($current_question);
						$arr = mysqli_fetch_array($res);
					?>
					<div class="question">
						<?php
							echo $arr['question'];
						?>
					</div>
					<div class="media">
						<?php
							if(!empty($arr['media'])){
								?>
								<iframe height=100% width=100% src="<?php echo 'media/'.$arr['media']; ?>"></iframe>
								<?php
							}
						?>
					</div>
					<div class="options">
						<ul>
							<?php
								echo '<li><input type="radio" name="answer" value="1" />'.$arr['option1'].'</li>';
								echo '<li><input type="radio" name="answer" value="2" />'.$arr['option2'].'</li>';
								echo '<li><input type="radio" name="answer" value="3" />'.$arr['option3'].'</li>';
								echo '<li><input type="radio" name="answer" value="4" />'.$arr['option4'].'</li>';
							?>
						</ul>
					</div>
					<div class="submit">
							<input type="text" hidden="hidden" name="NextQuestion" value="<?php $current_question = $current_question + 1; echo $current_question; ?>">
							<input class="button" type="submit" name="Next" value="Next Question" />
					</div>
			</div>
			<div class="sidebar">
				<h3>Questions</h3>
				<p>
						<table align="center">
							<?php
								$num = 1;
								for ($i=0; $i < 5; $i++) {
									echo '<tr>';
									for ($j=0; $j < 10; $j++) {
										if($num < $current_question-1){
											echo '<td style="color:green">'.$num.'</td>';
										}
										else{
											echo '<td>'.$num.'</td>';
										}
										$num++;
									}
									echo '</tr>';
								}
							?>
						</table>
				</p>

				<h3>Timer</h3>
				<script>
					function startTimer() {
						var Minutes = 3600,
						display = document.getElementById("time"),
						mins, seconds;

						setInterval(function() {
							mins = parseInt(Minutes / 60)
							seconds = parseInt(Minutes % 60);
							seconds = seconds < 10 ? "0" + seconds : seconds;

							display.innerHTML = "<b>" + mins + "</b>" + " mins " + "<b>" + seconds + "</b>" + " secs left";
							Minutes--;

							if (Minutes < 0) {
							    display.innerHTML = "<div class='timeout'><span>Time out!<br><br></span>Click on the button to submit your answers. <input class='button' type='submit' value='submit'></div>";
							}
						}, 1000);
					}
				</script>

				<p><img src="images/clock.png" width=30%><br><br><span id="time"></span></p>
			</div>
		</div>
			<div class="footer">
				Footer
			</div>


	</body>
</html>
