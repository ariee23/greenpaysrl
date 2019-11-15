<!-- Sim -->
<?php
	session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>GreenPay</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="../style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script src="https://kit.fontawesome.com/3d31361b31.js"></script>
	<script src="../valida.js"></script>
	<script>
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
		<a class="navbar-brand" href="../index.html"><img src="../img/logo.png"></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarResponsive">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
				<a class="nav-link" href="LoginBoundary.php">Accedi</a>
				</li>
				<li class="nav-item">
				<a class="nav-link" href="#">Registrati</a>
				</li>
			</ul>
		</div>
		</div>
	</nav>

<?php
			if(@$_GET['errore']==true){
			?>
			<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			Si è verificato un errore. Riprova.</div>
		<?php
			}
		?>


<!-- form -->
<div class="container-fluid padding">
	<div class="row justify-content-center">
		<div class="col-lg-6 my-col5">
			<h4>Registrati su GreenPay</h4>
			<hr>
			<form action="main.php" method="post" onsubmit="return validaReg()" >
			  <div class="form-group">
				<label for="cf">Codice fiscale:</label>
				<input type="text" class="form-control" name="cf" id="cf">
				<small id="errore1" class="errore"></small>
			  </div>
			  <div class="form-group">
				<label for="nome">Nome:</label>
				<input type="text" class="form-control" name="nome" id="nome">
				<small id="errore2" class="errore"></small>
			  </div>
			  <div class="form-group">
				<label for="cognome">Cognome:</label>
				<input type="text" class="form-control" name="cognome" id="cognome">
				<small id="errore3" class="errore"></small>
			  </div>
			  <div class="form-group">
				<label for="email">Email:</label>
				<input type="text" class="form-control" name="email" id="email">
				<small id="errore4"  class="errore"></small>
			  </div>
			   <div class="form-group">
				<label for="password">Password:</label>
				<input type="password" class="form-control" name="password" id="password">
				<small id="errore5"  class="errore"></small>
			  </div>
			  <div class="form-group">
				<label for="nascita">Data di Nascita:</label>
				<input type="date" class="form-control" name="nascita" id="nascita">
				<small id="errore6"  class="errore"></small>
			  </div>
			  <div class="form-group">
				<label for="indirizzo">Indirizzo:</label>
				<input type="text" class="form-control" name="indirizzo" id="indirizzo">
				<small id="errore7"  class="errore"></small>
			  </div>
			  <div class="form-group">
				<label for="citta">Città:</label>
				<input type="text" class="form-control" name="citta" id="citta">
				<small id="errore8"  class="errore"></small>
			  </div>
			  <div class="form-group">
				<label for="stato">Stato:</label>
				<input type="text" class="form-control" name="stato" id="stato">
				<small id="errore9"  class="errore"></small>
			  </div>
			  <div class="form-group">
				<label for="cap">CAP:</label>
				<input type="text" class="form-control" name="cap" id="cap">
				<small id="errore10" class="errore"></small>
			  </div>
			  <div class="form-group">
				<label for="telefono">Telefono:</label>
				<input type="text" class="form-control" name="telefono" id="telefono">
				<small id="errore11" class="errore"></small>
			  </div>
			<button type="submit" name="submit2" class="btn btn-success">Registrati</button>
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
