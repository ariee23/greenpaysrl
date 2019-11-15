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
			<a class="nav-link" href="#">Accedi</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="RegistrazioneBoundary.php">Registrati</a>
			</li>
		</ul>
	</div>
	</div>
</nav>

<?php
			if(@$_GET['success']==true){
			?>
			<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			Registrazione completata con successo.
			</div>
		<?php
			}
		?>

	<?php
			if(@$_GET['info']==true){
			?>
			<div class="alert alert-info alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			Ti è stata inviata una mail di conferma della registrazione.
			</div>
		<?php
			}
		?>

	<?php
			if(@$_GET['errore']==true){
			?>
			<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			Email e/o password errati.
			</div>
		<?php
			}
		?>

		<?php
			if(@$_GET['errore2']==true){
			?>
			<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			Conferma l'account prima di accedere.
			</div>
		<?php
			}
		?>


<!-- form -->
<div class="container-fluid padding">
	<div class="row justify-content-center">
		<div class="col-lg-6 my-col5">
			<h4>Accedi a GreenPay </h4>
			<hr>
			<form action="main.php" method="post" onsubmit="return validaLogin()">
			  <div class="form-group">
				<label for="email">Email:</label>
				<input type="text" class="form-control" name="email" id="email">
				<small id="errore1"  class="errore"></small>
			  </div>
			   <div class="form-group">
				<label for="password">Password:</label>
				<input type="password" class="form-control" name="password" id="password">
				<small id="errore2"  class="errore"></small>
			  </div>
			<button type="submit" name="submit1" class="btn btn-success">Accedi</button> oppure <a href="RegistrazioneBoundary.php">registrati.</a>
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
