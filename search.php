<?php
	require "header.php";
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<title>Search | Movie Reviews</title>

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
<body>

<!-- Movie display -->

<h2>Results</h2>
	
<section class="movie-links">
	<div class="wrapper">
	
		
		<div class="movie-container">
			<?php
			
				// If user clicks a genre link, show all movies with that genre
				if(isset($_GET['genre']) && !empty($_GET['genre'])) {

					$sql = "SELECT movies.*, 
							genres.genre
							FROM movies 
							JOIN genres_movies ON movies.id=genres_movies.movies_id 
							JOIN genres ON genres.id=genres_movies.genres_id 
							WHERE genres.genre='".$_GET['genre']."';";
							
					$result = mysqli_query($conn, $sql);
					$resultCheck = mysqli_num_rows($result);
					
					if ($resultCheck > 0) {
						while ($row = mysqli_fetch_assoc($result)) {
							
							echo '<a href="/movies/?id='.$row["title"].'">
								<div style="background-image: url(img/movieposters/'.$row["image_id"].');"></div>
								<h3>'.$row["title"].'</h3>
								<p>'.$row["release_date"].'</p>
							</a>';
							
						}
					}
					else {
						
						echo 'No results with that genre';
						
					}
					
				}
				// If user makes a search, return all matches whether it be title, genre, director, etc.
				else if (isset($_GET['search']) && !empty($_GET['search'])) {
					
						$search = $_GET["search"];
					
					// Selects all distinct records of a movie, director, or genre contains the substring provided by the search
					// Returns one instance of the movie by it's id as long as it matches
					$sql = "SELECT DISTINCT movies.*, genres.genre, directors.first_name, directors.last_name
							FROM movies
							JOIN genres_movies ON movies.id=genres_movies.movies_id 
							JOIN genres ON genres.id=genres_movies.genres_id 
							JOIN directors_movies ON movies.id=directors_movies.movies_id
							JOIN directors ON directors.id=directors_movies.directors_id
							WHERE title LIKE '%".$search."%' 
							OR genre LIKE '%".$search."%' 
							OR first_name LIKE '%".$search."%' 
							OR last_name LIKE '%".$search."%';";
					
					$result = mysqli_query($conn, $sql);
					$resultCheck = mysqli_num_rows($result);
					
					if ($resultCheck > 0) {
						
						$added_movies = [];
							
						while ($row = mysqli_fetch_assoc($result)) {
							
							// To prevent repeats, check an array to see if we've already added a movie the id
							
							if (!in_array($row["id"], $added_movies)) {

								echo '<a href="/movies/?id='.$row["title"].'">
									<div style="background-image: url(img/movieposters/'.$row["image_id"].');"></div>
									<h3>'.$row["title"].'</h3>
									<p>'.$row["release_date"].'</p>
								</a>';
								
								array_push($added_movies, $row["id"]);
							}
						}
						
					}
					else {
						
						echo "No results. Try a different search!";
						
					}
					
				}
				else {
					
					// show all movies
					$sql = "SELECT * FROM movies;";
					$result = mysqli_query($conn, $sql);
					$resultCheck = mysqli_num_rows($result);
					
					if ($resultCheck > 0) {
						while ($row = mysqli_fetch_assoc($result)) {
							
							echo '<a href="movies/?id='.$row["title"].'">
								<div style="background-image: url(img/movieposters/'.$row["image_id"].');"></div>
								<h3>'.$row["title"].'</h3>
								<p>'.$row["release_date"].'</p>
							</a>';
							
						}
					}
					
				}
			
			?>
		</div>
	</div>
</section>

<?php
	require "footer.php";
?>

</body>
</html>