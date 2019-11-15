<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

session_start();



     /**
     * login
     *
     * Effettua il login dell'utente.
     * 
     * @param none
     * @return void
     */



function login(){

   //VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
   $connessione = new mysqli($host, $user, $password,$db);

   $cfdest="";

   //ERRORE DI CONNESSIONE
   if ($connessione->connect_error) {
   die("Connection failed: " . $connessione->connect_error);
   header("location:../erroreconnessione.html");
   }


    //QUERY PER FARE IL LOGIN

  	$sql = "SELECT * from utente join email on cf=ref_utente WHERE email = '".$_POST['email']."' AND password='".$_POST['password']."'";
  	$result = $connessione->query($sql);

 	  if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();


    //assegno a delle variabili il contenuto di ogni campo della tabella utente
      $cf=$row["cf"];
      $nome=$row["nome"];
      $cognome=$row["cognome"];
      $email=$row["email"];
      $password=$row["password"];
      $dataNascita=$row["data_nascita"];
      $stato=$row["stato"];
      $citta=$row["citta"];
      $propic=$row["propic"];
      $attivo=$row["attivo"];
      $saldo=$row["saldo"];

      if($attivo==0){
        header("location:LoginBoundary.php?errore2=true");

      }else{

        //salvo le variabili nella sessione che fa da Entity Utente
        $_SESSION['cf'] = $cf;
        $_SESSION['nome'] = $nome;
        $_SESSION['cognome'] = $cognome;
        $_SESSION['password'] = $password;
        $_SESSION['dataNascita'] = $dataNascita;
        $_SESSION['stato'] = $stato;
        $_SESSION['citta'] = $citta;
        $_SESSION['propic'] = $propic;
        $_SESSION['saldo'] = $saldo;
        $_SESSION['attivo']=$attivo;


      //reindirizzo riepilogo
      header("location:../gestioneprofilo/riepilogo.php");




 	      }

      } else {

        header("location:LoginBoundary.php?errore=true");

 			}


    //CHIUDO CONNESSIONE
    $connessione->close();




}











/**
     * registrazione
     *
     * Effettua la registrazione dell'utente.
     * 
     * @param none
     * @return void
     */


function registrazione(){



//VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
// stringa di connessione al DBMS
$connessione = new mysqli($host, $user, $password,$db);



//ERRORE DI CONNESSIONE
if ($connessione->connect_error) {
die("Connection failed: " . $connessione->connect_error);
header("location:../erroreconnessione.html");
}




// esecuzione della query per la creazione del database
if (!$connessione->query("INSERT INTO utente VALUES('".$_POST['cf']."', '".$_POST['nome']."', '".$_POST['cognome']."', '".$_POST['password']."', '".$_POST['nascita']."', '".$_POST['stato']."', '".$_POST['citta']."', 'propic.png', 0, 0)")) {
    header("location:RegistrazioneBoundary.php?errore=true");


}else{

	if (!$connessione->query("INSERT INTO email VALUES('".$_POST['cf']."', '".$_POST['email']."', 'Principale')")) {
   header("location:RegistrazioneBoundary.php?errore=true");


	}else{

		if (!$connessione->query("INSERT INTO indirizzi VALUES('".$_POST['cf']."', '".$_POST['indirizzo']."', '".$_POST['citta']."', '".$_POST['stato']."', '".$_POST['cap']."', 'Principale')")) {
		header("location:RegistrazioneBoundary.php?errore=true");


		}else{

			if (!$connessione->query("INSERT INTO telefono VALUES('".$_POST['cf']."', '".$_POST['telefono']."', 'Principale')")) {
			     header("location:RegistrazioneBoundary.php?errore=true");


				}else{

					if(!$connessione->query("INSERT INTO preferenze VALUES('".$_POST['cf']."', 0,0,0,0,0,0,0,0,0,'gp',0,0,0,0,0,0,'')")){
						header("location:RegistrazioneBoundary.php?errore=true");


					}else{
						emailconferma($_POST["email"], $_POST["cf"]);
						header("location:LoginBoundary.php?info=true");
					}


				}

			}

		}
}


// chiusura della connessione
$connessione->close();


}

/**
     * emailconferma 
     *
     * Invia un email per confermare la registrazione di un nuovo account utente.
     * 
     * @param String $destmail è l'indirizzo email del destinatario.
     * @param String $cf è il codice fiscale del destinatario.
     * @return void
     */
function emailconferma($destmail, $cf){


$mail = new PHPMailer(TRUE);



try {

	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 587;
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'tls';

	//Username (email address).
	$mail->Username = 'greenpaypaymentservice@gmail.com';

	// Google account password.
	$mail->Password = 'greenpaypassword';

   // Set the mail sender.
   $mail->setFrom('greenpaypaymentservice@gmail.com', 'GreenPay');

   // Add a recipient.
   $mail->addAddress($destmail);

   // Set the subject.
   $mail->Subject = 'Conferma Registrazione';

   // Set the mail message body.
  $mail->isHTML(TRUE);
  $mail->Body = '<html><p>Ciao, conferma la tua registrazione a GreenPay!<br> Clicca su <a href="http://greenpay-app.herokuapp.com/autenticazione/main.php?conferma='.$cf.'">questo link</a> per iniziare ad utilizzare i nostri servizi! :)</p></html>';
  $mail->AltBody = 'Conferma Registrazione';



   // Finally send the mail.
   $mail->send();
}
	catch (Exception $e)
	{
	   // PHPMailer exception.
	  echo $e->errorMessage();
	}
	catch (\Exception $e)
	{
	   // PHP exception (note the backslash to select the global namespace Exception class).
	  echo $e->getMessage();
	}



}

    /**
     * conferma 
     *
     * Attiva l'account dell'utente appena registrato.
     * 
     * @param String $cf è il codice fiscale del nuovo utente.
     * @return void
     */

function conferma($cf){



//VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
// stringa di connessione al DBMS
$connessione = new mysqli($host, $user, $password,$db);



//ERRORE DI CONNESSIONE
if ($connessione->connect_error) {
die("Connection failed: " . $connessione->connect_error);
header("location:../erroreconnessione.html");
}





// esecuzione della query per la creazione del database
if (!$connessione->query("UPDATE utente SET attivo = 1 WHERE cf='".$cf."'")) {
   echo "Errore: ". $connessione->connect_error . ".";

}else{
		header("location:LoginBoundary.php?success=true");

		}


// chiusura della connessione
$connessione->close();


}


/**
     * logout 
     *
     * Effettua il logout utente distruggendo la sessione.
     * 
     * @param none
     * @return void
     */
function logout(){
	session_destroy();
	header("location:../index.html");
}



?>
