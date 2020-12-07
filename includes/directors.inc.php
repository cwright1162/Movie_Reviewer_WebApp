<?php
	function getDirectors($conn, $movietitle) {
		
		$sql = "SELECT directors.first_name, directors.last_name, movies.title 
				FROM directors 
				JOIN directors_movies ON directors.id=directors_movies.directors_id
				JOIN movies ON movies.id=directors_movies.movies_id
				WHERE movies.title='".$movietitle."';";
				
		$result = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($result);
		
		if ($resultCheck > 0) {
			
			return $result;
			
		}
		
		mysqli_close($conn);
		
	}
?>