<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Movie Database - Browse Actors</title>
  
  <!-- basic styling -->
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link rel="stylesheet" href="css/foundation.css">
  <link rel="stylesheet" href="css/app.css">
</head>

<body>
	<div class="row" id="fullpage">
		<!-- Left menu div -->
		<div class="small-5 medium-4 large-3 columns" id="menu">
			<h1 id="menu-main-title">CS143 Movie Database System</h1>
			<div class="spacer"></div>

			<a href="search.php"><h3>Search Database</h3></a>
			<a href="browse-actors.php"><h3 class="active-section">Browse Actors</h3></a>
			<a href="browse-movies.php"><h3>Browse Movies</h3></a>
			<div class="spacer"></div>

			<a href="add-actor.php"><h3>Add Actor or Director</h3></a>
			<a href="add-movie.php"><h3>Add Movie</h3></a>
			<a href="add-comments.php"><h3>Add Comments</h3></a>
			<a href="add-actor-to-movie.php"><h3>Add Actor to Movie</h3></a>
			<a href="add-director-to-movie.php"><h3>Add Director to Movie</h3></a>
		</div>

		<!-- Main Content Div -->
		<div class="small-7 medium-8 large-9 columns" id="main">
			<h2>Browse Actors</h2>
			
			<!-- TODO -->
            <?php
                $debug = True;

                if ($debug) {
                    ini_set('display_startup_errors', 1);
                    ini_set('display_errors', 1);
                    error_reporting(-1);
                }

                
                $id = $_GET["id"];
                $fields = array("id", "first", "last", "sex", "dob", "dod");

                if (!empty($id) && is_numeric($id)) {
                    $query = "SELECT id, first, last, sex, dob, dod FROM Actor WHERE id = " . $id;

                    $mysqli = new mysqli('localhost', 'cs143', '', 'CS143');
                    if ($mysqli->connect_errno > 0) {
                        die('Unable to connect to database [' . $mysqli->connect_error . ']');
                    }
                    if (!$res = $mysqli->query($query)) {
                        die('Unable to finish query');
                    }
                    if ($res->num_rows === 0) {
                        echo "Error, invalid actor id provided";
                    }
                    else {
                        echo "<table>";
                        while ($row = $res->fetch_assoc()) {
                            echo "<tr>";
                            foreach ($fields as $field) {
                                echo "<td>" . $row[$field] . "</td>";
                            }
                            echo "</tr>";
                        }
                        echo "</table>";
                    }
                    

                } else {
                    echo "Invalid actor id provided.";
                }


            ?>
		</div>
	</div>

	<!-- scripts, incl foundation -->
	<script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/what-input.js"></script>
    <script src="js/vendor/foundation.js"></script>
    <script src="js/app.js"></script>
</body>
</html>