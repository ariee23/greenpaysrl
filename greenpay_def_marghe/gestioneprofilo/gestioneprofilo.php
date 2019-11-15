

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
			<a class="nav-link active" href="gestioneprofilo.php"><i class="fas fa-user"></i></a>
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
			if(@$_GET['datimodificati']==true){
			?>
			<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			Dati modificati correttamente.</div>
		<?php
			}
		?>

		<?php
			if(@$_GET['aggemail']==true){
			?>
			<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			Indirizzo email aggiunto.</div>
		<?php
			}
		?>

			<?php
			if(@$_GET['aggind']==true){
			?>
			<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			Indirizzo aggiunto.</div>
		<?php
			}
		?>

			<?php
			if(@$_GET['aggtel']==true){
			?>
			<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			Numero di telefono aggiunto.</div>
		<?php
			}
		?>

			<?php
			if(@$_GET['rimuovitel']==true){
			?>
			<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			Numero di telefono rimosso.</div>
		<?php
			}
		?>

			<?php
			if(@$_GET['rimuovimail']==true){
			?>
			<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			Indirizzo email rimosso.</div>
		<?php
			}
		?>

			<?php
			if(@$_GET['rimuoviind']==true){
			?>
			<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			Indirizzo rimosso.</div>
		<?php
			}
		?>

			<?php
			if(@$_GET['modmail']==true){
			?>
			<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			Indirizzo email modificato correttamente.</div>
		<?php
			}
		?>


			<?php
			if(@$_GET['modtel']==true){
			?>
			<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			Numero di telefono modificato correttamente.</div>
		<?php
			}
		?>

		<?php
			if(@$_GET['modind']==true){
			?>
			<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			Indirizzo modificato correttamente.</div>
		<?php
			}
		?>

	<?php
			if(@$_GET['error']==true){
			?>
			<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			Si è verificato un errore. Riprova.</div>
		<?php
			}
		?>


