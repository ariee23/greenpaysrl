<?php
	//MAIN DI GESTIONE PROFILO
	include('gestprofcontrol.php');
	
	if(isset($_POST["submit1"])){
	aggiungiind();
	} else if(isset($_POST["submit2"])){
	aggiungitel();
	} else if(isset($_POST["submit3"])){
	aggiungiemail();
	} else if(isset($_POST["submit4"])){
	modificadati();
	} else if(isset($_POST["submit5"])){
	modificapw();
	} else if(isset($_POST["submit6"])){
	limitemensile();
	} else if(isset($_GET["limite"])){
	rimuovilimite();
	} else if(isset($_GET["avvisomailpag"])){
	avvisomailpag();
	} else if(isset($_GET["avvisosmspag"])){
	avvisosmspag();
	} else if(isset($_GET["avvisowapag"])){
	avvisowapag();
	} else if(isset($_GET["avvisofondimail"])){
	avvisofondimail();
	} else if(isset($_GET["avvisofondisms"])){
	avvisofondisms();
	} else if(isset($_GET["avvisofondiwa"])){
	avvisofondiwa();
	} else if(isset($_GET["avvisolimitemail"])){
	avvisolimitemail();
	} else if(isset($_GET["avvisolimitesms"])){
	avvisolimitesms();
	} else if(isset($_GET["avvisolimitewa"])){
	avvisolimitewa();
	} else if(isset($_GET["avvisomailec"])){
	avvisomailec();
	} else if(isset($_GET["avvisosmsec"])){
	avvisosmsec();
	} else if(isset($_GET["avvisowaec"])){
	avvisowaec();
	} else if(isset($_GET["avvisoerroremail"])){
	avvisoerroremail();
	} else if(isset($_GET["avvisoerroresms"])){
	avvisoerroresms();
	} else if(isset($_GET["avvisoerrorewa"])){
	avvisoerrorewa();
	} else if(isset($_GET["avvisorichiestamail"])){
	avvisorichiestamail();
	} else if(isset($_GET["avvisorichiestasms"])){
	avvisorichiestasms();
	} else if(isset($_GET["avvisorichiestawa"])){
	avvisorichiestawa();
	} else if(isset($_GET["avvisoricevimail"])){
	avvisoricevimail();
	} else if(isset($_GET["avvisoricevisms"])){
	avvisoricevisms();
	} else if(isset($_GET["avvisoriceviwa"])){
	avvisoriceviwa();
	} else if(isset($_GET["email"])){
	rimuovimail();
	}else if(isset($_GET["numero"])){
	rimuovinumero();
	}else if(isset($_GET["indirizzo"])){
	rimuoviind();
	} else if(isset($_POST["submit8"])){
	modmail();
	} else if(isset($_POST["submit9"])){
	aggiungicarta();
	} else if(isset($_POST["submit10"])){
	aggiungiconto();
	} else if(isset($_GET["metodo"])){
	modmetodopreferito();
	} else if(isset($_GET["numerocarta"])){
	eliminacarta();
	} else if(isset($_GET["iban"])){
	eliminaconto();
	} else if(isset($_GET["chiudi"])){
	chiudiconto();
	} else if(isset($_POST["submit11"])){
	modtel();
	} else if(isset($_POST["submit12"])){
	modind();
	} else if(isset($_POST["submit13"])){
	aggiungichatid();
	} 
?>
