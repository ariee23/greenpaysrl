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
	<script type="text/javascript">
		//la funzione today serve per bloccare le date non valide nei calendari
		function today(){
			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1;
			var yyyy = today.getFullYear()-16; //bisogna avere almeno 16 anni per registrarsi

			if(dd<10) {
				dd = '0'+dd
			}

			if(mm<10) {
				mm = '0'+mm
			}

			today = yyyy + '-' + mm + '-' + dd;
			document.getElementById("nascita").setAttribute("max", today);
		}

		window.onload = function() {
			today();
		};

	</script>
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
			Si è verificato un errore. Riprova.</div>
		<?php
			}
		?>



<!-- contenuto -->
<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-lg-6 my-col3 align-self-start">
		<h4>Modifica dati</h4>
		<hr>
		 <?php
			if(isset($_POST['submit'])){
				move_uploaded_file($_FILES['file']['tmp_name'], "../img/".$_FILES['file']['name']);
				$con = mysqli_connect("eu-cdbr-west-02.cleardb.net","bee3b716298b4a","bad87d03","heroku_16f3a281c2f1459");
				mysqli_query($con, "UPDATE utente SET propic = '".$_FILES['file']['name']."' WHERE cf = '".$_SESSION['cf']."'");

			}
			

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

				$sql = "SELECT * FROM utente WHERE cf = '".$_SESSION['cf']."'";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
				$row=$result->fetch_assoc();
				
						if($row['propic']== ""){
							echo "<img class='propic2' src='../img/propic.png'>";
						} else {
							echo "<img class='propic2' src='../img/".$row['propic']."'>";
						}
				}

				$conn->close();
		
		?>
		<br><br>
		<form action ="" method="post" enctype="multipart/form-data">
			<div class="form-group form-inline">
			<input  type="file" name="file">
		<button type="submit"  class="btn btn btn-success" name="submit">Modifica foto personale</button>
			</div>
		</form>
		<form action="main.php" method = "post" onsubmit="return validaModDati()">
			  <div class="form-group">
				<label for="nome">Nome:</label>
				<input type='text' class='form-control' value="<?php echo $_SESSION['nome']?>" name='nome' id='nome'>
				<small id="errore1" class="errore"></small>
			  </div>
			  <div class="form-group">
				<label for="cognome">Cognome:</label>
				<input type='text' class='form-control' value="<?php echo $_SESSION['cognome']?>" name='cognome' id='cognome'>
				<small id="errore2" class="errore"></small>
			  </div>
			   <div class="form-group">
				<label for="nascita">Data di nascita:</label>
				<input type="date" class="form-control" name="nascita" value="<?php echo $_SESSION['dataNascita']?>" id="nascita">
				<small id="errore3" class="errore"></small>
			  </div>
			   <div class="form-group">
				<label for="citta">Città:</label>
				<input type="text" class="form-control" value="<?php echo $_SESSION['citta']?>" name="citta"  id="citta">
				<small id="errore4" class="errore"></small>
				</div>
				<div class="form-group">
				<label for="stato">Stato:</label>
				<input type="text" class="form-control" value="<?php echo $_SESSION['stato']?>" name="stato" id="stato">
				<small id="errore5" class="errore"></small>
			  </div>
			  <button type="submit" name="submit4" class="btn btn-success">Salva</button>
			  </form>
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
