<?php

	if (isset($_POST['recover-continue'])) {
		
		$email = $_POST['email'];
		
		// Create a random token for the link to recover account
		$selector = bin2hex(random_bytes(8));
		$token = random_bytes(32);
		
		$url = "https://cw-movie-ratings.herokuapp.com//recoveraccount.php?selector=" . $selector . "&validator=" . bin2hex($token);
	
		// Make link expire in 1 hour from submission
		$expires = date("U") + 1800;
	
		if (empty($email)) {
		
			header("Location: ../forgotpassword.php?error=emptyfield");
			exit();
		
		}
		// Check database for valid email and send recovery email if valid
		else {
			
			require "dbh.inc.php";
			$conn = openConn();
			
			// Prepare sql statement to check db for valid email
			$sql = "SELECT email FROM users WHERE email=?;";
			$stmt = mysqli_stmt_init($conn);
			
			if (!mysqli_stmt_prepare($stmt, $sql)) {
				
				header("Location: ../forgotpassword.php?error=sqlerror1");
				exit();
				
			}
			else {
				
				mysqli_stmt_bind_param($stmt, "s", $email);
				mysqli_stmt_execute($stmt);
				
				$result = mysqli_stmt_get_result($stmt);
				
				if ($row = mysqli_fetch_assoc($result)) {
					
					if ($email == $row['email']) {
						
						$sql = "DELETE FROM pwd_reset WHERE email=?;";
						$stmt = mysqli_stmt_init($conn);
						
						if (!mysqli_stmt_prepare($stmt, $sql)) {
							
							header("Location: ../forgotpassword.php?error=sqlerror2");
							exit();
							
						}
						else {
							
							mysqli_stmt_bind_param($stmt, "s", $email);
							mysqli_stmt_execute($stmt);
							
							$sql = "INSERT INTO pwd_reset (email, reset_selector, reset_token, reset_expires) VALUES (?, ?, ?, ?);";
							$stmt = mysqli_stmt_init($conn);
							
							if (!mysqli_stmt_prepare($stmt, $sql)) {
								
								echo "There was an error!";
								exit();
								
							}
							else {
								
								$hashedToken = password_hash($token, PASSWORD_DEFAULT);
								mysqli_stmt_bind_param($stmt, "ssss", $email, $selector, $hashedToken, $expires);
								mysqli_stmt_execute($stmt);
								
							}
							
							mysqli_stmt_close($stmt);
							mysqli_close($conn);
							
							$to = $email;
							$subject = 'Reset your Movie Reviewer Password';
							$message = '<p>We recieved a password reset request for your account with Movie Reviewer. Please follow the link below to reset your password. If you did not make this request, you may ignore this email.</p>';
							$message .= '<p>Link: </br>';
							$message .= '<a href="'.$url.'">'.$url.'</a><p>';
							
							$headers = "From: Movie Reviewer Staff <cwright1162@gmail.com>\r\n";
							$headers .= "Reply-To: cwright1162@gmail.com\r\n";
							$headers .= "Content-type: text/html\r\n";
							
							mail($to, $subject, $message, $headers);
							
							header("Location: ../forgotpassword.php?reset=success&url=".$url);
							
						}
						
					}
					else {
						
						header("Location: ../forgotpassword.php?error=invalidemail");
						exit();
						
					}
					
				}
				
			}
			
		}
		
	}
	else {
		
		header("Location: ../forgotpassword.php?");
		exit();
		
	}
?>