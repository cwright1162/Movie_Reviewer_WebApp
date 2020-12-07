<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<title>Sign-in | Movie Reviewer</title>

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
<body">

<header class="flex-break">
	<a href="index.php">
	<i class="fas fa-film fa-5x"></i>
	</a>
</header>

<div class="login-wrapper">

	<div class="flex-break">
		<h2>Sign-in</h2>
	</div>
	
	<form action="includes/login.inc.php" method="post">
	
		<input type="text" name="login-uid" placeholder="Username..."><br>
		<input type="password" name="login-pwd" placeholder="Password...">
		<button type="submit" name="login-submit">Login</button>
	
	</form>
	
	<div class="flex-break">
		<a href="forgotpassword.php">forgot your password?</a>
	</div>

</div>

<div id="spacer">
	<span><hr><p>New to Movie Reviewer?</p><hr></span>
</div>

<div class="register-wrapper">
	
	<div class="flex-break">
		<h2>Register</h2>
	</div>
	
	<?php
	
		if (isset($_GET['error'])) {
			
			if ($_GET['error'] == "emptyfields") {
				echo '<div class="alert alert-warning alert-dismissible">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Whoops!</strong> You must fill in all fields before you are registered!
				</div>';
			}
			
		}
		
	?>
	
	<form action="includes/register.inc.php" method="post">
	
		<input type="text" name="firstname" placeholder="First Name...">
		<input type="text" name="lastname" placeholder="Last Name..."><br>
		<input type="text" name="userid" placeholder="Username..."><br>
		<input type="password" name="pwd" placeholder="Password...">
		<input type="password" name="pwd_confirm" placeholder="Confirm Password..."><br>
		<input type="text" name="email" placeholder="Email..."><br>
		<div class="flex-break">
			<button type="submit" name="register">Register</button>
		</div>
	
	</form>

</div>

</body>
</html>