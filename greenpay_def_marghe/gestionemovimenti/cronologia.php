<?php
/* QUESTA BOUNDARY E' UNA PAGINA HTML CHE MOSTRA LA CRONOLOGIA ALL'UTENTE ,
 TRAMITE UN METODO IN PHO CHE RESTITUISCE IL RISULTATO DELLA QUERY CHE PRENDE TUTTI I MOVIMENTI EFFETTUATI 
 DALL'UTENTE LOGGATO E LI STAMPA ALL'INTERNO DI UNA TABELLA CON IL METODO mostraCronologia

*/
 //mostra gli errori su schermo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL | E_STRICT);

 session_start();
 
include ('GestioneMovimentiControl.php');

 $ogg= new GestioneMovimentiControl(); 
?>



<!-- Sim -->

<!DOCTYPE html>
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
		<style>
@import url('https://fonts.googleapis.com/css?family=Poppins:400,500,700');


html,body{
	height: 100%;
	width: 100%;
	font-family: 'Poppins', sans-serif;
	color: #222;
	background-color: #ebfaeb;
}

.form-1{
	background-color:white;
	margin-top: 80px;
	margin-bottom: 50px;
	padding: 50px;
	border-radius: 25px;
	
}

.nav-2{
	background-color:white;
}

.my-col{
	background-color: white;
	border-radius:25px;
	margin-top: 30px;
	padding: 20px;

}

.my-col1{
	background-color: white;
	border-radius:25px;
	margin-top: 10px;
	padding: 20px;
}

.my-col2{
	margin-left: 5px;
	margin-right: 5px;
}

.my-col3{
	background-color: white;
	border-radius:25px;
	margin-top: 30px;
	padding: 40px;

}

.my-col4{
	background-color: white;
	border-radius:25px;
	margin-top: 30px;
	padding: 20px;
}

.my-col5{
	margin-top:40px;
}


.propic{
	border-radius: 50%;
	height: 80px;
	width: 80px;
	float:left;
}

.p1{
	font-size: 24px;
	margin-top: 25px;
	padding-left: 100px;
	padding-bottom: 20px;
}

.plus-btn{
	margin-top: -40px;
	float:right;
}

table tr:nth-child(even) {
  background-color: white;
}
table tr:nth-child(odd) {
 background-color: #ebfaeb;
}

.tab1{
	padding-right: 2px;
	text-align: right;
}

.notifiche-btn{
	margin-left: 2px;
	margin-right: 2px;
	float:right;
}

.barra-cronologia{
	margin-top: 40px;
	
}

.calendari{
	border-color: green;
	border-style: solid;
}

.freccia-btn{
	float:right; 
	margin-top:-35px
}

.freccia-btn1{
	float:right; 
	margin-top:-40px
}

.pic{
	height:80px;
	width:80px;
	
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
<!-- <div class="input-group" style="margin-top:20px">
				Inizio: <input class="calendari" type="date" name="inizio">
				Fine: <input class="calendari" type="date" name="fine">
			</div> -->
			
<div class="container">
    <div class="row justify-content-center">	
		<div class="col-lg-2">
		<!-- inserire popover?? per selezionare la data-->
			<button type="button" class="btn btn-success" style="margin-top:20px; float:right" ><i class="far fa-calendar-alt"></i><br>Seleziona<br>Data</button>
		</div>

        <div class="col-lg-6 barra-cronologia">
		   <div class="input-group">
			
				


<form action="filtro.php" method="post">
   <!-- here start the dropdown list -->
    <select name="tipo">
    	      <option value="none">Operazione                              </option>

      <option value="pagamento">Pagamenti                              </option>
      <option value="accredito">Accrediti                              </option>
        


    </select>
     <!-- here start the dropdown list -->
    <select name="metodo">
         <option value="none">Metodo                              </option>

            <option value="carta">  Carta                           </option>

      <option value="gp">GreenPay                               </option>
            <option value="conto corrente">Conto Corrente       </option>


    </select>

   <!-- here start the dropdown list -->
    <select name="mese">
     <option value="none">Mese                              </option>

      <option value="movimentigennaio">Gennaio                              </option>
      <option value="movimentifebbraio">Febbraio                              </option>
      <option value="movimentimarzo"> Marzo                           </option>
      <option value="movimentiaprile">Aprile                               </option>
            <option value="movimenti">Maggio       </option>
      <option value="movimentigiugno">Giugno                               </option>
      <option value="movimentiluglio">Luglio                               </option>
      <option value="movimentiagosto">Agosto                               </option>
      <option value="movimentisettembre">Settembre                               </option>
      <option value="movimentiottobre">Ottobre                               </option>
      <option value="movimentinovembre">Novembre                               </option>
      <option value="movimentidicembre">Dicembre                               </option>


    </select>
    <input type="submit" name="show_dowpdown_value" value="Go!"   class="btn btn-success "/>
  </form>
				





			</div>
			</div>
			<div class="col-lg-2"><a href="sceglimeseestratto.php">
				<button type="button" class="btn btn-success"  style="margin-top:20px" 
					<i class="fas fa-file-alt"></i> <br>Estratti<br>Conto</button></a>
			</div>
        </div>
		 <div class="row justify-content-center">
			<div class="col-lg-8 my-col"  >
				<h5>Cronologia</h5>
				<br>
				<table style="width:100%; text-align:center">
				
					<tr>
						<th> &nbsp&nbsp&nbsp&nbspCodice&nbsp</th>
						<th>Mittente</th>
						<th> Dest.&nbsp  </th>
						<th> Cifra  </th>
						<th>&nbsp Data &nbsp</th>
						<th> Metodo&nbsp </th>





					</tr>

					<?php 


                          $ogg->visualizzaCronologia();



                           ?>
				</table>
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