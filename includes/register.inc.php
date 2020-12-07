<?php
	if (isset($_POST['register'])) {
		
		require "dbh.inc.php";
		
		$conn = openConn();
		
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];
		$username = $_POST['userid'];
		$password = $_POST['pwd'];
		$pwd_confirm = $_POST['pwd_confirm'];
		
		// Check that user has input all necessary information inside register form
		if ( empty($firstname) || empty($lastname) || empty($email) || empty($username) || empty($password) || empty($pwd_confirm) ) {
			
			header("Location: ../login.php?error=emptyfields&fname=".$firstname."&lname=".$lastname."&mail=".$email."&user=".$username);
			exit();
			
		}
		// Check for valid username and email
		else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
			
			header("Location: ../login.php?error=invalidmailuid&fname=".$firstname."&lname=".$lastname);
			exit();
			
		}
		// Check that user input a valid email address
		else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			
			header("Location: ../login.php?error=invalidmail&fname=".$firstname."&lname=".$lastname."&user=".$username);
			exit();
			
		}
		// Check that the name inputs are valid
		else if (!preg_match("/^[a-zA-Z]/", $firstname) || !preg_match("/^[a-zA-Z]/", $lastname)) {
			
			header("Location: ../login.php?error=invalidname&mail=".$email."&user=".$username);
			exit();
			
		}
		// Check that the username input is valid
		else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
			
			header("Location: ../login.php?error=invaliduid&fname=".$firstname."&lname=".$lastname."&mail=".$email);
			exit();
			
		}
		// Check that the passwords entered match eachother
		else if ($password !== $pwd_confirm) {
			
			header("Location: ../login.php?error=pwdmismatch&fname=".$firstname."&lname=".$lastname."&mail=".$email."&user=".$username);
			exit();
			
		}
		// Check that there's no current user with that email or username
		else {
			
			$sql = "SELECT username FROM users WHERE username=? AND email=?";
			$stmt = mysqli_stmt_init($conn);
			
			if (!mysqli_stmt_prepare($stmt, $sql)) {
				
				// sql statement incorrect
				header("Location: ../login.php?error=sqlerror1");
				exit();
				
			}
			else {
				
				mysqli_stmt_bind_param($stmt, "ss", $username, $email);
				mysqli_stmt_execute($stmt);
				
				mysqli_stmt_store_result($stmt);
				$resultCheck = mysqli_stmt_num_rows($stmt);
				
				//Is there already a user with that username or email in the database?
				if ($resultCheck > 0) {
					
					// Send them back and stop the process
					header("Location: ../login.php?error=useroremailtaken&fname=".$firstname."&lname=".$lastname);
					exit();
					
				}
				else {
					
					$sql = "INSERT INTO users (username, password, email, first_name, last_name) VALUES (?, ?, ?, ?, ?)";
					$stmt = mysqli_stmt_init($conn);
					
					if (!mysqli_stmt_prepare($stmt, $sql)) {
				
						// Error inserting the user into the database
						header("Location: ../login.php?error=sqlerror2");
						exit();
						
					}
					else {
						$hashedPwd = password_hash($password, PASSWORD_DEFAULT);
						
						mysqli_stmt_bind_param($stmt, "sssss", $username, $hashedPwd, $email, $firstname, $lastname);
						mysqli_stmt_execute($stmt);
						header("Location: ../login.php?signup=success");
						exit();
						
					}
					
				}
				
			}
			
		}
		
		mysqli_stmt_close($stmt);
		closeConn($conn);
		
	}
	else {
		
		header("Location: ../login.php?");
		exit();
		
	}

?>