<!-- contenuto -->
<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-lg-5 my-col2">
		<div class="row">
		<div class="col-lg-12 my-col align-self-start">
		<h4>Profilo</h4>
			<!-- php per mostrare i dati e l'immagine del profilo -->
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

				$sql = "SELECT * FROM utente WHERE cf = '".$_SESSION['cf']."'";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					$row=$result->fetch_assoc();
					if($row['propic']== ""){
						echo "<img class='propic' src='../img/propic.png'>";
					} else {
						echo "<img class='propic' src='../img/".$row['propic']."'>";
					}

					echo "<p class='p1'><b>" .$row["nome"]. " " . $row["cognome"] . "</b></p><hr>
					<p><i class='fas fa-address-card icone'></i>" . $_SESSION["cf"]. "<br>
						<i class='fas fa-birthday-cake icone'></i>" . $row["data_nascita"] . "<br>
						<i class='fas fa-home icone'></i>" .$row['citta']. ", " . $row["stato"] . "<a href='modificadati.php' class='btn btn-success' style='float:right'>Modifica</a></p>";
					
				}

				
			$conn->close();
			?>
	  </div>
	  <div class="col-lg-12 align-self-start my-col1">
			<h4>Opzioni Conto</h4>
			<hr>
			<p>Lingua
				<select class="form-control">
				  <option value="italiano">Italiano</option>
				  <option value="english">English</option>
				</select>
			</p>
			<p>Fuso Orario
				<select class="form-control">
				  <option value="gmt+01">GMT+01:00</option>
				  <option value="gmt-08">GMT-08:00</option>
				</select>
			</p>
			<p>Paese
				<select class="form-control">
				  <option value="italia">Italia</option>
				  <option value="USA">USA</option>
				</select>
			</p>
			<br>
			<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Chiudi conto</button>
			<!-- Modal -->
			  <div class="modal fade" id="myModal" role="dialog">
				<div class="modal-dialog modal-dialog-centered">

				  <!-- Modal content-->
				  <div class="modal-content">
					<div class="modal-header bg-success">
					<img class="modalpic" src="../img/logo.png"></a>
					  <button type="button" class="close" data-dismiss="modal">&times;</button>

					</div>
					<div class="modal-body">
					  <p style="text-align: center">Conferma di voler chiudere il conto?<br>Tutti i dati salvati verranno cancellati.</p>
					</div>
					<div class="modal-footer">
					  <a href="main.php?chiudi=true" class="btn btn-success">Chiudi conto</a>
					</div>
				  </div>

				</div>
			  </div>




	  </div>
	  </div>
	  </div>
	  <div class="col-lg-5 my-col2">
		<div class="row">
		<div class="col-lg-12 align-self-start my-col">
			<h4>Indirizzi</h4>
			<a href="aggind.php" class="btn btn-success plus-btn"><i class="fas fa-plus"></i></a>
			<hr>
			<!-- php per popolare la tabella indirizzi -->
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

				$sql = "SELECT * FROM indirizzi WHERE ref_utente = '".$_SESSION['cf']."'";
				$result = $conn->query($sql);

				if ($result->num_rows > 1) {
					echo "<div class='table-responsive'><table class='tab'>";
					// output data of each row
					while($row = $result->fetch_assoc()) {
						if($row['principale']=='Principale'){

							echo "<tr><td>"  . $row["indirizzo"]. "<br>" . $row["citta"] . ", " . $row["stato"] . "<br>" . $row["cap"] ."</td><td class='tab1'><small>" .$row['principale']. "</small><br><a href=\"modind.php?indirizzo2=".$row['indirizzo']."&citta=".$row['citta']."&stato=".$row['stato']."&cap=".$row['cap']."\">Modifica </a></td></tr>";
						} else {
						echo "<tr><td>"  . $row["indirizzo"] . "<br>" . $row["citta"] . ", " . $row["stato"] . "<br>" . $row["cap"] . "</td><td class='tab1'><small>" .$row['principale']. "</small><br><a href=\"modind.php?indirizzo2=".$row['indirizzo']."&citta=".$row['citta']."&stato=".$row['stato']."&cap=".$row['cap']."\">Modifica </a> | <a href=\"main.php?indirizzo=".$row['indirizzo']."\"> Rimuovi</a></td></tr>";
					}
				}
					echo "</table></div>";
				} else if($result->num_rows == 1) {
						echo "<div class='table-responsive'><table class='tab'>";
					// output data of each row
					while($row = $result->fetch_assoc()) {
						echo "<tr><td>"  . $row["indirizzo"]. "<br>" . $row["citta"] . ", " . $row["stato"] . "<br>" . $row["cap"] ."</td><td class='tab1'><small>" .$row['principale']. "</small><br><a href=\"modind.php?indirizzo2=".$row['indirizzo']."&citta=".$row['citta']."&stato=".$row['stato']."&cap=".$row['cap']."\">Modifica </a></td></tr>";
					}
					echo "</table></div>";

				}

				$conn->close();
			?>

		</div>
		  <div class="col-lg-12 align-self-start my-col1">
			<h4>Indirizzi Email</h4>
			<a href="aggemail.php" class="btn btn-success plus-btn"><i class="fas fa-plus"></i></a>
			<hr>
			<!-- php per popolare la tabella indirizzi email -->
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

				$sql = "SELECT * FROM email WHERE ref_utente = '".$_SESSION['cf']."'";
				$result = $conn->query($sql);

				if ($result->num_rows > 1) {
					echo "<div class='table-responsive'><table class='tab'>";
					// output data of each row
					while($row = $result->fetch_assoc()) {
						if($row['principale']=='Principale'){
							echo "<tr><td>"  . $row["email"]. "</td><td class='tab1'><small>" .$row['principale']. "</small><br><a href=\"modmail.php?email2=".$row['email']."\">Modifica </a></td></tr>";
					} else{
						echo "<tr><td>"  . $row["email"]. "</td><td class='tab1'><small>" .$row['principale']. "</small><br><a href=\"modmail.php?email2=".$row['email']."\">Modifica </a> | <a href=\"main.php?email=".$row['email']."\">Rimuovi</a></td></tr>";
					}
				}
					echo "</table></div>";
				} else if($result->num_rows == 1) {
						echo "<div class='table-responsive'><table class='tab'>";
					// output data of each row
					while($row = $result->fetch_assoc()) {
						echo "<tr><td>"  . $row["email"]. "</td><td class='tab1'><small>" .$row['principale']. "</small><br><a href=\"modmail.php?email2=".$row['email']."\">Modifica </a></td></tr>";
					}
					echo "</table></div>";

				}
				$conn->close();
			?>

	  </div>
		<div class="col-lg-12 align-self-start my-col1">
			<h4>Telefono</h4>
			<a href="aggtel.php" class="btn btn-success plus-btn"><i class="fas fa-plus"></i></a>
			<hr>
			<!-- php per popolare la tabella telefono -->
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

				$sql = "SELECT * FROM telefono WHERE ref_utente = '".$_SESSION['cf']."'";
				$result = $conn->query($sql);

				if ($result->num_rows > 1) {
					echo "<div class='table-responsive'><table class='tab'>";
					// output data of each row
					while($row = $result->fetch_assoc()) {
							if($row['principale']=='Principale'){
									echo "<tr><td>"  . $row["numero"]. "</td><td class='tab1'><small>" .$row['principale']. "</small><br><a href=\"modtel.php?numero2=".$row['numero']."\">Modifica </a></td></tr>";
							}else{
						echo "<tr><td>"  . $row["numero"]. "</td><td class='tab1'><small>" .$row['principale']. "</small><br><a href=\"modtel.php?numero2=".$row['numero']."\">Modifica </a> | <a href=\"main.php?numero=".$row['numero']."\"> Rimuovi</a></td></tr>";
					}
				}
					echo "</table></div>";
				} else if ($result->num_rows == 1) {
					echo "<div class='table-responsive'><table class='tab'>";
					// output data of each row
					while($row = $result->fetch_assoc()) {
						echo "<tr><td>"  . $row["numero"]. "</td><td class='tab1'><small>" .$row['principale']. "</small><br><a href=\"modtel.php?numero2=".$row['numero']."\">Modifica </a></td></tr>";
					}
				}
					echo "</table></div>";

				$conn->close();
			?>
	  </div>
		</div>
      </div>
    </div>
	</div>





<!-- footer -->
<footer>
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
