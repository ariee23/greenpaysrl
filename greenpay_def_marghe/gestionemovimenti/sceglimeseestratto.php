<!-- Sim -->

<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>GreenPay: Cronologia</title>
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
		
        <div class="col-lg-6 barra-cronologia">
		   <div class="input-group">
				
			</div>
			</div>
			
        </div>
		 <div class="row justify-content-center">
			<div class="col-lg-8 my-col">
				<h4>Scegli il mese e visualizza il tuo estratto conto!</h4>
				<hr>
				
				<br>
				<form method="post"; action="estratticonto.php">

				<table style="width:100%; text-align:center">
					<tr>
						<th> </th>
						<th>  </th>
						<th> </th>
						<th> </th>

					</tr>

				  <tr>
					<td> Estratto Conto Gennaio</td>
					<td>              </td>
					<td>
					 <button name='prova' type='submit'     value='movimentigennaio' >Visualizza</button> </td>

				  </tr>
				   
 <tr>
					<td> Estratto Conto Febbraio</td>
					<td>              </td>
					<td>
					 <button name='prova' type='submit'     value='movimentifebbraio' >Visualizza</button> </td>

				  </tr>
				    <tr>
					<td> Estratto Conto Marzo</td>
					<td>              </td>
					<td>
					 <button name='prova' type='submit'     value='movimentimarzo' >Visualizza</button> </td>

				  </tr>
				    <tr>
					<td> Estratto Conto Aprile</td>
					<td>              </td>
					<td>
					 <button name='prova' type='submit'     value='movimentiaprile' >Visualizza</button> </td>

				  </tr>
				    <tr>
					<td> Estratto Conto Maggio</td>
					<td>              </td>
					<td>
					 <button name='prova' type='submit'     value='movimentimaggio' >Visualizza</button> </td>

				  </tr>
				    <tr>
					<td> Estratto Conto Giugno</td>
					<td>              </td>
					<td>
					 <button name='prova' type='submit'     value='movimentigiugno' >Visualizza</button> </td>

				  </tr>
				    <tr>
					<td> Estratto Conto Luglio</td>
					<td>              </td>
					<td>
					 <button name='prova' type='submit'     value='movimentiluglio' >Visualizza</button> </td>

				  </tr>
				    <tr>
					<td> Estratto Conto Agosto</td>
					<td>              </td>
					<td>
					 <button name='prova' type='submit'     value='movimentiagosto' >Visualizza</button> </td>

				  </tr>
				    <tr>
					<td> Estratto Conto Settembre</td>
					<td>              </td>
					<td>
					 <button name='prova' type='submit'     value='movimentisettembre' >Visualizza</button> </td>

				  </tr>
				    <tr>
					<td> Estratto Conto Ottobre</td>
					<td>              </td>
					<td>
					 <button name='prova' type='submit'     value='movimentiottobre' >Visualizza</button> </td>

				  </tr>
				    <tr>
					<td> Estratto Conto Novembre</td>
					<td>              </td>
					<td>
					 <button name='prova' type='submit'     value='movimentinovembre' >Visualizza</button> </td>

				  </tr>
				    <tr>
					<td> Estratto Conto Dicembre</td>
					<td>              </td>
					<td>
					 <button name='prova' type='submit'     value='movimentidicembre' >Visualizza</button> </td>

				  </tr>
				   












				</table>
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
