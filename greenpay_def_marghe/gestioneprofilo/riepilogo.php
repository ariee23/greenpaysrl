<!-- Sim -->
<?php
 session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>GreenPay: Riepilogo</title>
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
     <a class="nav-link active" href="#">Riepilogo</a>
     </li>
     <li class="nav-item">
     <a class="nav-link" href="../gestionemovimenti/cronologia.php">Cronologia</a>
     </li>
     <li class="nav-item">
     <a class="nav-link" href="../gestionemovimenti/abbonamenti.php">Abbonamenti</a>
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
     <a class="nav-link" href="gestioneprofilo.php"><i class="fas fa-user"></i></a>
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


<?php
     if(@$_GET['success']==true){
     ?>
     <div class="alert alert-success alert-dismissible">
     <button type="button" class="close" data-dismiss="alert">&times;</button>
     Pagamento inviato.</div>
   <?php
     }
   ?>

<?php
     if(@$_GET['success2']==true){
     ?>
     <div class="alert alert-success alert-dismissible">
     <button type="button" class="close" data-dismiss="alert">&times;</button>
     Ricarica Effettuata.</div>
   <?php
     }
   ?>

<?php
     if(@$_GET['success3']==true){
     ?>
     <div class="alert alert-success alert-dismissible">
     <button type="button" class="close" data-dismiss="alert">&times;</button>
     Richiesta inviata.</div>
   <?php
     }
   ?>

<?php
     if(@$_GET['success4']==true){
     ?>
     <div class="alert alert-success alert-dismissible">
     <button type="button" class="close" data-dismiss="alert">&times;</button>
     Utente invitato.</div>
   <?php
     }
   ?>

   <?php
         if(@$_GET['success5']==true){
         ?>
         <div class="alert alert-success alert-dismissible">
         <button type="button" class="close" data-dismiss="alert">&times;</button>
         Pagamento periodico attivato.</div>
       <?php
         }
       ?>



<!-- contenuto -->
<div class="container-fluid">
 <div class="row justify-content-center">
 <div class="col-lg-3 my-col4">
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

       $sql = "SELECT * FROM utente WHERE cf= '".$_SESSION['cf']."'";
       $result = $conn->query($sql);

       if ($result->num_rows > 0) {
         $row=$result->fetch_assoc();

         echo "<h4>Ciao, ". $row["nome"]. "</h4>";
       }

       $conn->close();

     ?>
 </div>
 <div class="col-lg-1"></div>
 <div class="col-lg-4 my-col4">
 <a href="portafoglio.php" class="btn btn-success notifiche-btn">Altro</a>
 <a href="../gestionepagamenti/richiedi.php" class="btn btn-success notifiche-btn">Richiedi</a>
 <a href="../gestionepagamenti/scegliutente.php" class="btn btn-success notifiche-btn">Invia</a>
 </div>
 </div>
 <div class="row justify-content-center">
   <div class="col-lg-4 my-col2">
   <div class="row">
   <div class="col-lg-12 my-col align-self-start">
     <h5>Saldo conto</h5>
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

       $sql = "SELECT * FROM utente WHERE cf= '".$_SESSION['cf']."'";
       $result = $conn->query($sql);

       if ($result->num_rows > 0) {
         $row=$result->fetch_assoc();

         $saldo = str_replace('.', ',', $row["saldo"]);
         echo "<p class='p4'>" . $saldo . " EUR</p>";
       }

       $conn->close();
     ?>
     <a href="../gestionepagamenti/ricaricaconto.php" class="btn btn-success plus-btn" style="float:right">Ricarica conto</a>
     </div>
     <div class="col-lg-12 align-self-start my-col1">
     <h5>Attività recenti</h5>
     <a href="../gestionemovimenti/cronologia.php" class="btn btn-success plus-btn"><i class="fas fa-arrow-right"></i></a>
     <hr>
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


       $sql = "SELECT * FROM movimenti WHERE mittente = '".$_SESSION['cf']."' or destinatario = '".$_SESSION['cf']."' ORDER BY cod_movimento DESC LIMIT 3";
       $result = $conn->query($sql);

       if ($result->num_rows > 0) {
         echo "<div class='table-responsive'><table class='tab'>";
         // output data of each row
         while($row = $result->fetch_assoc()) {
           $cifra = str_replace('.', ',', $row["cifra"]);
           $destinatario = $row["destinatario"];
           $mittente = $row["mittente"];

           if(strlen($destinatario)==16){
           $sql2 = "SELECT * FROM utente WHERE cf= '".$destinatario."'";
           $result2 = $conn->query($sql2);
           $row2 = $result2->fetch_assoc();
           $destinatario=$row2["nome"] ." " .$row2["cognome"];
           }

           if(strlen($mittente)==16){
           $sql2 = "SELECT * FROM utente WHERE cf= '".$mittente."'";
           $result2 = $conn->query($sql2);
           $row2 = $result2->fetch_assoc();
           $mittente=$row2["nome"] ." " .$row2["cognome"];
           }

           if($row["mittente"] == $_SESSION['cf']){
           echo "<tr><td>"  . $row["data"] . "</td><td>" . $destinatario . "<br><small>" . $row["tipo_op"] . "</small></td><td>-" . $cifra . " EUR</td></tr>";
         } else {
           echo "<tr><td>"  . $row["data"] . "</td><td>" . $mittente . "<br><small>" . $row["tipo_op"] . "</small></td><td>+" . $cifra . " EUR</td></tr>";
         }
         }
         echo "</table></div>";
       }

       $conn->close();
     ?>
     </div>
   </div>
   </div>
       <div class="col-lg-4 my-col my-col2 align-self-start">
     <h5>Portafoglio</h5>
     <a href="portafoglio.php" class="btn btn-success freccia-btn1"><i class="fas fa-arrow-right"></i></a>
     <hr>
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

       $sql = "SELECT * FROM metodo_carta WHERE ref_utente = '".$_SESSION['cf']."'";
       $result = $conn->query($sql);

       if ($result->num_rows > 0) {
         echo "<div class='table-responsive'> <table class='tab2'>";
         // output data of each row
         while($row = $result->fetch_assoc()) {
           $carta = substr($row["numero_carta"],12);
           echo "<tr><td><i class='far fa-credit-card'></i></td><td>"  . $row["tipo"] . "<br><small>Carta di credito</small></td><td>****" . $carta . "</td></tr>";
         }

       }

       $sql = "SELECT * FROM metodo_iban WHERE ref_utente = '".$_SESSION['cf']."'";
       $result = $conn->query($sql);

       if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
           $iban = substr($row["iban"],23);
           echo "<tr><td><i class='fas fa-money-check-alt'></i></td><td>"  . $row["banca"] . "<br><small>Conto bancario</small></td><td>****" . $iban . "</td></tr>";
         }
         echo "</table></div>";
       }

       $conn->close();
     ?>
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
