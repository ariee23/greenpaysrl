<!-- Sim -->
 <?php
 session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>GreenPay: Portafoglio</title>
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
     <a class="nav-link active" href="#">Portafoglio</a>
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
     if(@$_GET['error']==true){
     ?>
     <div class="alert alert-success alert-dismissible">
     <button type="button" class="close" data-dismiss="alert">&times;</button>
     Si è verificato un errore. Riprova.</div>
   <?php
     }
   ?>



   <?php
     if(@$_GET['modmetpref']==true){
     ?>
     <div class="alert alert-success alert-dismissible">
     <button type="button" class="close" data-dismiss="alert">&times;</button>
     Metodo di pagamento preferito modificato.</div>
   <?php
     }
   ?>

   <?php
     if(@$_GET['rimuovimet']==true){
     ?>
     <div class="alert alert-success alert-dismissible">
     <button type="button" class="close" data-dismiss="alert">&times;</button>
     Metodo di pagamento rimosso.</div>
   <?php
     }
   ?>


   <?php
     if(@$_GET['aggcarta']==true){
     ?>
     <div class="alert alert-success alert-dismissible">
     <button type="button" class="close" data-dismiss="alert">&times;</button>
     Carta di credito aggiunta correttamente.</div>
   <?php
     }
   ?>

   <?php
     if(@$_GET['aggconto']==true){
     ?>
     <div class="alert alert-success alert-dismissible">
     <button type="button" class="close" data-dismiss="alert">&times;</button>
     Conto bancario aggiunto correttamente.</div>
   <?php
     }
   ?>




<!-- contenuto -->
<div class="container">
 <div class="row justify-content-center">
   <div class="col-lg-5 my-col2">
     <div class="row">
     <div class="col-lg-12 align-self-start my-col">
     <h6>Collega una carta</h6> <a href="aggcarta.php" class="btn btn-success freccia-btn"><i class="fas fa-arrow-right"></i></a>
     Proteggi i dati della tua carta quando fai acquisti.
     <hr>
     <h6>Collega conto bancario</h6>	<a href="aggconto.php" class="btn btn-success freccia-btn"><i class="fas fa-arrow-right"></i></a>
     Usalo per inviare denaro agli amici nell'Unione europea in modo gratuito.
     </div>
     <div class="col-lg-12 my-col1">
     <h5>Metodi di pagamento</h5>
     <hr>
     <div class='table-responsive'><table class='tab2'>

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

       $sql = "SELECT * FROM metodo_carta WHERE ref_utente = '".$_SESSION['cf']."'";
       $result = $conn->query($sql);

       if ($result->num_rows > 0) {

         $sql2 = "SELECT metodo_preferito FROM preferenze WHERE ref_utente = '".$_SESSION['cf']."'";
         $result2 = $conn->query($sql2);
         $row2 = $result2->fetch_assoc();
         // output data of each row
         while($row = $result->fetch_assoc()) {
           $carta = substr($row["numero_carta"],12);
           if($row2["metodo_preferito"] == $row["numero_carta"]){
           echo "<tr><td><i class='far fa-credit-card'></i></td><td>"  . $row["tipo"] . "<br><small>Carta di credito</small></td><td>****" . $carta . "</td><td><a href=\"main?metodo=".$row['numero_carta']."\" class='btn btn-success btn-sm'><i class='fas fa-star'></i></a>
         <a href=\"main.php?numerocarta=".$row['numero_carta']."\" class='btn btn-outline-success btn-sm'><i class='fas fa-times'></i></a></td></tr>";
           } else {
             echo "<tr><td><i class='far fa-credit-card'></i></td><td>"  . $row["tipo"] . "<br><small>Carta di credito</small></td><td>****" . $carta . "</td><td><a href=\"main.php?metodo=".$row['numero_carta']."\" class='btn btn-outline-success btn-sm'><i class='fas fa-star'></i></a>
         <a href=\"main.php?numerocarta=".$row['numero_carta']."\" class='btn btn-outline-success btn-sm'><i class='fas fa-times'></i></a></td></tr>";
           }
         }

       }

       $sql = "SELECT * FROM metodo_iban WHERE ref_utente = '".$_SESSION['cf']."'";
       $result = $conn->query($sql);

       if ($result->num_rows > 0) {

         $sql2 = "SELECT metodo_preferito FROM preferenze WHERE ref_utente = '".$_SESSION['cf']."'";
         $result2 = $conn->query($sql2);
         $row2 = $result2->fetch_assoc();

         while($row = $result->fetch_assoc()) {
           $iban = substr($row["iban"],23);
           if($row2["metodo_preferito"] == $row["iban"]){
           echo "<tr><td><i class='fas fa-money-check-alt'></i></td><td>"  . $row["banca"] . "<br><small>Conto bancario</small></td><td>****" . $iban . "</td><td><a href=\"main.php?metodo=".$row['iban']."\" class='btn btn-success btn-sm'><i class='fas fa-star'></i></a> <a href=\"main.php?iban=".$row['iban']."\" class='btn btn-outline-success btn-sm'><i class='fas fa-times'></i></a></td></tr>";
         } else {
           echo "<tr><td><i class='fas fa-money-check-alt'></i></td><td>"  . $row["banca"] . "<br><small>Conto bancario</small></td><td>****" . $iban . "</td><td><a href=\"main.php?metodo=".$row['iban']."\" class='btn btn-outline-success btn-sm'><i class='fas fa-star'></i></a> <a href=\"main.php?iban=".$row['iban']."\" class='btn btn-outline-success btn-sm'><i class='fas fa-times'></i></a></td></tr>";
         }
       } echo "</table></div>";
     } else {
       echo "</table></div>";
     }

       $conn->close();
     ?>
     </div>
   </div>
   </div>
       <div class="col-lg-5 my-col my-col2 align-self-start">
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

       $sql = "SELECT * FROM preferenze join utente on ref_utente=cf WHERE ref_utente= '".$_SESSION['cf']."'";
       $result = $conn->query($sql);

       if ($result->num_rows > 0) {
        $row=$result->fetch_assoc();
          if($row["metodo_preferito"] == "gp"){
         echo "<h5>Saldo GreenPay <i class='fas fa-star'></i></a></h5><hr>";
         } else {
           echo "<h5>Saldo GreenPay</h5><hr>";
         }

         $saldo = str_replace('.', ',', $row["saldo"]);
         echo "<p class='p2'>" . $saldo . " EUR<br>";

       }

   $conn->close();
     ?>

     <a href="../gestionepagamenti/ricaricaconto.php" class="btn btn-success">Trasferisci denaro</a></p>
     <hr>
     <p class="p3">GreenPay funziona anche senza un saldo<br>
     <small>Puoi usare GreenPay per fare acquisti o inviare denaro anche quando il saldo è pari a zero.</small><p>
     <hr>
     <p class="p3">Metodo preferito per pagare online<br>
     <small>Il saldo disponibile verrà usato quando fai acquisti online o invii denaro per beni e servizi.
     Se non hai denaro sufficiente sul tuo saldo, ti chiederemo di scegliere un altro metodo di pagamento al momento del pagamento.</small><br>
     <a href="main.php?metodo=gp">Imposta come metodo preferito</a></p>
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
