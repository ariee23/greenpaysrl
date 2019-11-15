<!-- Sim -->

<!DOCTYPE html>

<?php
/* QUESTA BOUNDARY E' UNA PAGINA HTML CHE MOSTRA LA CRONOLOGIA dell'UTENTE ,
 TRAMITE UN METODO IN PHp CHE RESTITUISCE IL RISULTATO DELLA QUERY CHE PRENDE TUTTI I MOVIMENTI EFFETTUATI 
 DALL'UTENTE LOGGATO E LI STAMPA ALL'INTERNO DI UNA TABELLA CON IL METODO mostraCronologia

*/
 //mostra gli errori su schermo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL | E_STRICT);
 session_start();
 include ('GestioneMovimentiControl.php');

include ('pdfprova2.php');

 $pdf= new PDF(); 

 $ogg= new GestioneMovimentiControl();

 //$ogg->emailEstrattoConto();

 $ogg->controlloEstratto();

?>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>GreenPay: Cronologia</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script src="https://kit.fontawesome.com/3d31361b31.js"></script>
	<style type="text/css">
      th,td{
            padding-left: 10px;
            padding-right: 10px;
       }
    </style>
</head>
<body>

<!-- navigation -->
<nav class="navbar navbar-expand-md navbar-dark bg-success sticky-top">
	<div class="container-fluid">
	<a class="navbar-brand" href="#"><img src="img/logo.png"></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarResponsive">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item">
			<a class="nav-link" href="riepilogo.html">Riepilogo</a>
			</li>
			<li class="nav-item">
			<a class="nav-link active" href="cronologia.php">Cronologia</a>
			</li>
					<li class="nav-item">
			<a class="nav-link active" href="abbonamenti.php">Abbonamenti</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="invia.html">Invia e Richiedi</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="portafoglio.html">Portafoglio</a>
			</li>
		</ul>
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
			<a class="nav-link" href="gestioneprofilo.html"><i class="fas fa-user"></i></a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="#"><i class="far fa-bell"></i></a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="#">Esci</a>
			</li>
		</ul>
	</div>
	</div>
</nav>

<!-- contenuto -->
<div class="container">
		 <div class="row justify-content-center">
			<div class="col-lg-8 my-col">
				<h4>Estratto Conto</h4>
				<hr>
				<div class="table-responsive" style="padding-bottom: 10px; padding-top: 5px;">
				<h5>Riepilogo movimenti</h5> 


				<table style="width:100%; text-align:center">
					<tr>
												<th> Saldo inizio mese</th>

						<th> Totale uscite</th>
						<th> Totale entrate</th>

						<th> Saldo fine mese</th>

					</tr>
                    <tr>



                    <td><?php

                    $b=$_POST['prova'];// LOOOOL
$ris=$ogg->saldoInizioMese($b);
                     echo $ris." EUR";


                    ?></td>



                        <td>
                        	<?php
                      $b=$_POST['prova'];// LOOOOL

                  $pag=$ogg->pagamentiTot2($b);
                  echo $pag." EUR";
                 



                        ?></td>
                        <td>      	<?php

                      $b=$_POST['prova'];// LOOOOL

                       $acc=$ogg->accreditiTot2($b); 
                       echo $acc." EUR";
                   


                        ?></td>

<td><?php

                    $mese=$_POST['prova'];// LOOOOL

                   $saldofine=$ogg->saldoFineMese($mese);
                   $saldoinizio=$ogg->saldoInizioMese($mese);
                   $saldoreale=$saldoinizio+$saldofine;
                   if()


                   echo $saldoreale." EUR";
             


 
                        ?></td>


                    </tr>
				</table>
				<br>
				<table style="width:100%; text-align:center">
						<tr>
						<th> &nbsp&nbsp&nbsp&nbspCodice&nbsp</th>
					
						<th> Cifra  </th>
						<th>&nbsp Data &nbsp</th>
						<th> Metodo&nbsp </th>
						<th> &nbspOperazione&nbsp</th>





					</tr>

				        	<?php
                      $b=$_POST['prova'];// LOOOOL
                     // $ris=$ogg->pagamentiTot2($b)

           $ogg->visualizzaCronologiaMese($b);


                // echo     $ogg->pagamentiTot2($b);




                        ?>
				</table>
				</div>
				<br>



				<form name="f3" method="POST" action="download.php">

					 <button name='a' type='submit'    value='<?php echo $_POST['prova'];?>'>Scarica PDF</button>
		         	</form>







			</div>
	</div>
</div>


<!-- footer -->
<footer>
<div class="container-fluid padding">
	<div class="row text-center">
		<div class="col-12">
			<hr class="light">
			<h5> © 2019 GreenPay</h5>
		</div>
	</div>
</div>
</footer>

</body>
</html>