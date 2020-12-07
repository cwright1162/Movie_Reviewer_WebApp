<?php
	
	if (isset($_POST['review-submit'])) {
		
		session_start();
		
		require "dbh.inc.php";
		$conn = openConn();
		$movieid = $_POST["movieid"];
		$movietitle = $_POST["movietitle"];
		$rating = $_POST['rating'];
		$content = $_POST['review-content'];
		
		if (empty($rating) || empty($content)) {
			header("Location: ../movies/index.php?id=".$movietitle."&error=emptyfields");
			exit();
		}
		else {

			$sql = "INSERT INTO reviews (movies_id, users_id, rating, content) VALUES (?, ?, ?, ?);";
			$stmt = mysqli_stmt_init($conn);

			if (!mysqli_stmt_prepare($stmt, $sql)) {
					
				// Error inserting the user into the database
				header("Location: ../movies/index.php?id=".$movietitle."&submit=fail");
				exit();
				
			}
			else {
				
				mysqli_stmt_bind_param($stmt, "iiis", $movieid, $_SESSION["userid"], $rating, $content);
				mysqli_stmt_execute($stmt);
				
				header("Location: ../movies/index.php?id=".$movietitle."&submit=success");
				exit();
			}
			
		}
		
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		
	}
	
	function getAvgRating ($conn, $movieid) {
		
		$avgRating = 0;
		
		$sql = "SELECT movies.title, reviews.rating, users.username
				FROM reviews
				JOIN users ON users.id=reviews.users_id
				JOIN movies ON movies.id=reviews.movies_id
				WHERE movies.id='".$movieid."';";
				
		$result = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($result);
		
		if ($resultCheck > 0) {
			
			while ($row = mysqli_fetch_assoc($result)) {
				
				$avgRating += $row['rating'];
				
			}
		
			return $avgRating / $resultCheck;
			
		}
		else {
			
			return 0;
		
		}
	}
	
	function getUserReviews ($conn, $movieid) {
		
		$sql = "SELECT movies.title, users.username, reviews.rating, reviews.content
				FROM reviews
				JOIN users ON users.id=reviews.users_id
				JOIN movies ON movies.id=reviews.movies_id
				WHERE movies.id='".$movieid."';";
				
		$result = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($result);
		
		if ($resultCheck > 0) {
			
			while ($row = mysqli_fetch_assoc($result)) {
				
				// Display all user reviews
				echo "<div class='user-review'>
						<h5>Submitted by ".$row['username']."</h5>
						<h6>Score: ".$row['rating']."</h6>
						<p>".$row['content']."</p>
					</div>";
				
			}
			
		}
		else {
			echo "<div class='rev-empty'>
				<p>No Reviews yet!</p>
			</div>";
		}
		
	}
	
	function getUserId ($conn, $username) {
		
		$id = null;
		
		$sql = "SELECT id FROM users
				WHERE username=".$username.";";
				
		$result = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($result);
		
		if ($resultCheck > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$id = $row["id"];
			}
		}
		else {
			return null;
		}
		
	}		
	
	function modifyReview ($conn, $movieid, $username, $rating, $content) {
		
	}
	
	function isExistingUserReview ($conn, $movieid, $username) {
		
		$sql =  "SELECT movies.title, users.username, reviews.rating, reviews.content
				FROM reviews
				JOIN users ON users.id=reviews.users_id
				JOIN movies ON movies.id=reviews.movies_id
				WHERE movies.id='".$movieid."'
				AND users.username='".$username."';";
				
		$result = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($result);
		
		if ($resultCheck > 0) {
			return True;
		}
		else {
			return False;
		}
	}

?>