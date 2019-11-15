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
   <a class="nav-link" href="gestioneprofilo.php">Conto</a>
 </li>
 <li class="nav-item">
   <a class="nav-link" href="sicurezza.php">Sicurezza</a>
 </li>
 <li class="nav-item">
   <a class="nav-link active" href="#">Notifiche</a>
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
	
<?php
     if(@$_GET['success']==true){
     ?>
     <div class="alert alert-success alert-dismissible">
     <button type="button" class="close" data-dismiss="alert">&times;</button>
     ChatID inserito correttamente.</div>
   <?php
     }
   ?>



<!-- contenuto -->
<div class="container-fluid">
 <div class="row justify-content-center">
   <div class="col-lg-6 my-col3 my-col4 align-self-start">
   <h5>Pagamenti
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

				$sql = "SELECT * FROM preferenze WHERE ref_utente = '".$_SESSION['cf']."'";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {

					$row = $result->fetch_assoc();

					if($row['chatid']==""){
						echo "<button class='btn btn-success' style='float:right' data-toggle='modal' data-target='#myModal2'><i class='fas fa-exclamation-circle'></i></button>";
					}

				}

				$conn->close();
     ?>
	   </h5>
			<!-- Modal -->
			  <div class="modal fade" id="myModal2" role="dialog">
				<div class="modal-dialog modal-dialog-centered">

				  <!-- Modal content-->
				  <div class="modal-content">
					<div class="modal-header bg-success">
					<img class="modalpic" src="../img/logo.png"></a>
					  <button type="button" class="close" data-dismiss="modal">&times;</button>

					</div>
					<div class="modal-body">
					<p>Non hai ancora inserito il tuo chat id! Cerca il nostro bot Telegram @greenpay2019_bot, ti comunicherà un codice da inserire di seguito per ricevere le notifiche su Telegram.</p>
  					<form method='post' action='main.php' onsubmit='return validaChatID()'>
					<div class='form-group'>
					<label for='chatid'>ChatID:</label>
					<input type='text' class='form-control' id='chatid' name='chatid'>
				        <small id='errore'  class='errore'></small>
					</div>
					   <button type='submit' name='submit13' class='btn btn-success'>Avanti</button>
					   </form>
					</div>
				  </div>

				</div>
			  </div>
	 
	    Riceverai una notifica quando<br><br>

   Invii denaro
   <?php
     $servername = "localhost";
       $username = "bee3b716298b4a";
       $password = "bad87d03";
       $dbname = "heroku_16f3a281c2f1459";

       // Create connection
       $conn = new mysqli($servername, $username, $password, $dbname);
       // Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}

				$sql = "SELECT * FROM preferenze WHERE ref_utente = '".$_SESSION['cf']."'";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {

					$row = $result->fetch_assoc();

					if($row['avviso_wa_pag']==0){
						echo "<a href='main.php?avvisowapag=true' class='btn btn-outline-success notifiche-btn btn-sm'><i class='fab fa-telegram'></i></a>";
					} else {
						echo "<a href='main.php?avvisowapag=true' class='btn btn-success notifiche-btn btn-sm'><i class='fab fa-telegram'></i></a>";
					}


					if($row['avviso_mail_pag']==0){
						echo "<a href='main.php?avvisomailpag=true' class='btn btn-outline-success notifiche-btn btn-sm'><i class='far fa-envelope'></i></a>";
					} else {
						echo "<a href='main.php?avvisomailpag=true' class='btn btn-success notifiche-btn btn-sm'><i class='far fa-envelope'></i></a>";
					}

				}
				$conn->close();
     ?>

   <hr>
   Saldo insufficiente
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

				$sql = "SELECT * FROM preferenze WHERE ref_utente = '".$_SESSION['cf']."'";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {

					$row = $result->fetch_assoc();

					if($row['avviso_fondi_wa']==0){
						echo "<a href='main.php?avvisofondiwa=true' class='btn btn-outline-success notifiche-btn btn-sm'><i class='fab fa-telegram'></i></a>";
					} else {
						echo "<a href='main.php?avvisofondiwa=true' class='btn btn-success notifiche-btn btn-sm'><i class='fab fa-telegram'></i></a>";
					}



					if($row['avviso_fondi_mail']==0){
						echo "<a href='main.php?avvisofondimail=true' class='btn btn-outline-success notifiche-btn btn-sm'><i class='far fa-envelope'></i></a>";
					} else {
						echo "<a href='main.php?avvisofondimail=true' class='btn btn-success notifiche-btn btn-sm'><i class='far fa-envelope'></i></a>";
					}

				}

				$conn->close();
     ?>
   <hr>
   Limite superato
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

				$sql = "SELECT * FROM preferenze WHERE ref_utente = '".$_SESSION['cf']."'";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {

					$row = $result->fetch_assoc();

					if($row['avv_limite_wa']==0){
						echo "<a href='main.php?avvisolimitewa=true' class='btn btn-outline-success notifiche-btn btn-sm'><i class='fab fa-telegram'></i></a>";
					} else {
						echo "<a href='main.php?avvisolimitewa=true' class='btn btn-success notifiche-btn btn-sm'><i class='fab fa-telegram'></i></a>";
					}



					if($row['avviso_limite_mail']==0){
						echo "<a href='main.php?avvisolimitemail=true' class='btn btn-outline-success notifiche-btn btn-sm'><i class='far fa-envelope'></i></a>";
					} else {
						echo "<a href='main.php?avvisolimitemail=true' class='btn btn-success notifiche-btn btn-sm'><i class='far fa-envelope'></i></a>";
					}

				}

				$conn->close();
     ?>
   <hr>
   Errore pagamento
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

				$sql = "SELECT * FROM preferenze WHERE ref_utente = '".$_SESSION['cf']."'";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {

					$row = $result->fetch_assoc();

					if($row['avviso_errore_wa']==0){
						echo "<a href='main.php?avvisoerrorewa=true' class='btn btn-outline-success notifiche-btn btn-sm'><i class='fab fa-telegram'></i></a>";
					} else {
						echo "<a href='main.php?avvisoerrorewa=true' class='btn btn-success notifiche-btn btn-sm'><i class='fab fa-telegram'></i></a>";
					}



					if($row['avviso_errore_mail']==0){
						echo "<a href='main.php?avvisoerroremail=true' class='btn btn-outline-success notifiche-btn btn-sm'><i class='far fa-envelope'></i></a>";
					} else {
						echo "<a href='main.php?avvisoerroremail=true' class='btn btn-success notifiche-btn btn-sm'><i class='far fa-envelope'></i></a>";
					}

				}

				$conn->close();
     ?>

   <hr>
   Richiedi denaro
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

				$sql = "SELECT * FROM preferenze WHERE ref_utente = '".$_SESSION['cf']."'";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {

					$row = $result->fetch_assoc();

					if($row['avviso_richiesta_wa']==0){
						echo "<a href='main.php?avvisorichiestawa=true' class='btn btn-outline-success notifiche-btn btn-sm'><i class='fab fa-telegram'></i></a>";
					} else {
						echo "<a href='main.php?avvisorichiestawa=true' class='btn btn-success notifiche-btn btn-sm'><i class='fab fa-telegram'></i></a>";
					}


					if($row['avviso_richiesta_mail']==0){
						echo "<a href='main.php?avvisorichiestamail=true' class='btn btn-outline-success notifiche-btn btn-sm'><i class='far fa-envelope'></i></a>";
					} else {
						echo "<a href='main.php?avvisorichiestamail=true' class='btn btn-success notifiche-btn btn-sm'><i class='far fa-envelope'></i></a>";
					}

				}

				$conn->close();
     ?>


   <hr>
   Ricevi pagamento
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

 				$sql = "SELECT * FROM preferenze WHERE ref_utente = '".$_SESSION['cf']."'";
 				$result = $conn->query($sql);

 				if ($result->num_rows > 0) {

 					$row = $result->fetch_assoc();

 					if($row['avviso_ricevi_wa']==0){
 						echo "<a href='main.php?avvisoriceviwa=true' class='btn btn-outline-success notifiche-btn btn-sm'><i class='fab fa-telegram'></i></a>";
 					} else {
 						echo "<a href='main.php?avvisoriceviwa=true' class='btn btn-success notifiche-btn btn-sm'><i class='fab fa-telegram'></i></a>";
 					}

 					if($row['avviso_ricevi_mail']==0){
 						echo "<a href='main.php?avvisoricevimail=true' class='btn btn-outline-success notifiche-btn btn-sm'><i class='far fa-envelope'></i></a>";
 					} else {
 						echo "<a href='main.php?avvisoricevimail=true' class='btn btn-success notifiche-btn btn-sm'><i class='far fa-envelope'></i></a>";
 					}

 				}
 				$conn->close();
     ?>
   <hr>
   Estratto conto
   <?php

          $servername = "localhost";
       $username = "bee3b716298b4a";
       $password = "bad87d03";
       $dbname = "heroku_16f3a281c2f1459";

       // Create connection
       $conn = new mysqli($servername, $username, $password, $dbname);
       // Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}

				$sql = "SELECT * FROM preferenze WHERE ref_utente = '".$_SESSION['cf']."'";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {

					$row = $result->fetch_assoc();

					if($row['avviso_wa_ec']==0){
						echo "<a href='main.php?avvisowaec=true' class='btn btn-outline-success notifiche-btn btn-sm'><i class='fab fa-telegram'></i></a>";
					} else {
						echo "<a href='main.php?avvisowaec=true' class='btn btn-success notifiche-btn btn-sm'><i class='fab fa-telegram'></i></a>";
					}

					if($row['avviso_mail_ec']==0){
						echo "<a href='main.php?avvisomailec=true' class='btn btn-outline-success notifiche-btn btn-sm'><i class='far fa-envelope'></i></a>";
					} else {
						echo "<a href='main.php?avvisomailec=true' class='btn btn-success notifiche-btn btn-sm'><i class='far fa-envelope'></i></a>";
					}

				}
				$conn->close();
     ?>

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
