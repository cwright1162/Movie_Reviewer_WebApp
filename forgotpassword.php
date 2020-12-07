<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<title>Account Recovery | Movie Reviewer</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

<!-- Font Awesome JS -->
<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/brands.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

</head>
<body class="container justify-content-center">

<header>
	<a href="index.php">
	<i class="fas fa-film fa-5x"></i>
	</a>
</header>

<div class="recovery-wrapper">

	<h2>Forgot your password?</h2>
	<p>No need to worry! We've got you covered. Please enter your email in the space below and we will help you reset your password.</p>
	
	<?php
		if (isset($_GET["reset"])) {
			
			if ($_GET["reset"] == "success") {
				echo '<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Okay!</strong> An email will be sent to your account shortly! Follow the link provided in that email to change your password.
				</div>';
			}
		}
		else if (isset($_GET['pwdupdate'])) {
			
			if ($_GET["pwdupdate"] == "success") {
				echo '<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Success!</strong> Your password has been changed!
				</div>';
			}
			
		}
	?>
	
	<form action="includes/recover.inc.php" method="post">
	
		<input type="text" name="email" placeholder="Email..." style="width: 400px;">
		<button type="submit" name="recover-continue">Continue</button>
	
	</form>

</div>

</body>
</html>