<?php
	session_start();
	
	require(__DIR__."/includes/dbh.inc.php");
	
	$conn = openConn();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

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

<!-- Navbar -->
<nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top">
	<a class="navbar-brand" href="/index.php">
		<i class="fas fa-home"></i>
	</a>
	
	<!-- Links -->
	<ul class="navbar-nav">
		
		<!-- All Movies -->
		<li class="nav-item">
			<a class="nav-link" href="/search.php">All Movies</a>
		</li>
		
		<!-- Genres Dropdown -->
		<li class="nav-item dropdown">
		
			<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Genres</a>
			
			<div class="dropdown-menu">
			
				<?php
					
					$sql = 'SELECT * FROM genres;';
					$result = mysqli_query($conn, $sql);
					$resultCheck = mysqli_num_rows($result);
					
					if ($resultCheck > 0) {
						
						while ($row = mysqli_fetch_assoc($result)) {
							
							echo '<a class="dropdown-item" href="/search.php?genre='.$row['genre'].'">'.$row['genre'].'</a>';
							
						}
						
					}
				
				?>
			
			</div>
			
		</li>
		
	</ul>
	
	<!-- Search Bar -->
	<div class="container-fluid justify-content-end">
		<form class="form-inline" method="GET" action="/search.php">
			<input class="form-control mr-sm-2" type="text" name="search" placeholder="Search" value="<?php if (isset($_GET['search'])) { echo $_GET['search']; }?>">
			<button class="btn btn-warning" type="submit">Search</button>
		</form>
	</div>
	
	<!-- Account Links -->
	<ul class="navbar-nav">
	
		<?php
			// If user is NOT logged in...
			// Show sign in button and hide account dropdown
			// sign-in button
			// If user is logged in...
			// Do the opposite
			
			if (isset($_SESSION['username'])) {
				
				// Account Dropdown
				echo '<li class="nav-item dropleft">
				
					<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Account</a>
					
					<div class="dropdown-menu">
					
						<p> Hello, '.$_SESSION["username"].'!</p>';

				if ($_SESSION['op'] == 4) {
					
					echo '<a class="dropdown-item" href="administration.php">Admin Interface</a>';
					
				}
					
						echo '<form action="includes/logout.inc.php" method="post">
							<button class="dropdown-item" type="submit" name="logout-submit">Sign out</a>
						</form>
					
					</div>
					
				</li>';
				
			}
			else {
				
				echo '<li class="nav-item">
					<a class="nav-link" href="login.php">Login</a>
				</li>';
				
			}
			
		?>
		
	</ul>
	
</nav>
</body>
</html>