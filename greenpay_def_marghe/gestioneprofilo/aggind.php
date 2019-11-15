<!-- Sim -->
<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>GreenPay: Profilo</title>
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
	<a class="navbar-brand" href="riepilogo.php"><img src="../img/logo.png"></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarResponsive">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item">
			<a class="nav-link" href="riepilogo.php">Riepilogo</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="../gestionemovimenti/cronologia.php">Cronologia</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="../gestionepagamenti/scegliutente.php">Invia e Richiedi</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="portafoglio.php">Portafoglio</a>
			</li>
		</ul>
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
			<a class="nav-link active" href="gestioneprofilo.html"><i class="fas fa-user"></i></a>
			</li>
						<li class="nav-item">
			<?php
			//VARIABILI DI CONNESSIONE
			   $servername = "localhost";	// nome di host
			   $username = "bee3b716298b4a";// username dell'utente in connessione
			   $password = "bad87d03";// password dell'utente
			   $dbname="heroku_16f3a281c2f1459";//nome database


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
			<a href="../gestionepagamenti/richieste.php" class="nav-link notification">
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

<!-- navigation 2 -->
<ul class="nav nav-tabs nav-2 nav-justified">
  <li class="nav-item">
    <a class="nav-link active" href="gestioneprofilo.php">Conto</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="sicurezza.php">Sicurezza</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="notifiche.php">Notifiche</a>
  </li>
</ul>


	<?php
			if(@$_GET['error']==true){
			?>
			<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			Indirizzo già presente.</div>
		<?php
			}
		?>






<!-- contenuto -->
<div class="container">
	<div class="row justify-content-center">
		<div class="col-lg-6 my-col3">
			<h4>Aggiungi indirizzo</h4>
			<hr>
			<form  method="post" action="main.php" onsubmit="return validaAggInd()">
			  <div class="form-group">
				<label for="ind">Indirizzo:</label>
				<input type="text" class="form-control" name="ind" id="ind">
				<small id="errore1" class="errore"></small>
				</div>
				<div class="form-group">
				<label for="stato">Città:</label>
				<input type="text" class="form-control" name="citta" id="citta">
				<small id="errore2" class="errore"></small>
			  </div>
				<div class="form-group">
				<label for="stato">Stato:</label>
				<input type="text" class="form-control" name="stato" id="stato">
				<small id="errore3" class="errore"></small>
			  </div>
			  <div class="form-group">
				<label for="cap">CAP:</label>
				<input type="text" class="form-control" name="cap" id="cap">
				<small id="errore4" class="errore"></small>
				</div>
			  <button type="submit" name="submit1" class="btn btn-success">Avanti</button>
			</form>
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
