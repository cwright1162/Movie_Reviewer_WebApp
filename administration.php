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

<script>
	function addDirector() {
		var input = document.createElement("INPUT");
		input.setAttribute("type", "text");
		input.setAttribute("name", "director[]");
		document.getElementById("frm-directors").appendChild(input);
	}
	
	function addGenre() {
		var input = document.createElement("INPUT");
		input.setAttribute("type", "text");
		input.setAttribute("name", "genre[]");
		document.getElementById("frm-genres").appendChild(input);
	}
</script>

</head>
<body>

<div class="wrapper-admin">

	<div>
		<div>
			<h3 class="centered">Admin Interface</h3>
		</div>
		
		<hr>
		
		<div class="wrapper-addmovie">
			<h4 class="centered">Add movie to Database<h4>
		</div>
		
		<form id="frm-movie" action="includes/upload-movie.inc.php" method="post" enctype="multipart/form-data">
				
			<input type="text" name="movietitle" placeholder="Movie Title..." style="width:600px;"><br>
			<label for="rel-date">Release date:</label>
			<input type="date" id="rel-date" name="release_date" placeholder="Release date..."><br>
			<textarea name="description" style="width: 600px; height:630px;" placeholder="Movie Description"></textarea><br>
			<label for="img">Poster image:</label><br>
			<input type="file" id="img" name="imgfile"><br>
			
			<div id="frm-directors">
				<button type="button" onclick="addDirector()">Add director</button>
				<input type="text" name="director[]" placeholder="Director...">
			</div>
			
			<div id="frm-genres">
				<button type="button" onclick="addGenre()">Add genre</button>
				<input type="text" name="genre[]" placeholder="Genre...">
			</div>
			
			<button type="submit" name="submit">UPLOAD</button>
			
		</form>

	</div>

</div>

<?php
	require "footer.php";
?>
</body>
</html>