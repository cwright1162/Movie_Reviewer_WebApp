<?php

	if (isset($_POST['login-submit'])) {
		
		require "dbh.inc.php";
		
		$conn = openConn();
		
		$username = $_POST['login-uid'];
		$password = $_POST['login-pwd'];
		
		if (empty($username) || empty($password)) {
			
			header("Location: ../login.php?error=emptyfields");
			exit();
			
		}
		else {
			
			$sql = "SELECT * FROM users WHERE username=?;";
			$stmt = mysqli_stmt_init($conn);
			
			if (!mysqli_stmt_prepare($stmt, $sql)) {
				
				// SQL statement error
				header("Location: ../login.php?error=sqlerror1");
				exit();
				
			}
			else {
				
				mysqli_stmt_bind_param($stmt, "s", $username);
				mysqli_stmt_execute($stmt);
				
				$result = mysqli_stmt_get_result($stmt);
				
				if ($row = mysqli_fetch_assoc($result)) {
					
					$pwdCheck = password_verify($password, $row['password']);
					
					if ($pwdCheck == false) {
						
						header("Location: ../login.php?error=invalidPassword");
						exit();
						
					}
					else if ($pwdCheck == true) {
						
						session_start();
						$_SESSION['userid'] = $row['id'];
						$_SESSION['username'] = $row['username'];
						$_SESSION['op'] = $row['op_level'];
						
						header("Location: ../index.php?login=success");
						exit();
						
					}
					// There is no reason this case should ever occur, but for security, we will keep it
					else {
						
						header("Location: ../login.php?");
						exit();
						
					}
					
				}
				else {
					
					header("Location: ../login.php?error=invalidUser");
					exit();
					
				}
				
			}
			
		}
		
	}
	else {
		header("Location: ../login.php?");
		exit();
	}
?>