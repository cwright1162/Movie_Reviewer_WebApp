<?php
	require "../header.php";
	require "../includes/directors.inc.php";
	require "../includes/user-ratings.inc.php";
	
	$movie_id = $_GET['id'];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<?php

	$sql = "SELECT * FROM movies WHERE title = '.$movie_id.';";
	$result = mysqli_query($conn, $sql);

	while ($row = mysqli_fetch_assoc($result)) {
		echo '<title>'.$row["title"].' | Movie Reviews</title>';
	}
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="../style.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

<!-- Font Awesome JS -->
<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/brands.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

</head>
<body>

<!-- Movie Info Display -->

<section class="container justify-content-center movie-about">

	<div class="wrapper-movie">

		<div class="movie-info">
			<?php

				$sql = "SELECT * FROM movies WHERE title = '$movie_id';";
				$result = mysqli_query($conn, $sql);
				$resultCheck = mysqli_num_rows($result);
				
				if ($resultCheck > 0) {
					
					while ($row = mysqli_fetch_assoc($result)) {
						
						$result_directors = getDirectors($conn, $row["title"]);
						
						echo '<h1>'.$row["title"].'</h1>
							<div id="movie-img" style="background-image: url(../img/movieposters/'.$row["image_id"].');"></div>
							<h4>User Rating: '.round(getAvgRating($conn, $row["id"]),2).' / 10</h4>
							<p>Release date: '.$row["release_date"].'</p>
							<p>Director(s): ';
							
						while($row_directors = mysqli_fetch_assoc($result_directors)) {

							echo $row_directors["first_name"] . ' ' . $row_directors["last_name"] . ' ';
								
						}
						echo '</p>
							<p>Movie Description: '.$row["desc"].'</p>
							<h4>Reviews: </h4>';
							
						// if user is logged in, let them write a review
						// if user has already created a review, let them modify it instead
						if (!empty($_SESSION)) {
							
							if (isset($_GET['error'])) {
			
								if ($_GET['error'] == "emptyfields") {
									echo '<div class="alert alert-warning alert-dismissible">
									<button type="button" class="close" data-dismiss="alert">&times;</button>
									<strong>Whoops!</strong> You must fill in all fields before you submit a review!
									</div>';
								}
							
							}
							
							if (!isExistingUserReview($conn, $row["id"], $_SESSION["username"])) {
								echo '<div class="write-review">
										<form method="post" action="../includes/user-ratings.inc.php">
											<p>Rating</p>
											<input type="hidden" name="movieid" value="'.$row["id"].'">
											<input type="hidden" name="movietitle" value="'.$row["title"].'">
											<input type="radio" id="rating1" name="rating" value="1">
											<label for="rating1">1</label>
											<input type="radio" id="rating2" name="rating" value="2">
											<label for="rating2">2</label>
											<input type="radio" id="rating3" name="rating" value="3">
											<label for="rating3">3</label>
											<input type="radio" id="rating4" name="rating" value="4">
											<label for="rating4">4</label>
											<input type="radio" id="rating5" name="rating" value="5">
											<label for="rating5">5</label>
											<input type="radio" id="rating6" name="rating" value="6">
											<label for="rating6">6</label>
											<input type="radio" id="rating7" name="rating" value="7">
											<label for="rating7">7</label>
											<input type="radio" id="rating8" name="rating" value="8">
											<label for="rating8">8</label>
											<input type="radio" id="rating9" name="rating" value="9">
											<label for="rating9">9</label>
											<input type="radio" id="rating10" name="rating" value="10">
											<label for="rating10">10</label>
											<br>
											<textarea name="review-content" style="width:600px; height:200px;"></textarea><br>
											<button type="submit" name="review-submit">Submit Review</button>
										</form>
									</div>';
							}
							else {
								
								echo '<div class="modify-review">
											<p>Looks like you have already submitted a review.</p>
									</div>';
							
							}
						}
						else {
							echo '<div class="write-review-locked">
									<h6>Login or register an account to write a review!</h6>
								</div>';
						}
						getUserReviews($conn, $row['id']);
					}
					
				}
				else {
					echo 'Whoops! Could not retrieve any information on the film..';
				}
			?>
		</div>
	
	</div>

</section>

<?php
	require "../footer.php";
?>

</body>
</html>