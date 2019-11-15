<!-- Sim -->
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>GreenPay: Richieste</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="../style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script src="https://kit.fontawesome.com/3d31361b31.js"></script>
	<script src="../valida.js"></script>
</head>
<body>

<!-- navigation -->
<nav class="navbar navbar-expand-md navbar-dark bg-success sticky-top">
	<div class="container-fluid">
	<a class="navbar-brand" href="../gestioneprofilo/riepilogo.php"><img src="../img/logo.png"></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarResponsive">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item">
			<a class="nav-link" href="../gestioneprofilo/riepilogo.php">Riepilogo</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="../gestionemovimenti/cronologia.php">Cronologia</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="scegliutente.php">Invia e Richiedi</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="../gestioneprofilo/portafoglio.php">Portafoglio</a>
			</li>
		</ul>
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
			<a class="nav-link" href="../gestioneprofilo/gestioneprofilo.php"><i class="fas fa-user"></i></a>
			</li>
						<li class="nav-item">
			<?php

				$servername = "localhost";
				$username = "bee3b716298b4a";
				$password = "bad87d03";
				$dbname = "heroku_16f3a281c2f1459";

				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}

				$sql = "SELECT * FROM richieste WHERE destinatario = '".$_SESSION['cf']."' AND risposta=1";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					$num=$result->num_rows;

					echo "<span class='badge badge-pill badge-danger notifica'>".$num."</span>";
				}

				$conn->close();

			?>
			<a href="richieste.php" class="nav-link notification active">
			<span><i class="far fa-bell"></i></span>
			</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="../autenticazione/main.php?esci=true">Esci</a>
			</li>
		</ul>
	</div>
	</div>
</nav>



<?php
			if(@$_GET['error']==true){
			?>
			<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			Si è verificato un errore. Riprova.</div>
		<?php
			}
		?>

<?php
			if(@$_GET['success1']==true){
			?>
			<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			Richiesta rifiutata.</div>
		<?php
			}
		?>

<?php
			if(@$_GET['success2']==true){
			?>
			<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			Richiesta accettata.</div>
		<?php
			}
		?>

<!-- form -->
<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-lg-8 my-col3">
			<h4>Richieste Ricevute</h4>
			<hr>
			<?php
				$servername = "localhost";
				$username = "bee3b716298b4a";
				$password = "bad87d03";
				$dbname = "heroku_16f3a281c2f1459";
				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}

				$sql = "SELECT * FROM richieste WHERE destinatario = '".$_SESSION['cf']."'";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					echo "<div class='table-responsive'><table class='tab2'>";
					// output data of each row
					while($row = $result->fetch_assoc()) {

						$mitt = $row["mittente"];
						$sql2 = "SELECT * FROM utente WHERE cf = '".$mitt."'";
						$result2 = $conn->query($sql2);
						$row2 = $result2->fetch_assoc();
						$mitt=$row2["nome"]. " " .$row2["cognome"];




						echo "<tr><td>"  . $row["data"] . "</td><td>" . $mitt . "</td><td> " . $row["cifra"] . " EUR</td><td>" . $row["note"] . "</td>";
						if($row["risposta"]==1){
							echo "<td><a href=\"confermarichiesta.php?cod=".$row['cod_richiesta']."\" class='btn btn-success btn-sm'>Accetta</a> <a href=\"main.php?cod=".$row['cod_richiesta']."\" class='btn btn-success btn-sm'>Rifiuta<a></td></tr>";
						} else if($row["risposta"]==2){
							echo "<td><small>Richiesta accettata</small></td></tr>";
						} else if($row["risposta"]==3){
							echo "<td><small>Richiesta rifiutata</small></td></tr>";
						}
					}
					echo "</table></div>";
				} else {
					echo "<div class='table-responsive'><table  class='tab2'><tr><td>Non ci sono richieste</td></tr></table></div>";
				}

				$conn->close();
			?>
			<br>
			<h4>Richieste Effettuate</h4>
			<hr>
				<?php
				$servername = "localhost";
				$username = "bee3b716298b4a";
				$password = "bad87d03";
				$dbname = "heroku_16f3a281c2f1459";
				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}

				$sql = "SELECT * FROM richieste WHERE mittente = '".$_SESSION['cf']."'";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					echo "<div class='table-responsive'><table class='tab2'>";
					// output data of each row
					while($row = $result->fetch_assoc()) {

						$dest = $row["destinatario"];
						$sql2 = "SELECT * FROM utente WHERE cf = '".$dest."'";
						$result2 = $conn->query($sql2);
						$row2 = $result2->fetch_assoc();
						$dest=$row2["nome"]. " " .$row2["cognome"];

						echo "<tr><td>"  . $row["data"] . "</td><td>" . $dest. "</td><td> " . $row["cifra"] . " EUR</td><td>" . $row["note"] . "</td>";

						if($row["risposta"]==1){
							echo "<td><small>Da Confermare</small></td></tr>";
						} else if($row["risposta"]==2){
							echo "<td><small>Richiesta accettata</small></td></tr>";
						} else if($row["risposta"]==3){
							echo "<td><small>Richiesta rifiutata</small></td></tr>";
						}


					}
					echo "</table></div>";
				} else {
					echo "<div class='table-responsive'><table  class='tab2'><tr><td>Non ci sono richieste</td></tr></table></div>";
				}

				$conn->close();
			?>


		</div>
		</div>
	</div>
</div>

<!-- footer -->
<footer class="footer">
	<hr>
	<div class="row">
		<div class="col-lg-4">
			<h5> © 2019 GreenPay</h5>
		</div>
		<div class="col-lg-4">
		<small>
			Aiuto e Contatti<br>
			Tariffe<br>
			Sicurezza<br>
			App<br>
		</small>
		</div>
		<div class="col-lg-4">
		<small>
			Chi siamo<br>
			Blog<br>
			Lavora con noi<br>
			Sviluppatori<br>
			Partner
		</small>
		</div>
	</div>
</footer>

</body>
</html>
