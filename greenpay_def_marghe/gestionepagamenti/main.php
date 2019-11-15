 <?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 //MAIN DI GESTIONE PAGAMENTI
 include("gestpagamenticontrol.php");

 if(isset($_POST["submit1"])){
	inviadenaroprivato();
 } else if(isset($_POST["submit2"])){
	inviadenarobusiness();
 } else if(isset($_POST["submit3"])){
	invitautente();
 } else if(isset($_POST["submit4"])){
	ricaricaconto();
 } else if(isset($_POST["submit5"])){
	inviarichiesta();
 } else if(isset($_GET["cod"])){
	rifiutarichiesta();
 } else if(isset($_POST["submit6"])){
	accettarichiesta();
} else if(isset($_POST["submit7"])){
 primoperiodico();
}







































 ?>
