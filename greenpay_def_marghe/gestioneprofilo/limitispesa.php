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
   <a class="nav-link active" href="sicurezza.php">Sicurezza</a>
 </li>
 <li class="nav-item">
   <a class="nav-link" href="notifiche.php">Notifiche</a>
 </li>
</ul>

 <?php
     if(@$_GET['success']==true){
     ?>
     <div class="alert alert-success alert-dismissible">
     <button type="button" class="close" data-dismiss="alert">&times;</button>
     Limite di spesa modificato correttamente.</div>
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
<div class="container">
 <div class="row justify-content-center">
   <div class="col-lg-8 my-col3">
   <h4>Limiti di spesa</h4>
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
        $row=$result->fetch_assoc();
         $limite=str_replace('.',',',$row['limite_mensile']);
        echo "I limiti di spesa sono attualmente impostati a <b>"  . $limite . " EUR/mese</b>";

        
       }

       $conn->close();
   ?>
   <hr>
   <h5>Modifica</h5>
   <form action="main.php" method="post" onsubmit="return validaLimite()">
     <div class="form-group">
     <label for="limite">Importo:</label>
     <input type="text" class="form-control" name="limite" id="limite" placeholder="EUR/mese">
     <small id="errore1" class="errore"></small>
     </div>
     <br>
       <button type="submit" name="submit6" class="btn btn-success">Avanti</button> oppure, <a href="main.php?limite=true"> elimina i limiti impostati.</a>
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
