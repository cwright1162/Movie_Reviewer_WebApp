<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>Reset your password | Movie Reviewer</title>

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

	<div>
	
		<?php
			$selector = $_GET['selector'];
			$validator = $_GET['validator'];
			
			if(empty($selector) || empty($validator)) {
				
				echo "Could not validate your request.";
				
			}
			else {
				
				if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
					
					?>
					
					<div class="register-wrapper">
						<div class="flex-break">
							<h1>Movie Reviewer</h>
						</div>
						
						<div class="flex-break">
							<p>Reset your password</p>
						</div>
						
						<form action="includes/reset-password.inc.php" method="post">
							
							<input type="hidden" name="selector" value="<?php echo $selector ?>">
							<input type="hidden" name="validator" value="<?php echo $validator ?>">
							<input type="password" name="pwd" placeholder="New Password..."><br>
							<input type="password" name="pwd-confirm" placeholder="Confirm Password..."><br>
							<button type="submit" name="reset-password-submit">Reset Password</button>
							
						</form>
					</div>
					
					<?php
					
				}
				else {
					
					echo "There was an error with your request. Please resubmit your request.";
					
				}
				
			}
		?>
	
	</div>

</body>
</html>