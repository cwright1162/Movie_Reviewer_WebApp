# Movie_Reviewer_WebApp
 A PHP webapp to simulate a movie reviewer

# Usage
Requires the creation of a file "dbh.inc.php" to work.
Place the file into the includes folder. Specify your database information.
Create your own local database using the exported file provided.

'''
<?php
	function openConn() {
		$servername = "";
		$username = "";
		$password = "";
		$dbname = "";

		$conn = new mysqli($servername, $username, $password, $dbname) or die("Connection Failed: %s\n". mysqli_connect_error());

		return $conn;
	}

	function closeConn($conn) {
		mysqli_close($conn);
	}
?>
'''