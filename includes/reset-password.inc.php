<?php

	if (isset($_POST['reset-password-submit'])) {
		
		$selector = $_POST['selector'];
		$validator = $_POST['validator'];
		$password = $_POST['pwd'];
		$passwordConfirm = $_POST['pwd-confirm'];
		
		if (empty($password) || empty($passwordConfirm)) {
			
			header("Location: ../recoveraccount.php?error=emptyfields");
			exit();
			
		}
		else if ($password != $passwordConfirm) {
			
			header("Location: ../forgotpassword.php?error=passwordmismatch");
			exit();
			
		}
		
		$currentDate = date("U");
		
		require "dbh.inc.php";
		
		$conn = openConn();
		
		$sql = "SELECT * FROM pwd_reset WHERE reset_selector=? AND reset_expires >= ".$currentDate.";";
		$stmt = mysqli_stmt_init($conn);
		
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			
			echo "There was an error 1!";
			exit();
			
		}
		else {
			
			mysqli_stmt_bind_param($stmt, "s", $selector);
			mysqli_stmt_execute($stmt);
			
			$result = mysqli_stmt_get_result($stmt);
			
			if (!$row = mysqli_fetch_assoc($result)) {
				
				echo "Please resubmit your reset request 1.";
				exit();
				
			}
			else {
				
				$tokenBin = hex2bin($validator);
				$tokenCheck = password_verify($tokenBin, $row['reset_token']);
				
				if ($tokenCheck == false) {
					
					echo "Please resubmit your reset request 2.";
					exit();
					
				}
				else if ($tokenCheck == true) {
					
					$tokenEmail = $row['email'];
					$sql = "SELECT * FROM users WHERE email=?;";
					$stmt = mysqli_stmt_init($conn);
					
					if (!mysqli_stmt_prepare($stmt, $sql)) {
			
						echo "There was an error 2!";
						exit();
			
					}
					else {
						
						mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
						mysqli_stmt_execute($stmt);
						$result = mysqli_stmt_get_result($stmt);
						
						if (!$row = mysqli_fetch_assoc($result)) {
							
							echo "Please resubmit your reset request.";
							exit();
							
						}
						else {
							
							$sql = "UPDATE users SET password=? WHERE email=?;";
							$stmt = mysqli_stmt_init($conn);
					
							if (!mysqli_stmt_prepare($stmt, $sql)) {
					
								echo "There was an error 3!";
								exit();
					
							}
							else {
								
								$hashedPwd = password_hash($password, PASSWORD_DEFAULT);
								mysqli_stmt_bind_param($stmt, "ss", $hashedPwd, $tokenEmail);
								mysqli_stmt_execute($stmt);
								
								$sql = "DELETE FROM pwd_reset WHERE email=?;";
								$stmt = mysqli_stmt_init($conn);
						
								if (!mysqli_stmt_prepare($stmt, $sql)) {
						
									echo "There was an error 4!";
									exit();
						
								}
								else {
									
									mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
									mysqli_stmt_execute($stmt);
									header("Location: ../forgotpassword.php?pwdupdate=success");
									
								}
								
							}
							
						}
						
					}
					
				}
				else {
					
					echo "Please resubmit your reset request.";
					exit();
					
				}
				
			}
			
		}
		
	}
	else {
		
		header("Location: ../index.php");
		exit();
		
	}

?>