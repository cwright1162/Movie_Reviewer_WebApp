<?php
	require "header.php";
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<title>Home | Movie Reviews</title>

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

<!-- Slideshow carousel -->
<div class="container" id="contSlides">

	<div class="carousel slide" data-ride="carousel" id="slideshow">
	
		<!-- Indicators -->
		<ul class="carousel-indicators">
			<li data-target="#slideshow" data-slide-to="0" class="active"></li>
			<li data-target="#slideshow" data-slide-to="1"></li>
			<li data-target="#slideshow" data-slide-to="2"></li>
			<li data-target="#slideshow" data-slide-to="3"></li>
			<li data-target="#slideshow" data-slide-to="4"></li>
			<li data-target="#slideshow" data-slide-to="5"></li>
		</ul>
		  
		<!-- The slideshow -->
		<div class="carousel-inner">
			<div class="carousel-item active">
				<img src="img/homeslide/hollywood.jpg" alt="Hollywood" width="1100" height="500">
			</div>
			<div class="carousel-item">
				<img src="img/homeslide/projector.jpg" alt="Projector" width="1100" height="500">
			</div>
			<div class="carousel-item">
				<img src="img/homeslide/filmroll.jpg" alt="Film" width="1100" height="500">
			</div>
			<div class="carousel-item">
				<img src="img/homeslide/comics.jpg" alt="Comics" width="1100" height="500">
			</div>
			<div class="carousel-item">
				<img src="img/homeslide/theater.jpg" alt="Theater" width="1100" height="500">
			</div>
			<div class="carousel-item">
				<img src="img/homeslide/cinema.jpg" alt="Cinema" width="1100" height="500">
			</div>
		</div>
		  
		<!-- Left and right controls -->
		<a class="carousel-control-prev" href="#slideshow" data-slide="prev">
			<span class="carousel-control-prev-icon"></span>
		</a>
		<a class="carousel-control-next" href="#slideshow" data-slide="next">
			<span class="carousel-control-next-icon"></span>
		</a>
	</div>
</div>

<!-- Movie display -->

<section class="movie-links">
	<h2>Movies</h2>
	<div class="wrapper">
		
		<div class="movie-container">
			<?php
				$sql = "SELECT * FROM movies;";
				$result = mysqli_query($conn, $sql);
				$resultCheck = mysqli_num_rows($result);
				
				if ($resultCheck > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
						
						echo '<a href="movies/?id='.$row["title"].'">
							<div style="background-image: url(/img/movieposters/'.$row["image_id"].');"></div>
							<h3>'.$row["title"].'</h3>
							<p>'.$row["release_date"].'</p>
						</a>';
						
					}
				}
				else {
					echo 'No movies here at the moment! Check back soon!';
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