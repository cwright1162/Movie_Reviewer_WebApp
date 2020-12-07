<?php

	if (isset($_POST['submit'])) {
		
		$title = $_POST['movietitle'];
		$release_date = $_POST['release_date'];
		$desc = $_POST['description'];
		$directors = $_POST['director'];
		$genres = $_POST['genre'];
	
		$file = $_FILES['imgfile'];
		$fileName = $file["name"];
		$fileType = $file["type"];
		$fileTempName = $file["tmp_name"];
		$fileError = $file["error"];
		$fileSize = $file["size"];
		
		$fileExt = explode(".", $fileName);
		$fileActExt = strtolower(end($fileExt));
		
		$fileDest = null;
		
		$allowedExt = array("jpg", "jpeg", "png");
		
		if (in_array($fileActExt, $allowedExt)) {
			
			if ($fileSize != 0) {
				
				$imgFullName = $fileName . uniqid("", true) . "." . $fileActExt;
				$fileDest = "../img/movieposters/" . $imgFullName;
				
				require "dbh.inc.php";
				$conn = openConn();
				
				if (empty($title) || empty($release_date) || empty($desc) || empty($directors) || empty($genres) || empty($file)) {
					
					echo "Please enter info into all fields before submitting!";
					exit();
					
				}
				else {
					
					$movie_id = null;
					$genres_ids = [];
					$directors_ids = [];
					
					$sql = "INSERT INTO movies (`title`, `release_date`, `desc`, `image_id`) VALUES ('".$title."', '".$release_date."', '".$desc."', '".$fileName."');";
					
					if (!existingMovie($conn, $title)) {
						
						if (mysqli_query($conn, $sql)) {
							echo "New record created successfully";
							$movie_id = mysqli_insert_id($conn);
						} else {
							echo "Error: " . $sql . "<br>" . mysqli_error($conn);
							exit();
						}
						
					}
					
					foreach ($_POST['director'] as $value) {
						$fullname = explode(" ", $value);
						$first_name = $fullname[0];
						$last_name = end($fullname);
						
						$sql = "INSERT INTO directors (first_name, last_name) VALUES ('".$first_name."', '".$last_name."');";
					
						if (!existingDirector($conn, $first_name, $last_name)) {
							
							if ($conn->query($sql) === TRUE) {
								echo "director added successfully";
								$temp = mysqli_insert_id($conn);
								array_push($directors_ids, $temp);
							}
							else {
								echo "Error inserting director into DB";
								
							}
							
						}
					
					}
					
					foreach ($_POST['genre'] as $value) {
						
						$sql = "INSERT INTO genres (`genre`) VALUES ('".$value."');";
						
						if (!existingGenre($conn, $value)) {
						
							if ($conn->query($sql) === TRUE) {
								echo "genre added successfully";
								$temp = mysqli_insert_id($conn);
								array_push($genres_ids, $temp);
							}
							else {
								echo "Error inserting genre into DB";
								
							}
							
						}
						
					}
					
					// Add records to relationship tables
					foreach ($directors_ids as &$director_id) {
						
						$sql = "INSERT INTO directors_movies (`directors_id`, `movies_id`) VALUES ('".$director_id."', '".$movie_id."');";
						
						if ($conn->query($sql) === TRUE) {

						}
						else {
							echo "Error inserting relationship into DB";
							
						}
						
					}
					
					foreach ($genres_ids as &$genre_id) {
						
						$sql = "INSERT INTO genres_movies (`genres_id`, `movies_id`) VALUES ('".$genre_id."', '".$movie_id."');";
						
						if ($conn->query($sql) === TRUE) {

						}
						else {
							echo "Error inserting relationship into DB";
							
						}
						
					}
					
					move_uploaded_file($fileName, $fileDest);
					header("Location: ../index.php");
					
				}
				
			}
			else {
				echo "File size error!";
				exit();
			}
			
		}
		else {
			echo "The image file you uploaded is an incorrect file type";
		}
	
	}
	else {
		header("Location: ../login.php");
		exit();
	}
	
	function existingMovie ($conn, $title) {
		
		$sql = "SELECT title FROM movies
				WHERE title='".$title."';";
				
		if ($conn->query($sql) === TRUE) {
			return true;
		}
		else {
			return false;
		}
		
	}
	
	function existingGenre ($conn, $genre) {
		
		$sql = "SELECT title FROM genres
				WHERE title='".$genre."';";
				
		if ($conn->query($sql) === TRUE) {
			return true;
		}
		else {
			return false;
		}
		
	}
	
	function existingDirector ($conn, $first, $last) {
		
		$sql = "SELECT * FROM directors
				WHERE first_name='".$first."'
				AND last_name='".$last."';";
				
		if ($conn->query($sql) === TRUE) {
			return true;
		}
		else {
			return false;
		}
		
	}

?>