<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	//MAIN DI GESTIONE PROFILO
	include('AutenticazioneControl.php');
	
	if(isset($_POST["submit1"])){
		login();
	} else if(isset($_POST["submit2"])){
		registrazione();
	} else if(isset($_GET["esci"])){
		logout();
	} else if(isset($_GET["conferma"])){
		conferma($_GET["conferma"]);
	} 
?>
