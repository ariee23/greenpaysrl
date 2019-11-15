<?php
//CONTROL GESTIONE PROFILO
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



//INIZIA LA SESSIONE
session_start();


//***************FUNZIONE PER MODIFICARE I DATI DEL PROFILO PERSONALE********************
function modificadati(){

//VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database

 // CONNESSIONE AL DBMS
  $connessione = new mysqli($host, $user, $password,$db);


  //ERRORE DI CONNESSIONE
if ($connessione->connect_error) {
die("Connection failed: " . $connessione->connect_error);
header("location:../erroreconnessione.html");
}

    // QUERY PER AGGIORNARE IL DB CON I NUOVI DATI
    if (!$res=$connessione->query("UPDATE utente SET nome = '".$_POST['nome']."', cognome = '".$_POST['cognome']."', data_nascita = '".$_POST['nascita']."', citta = '".$_POST['citta']."', stato = '".$_POST['stato']."' WHERE cf = '".$_SESSION['cf']."'")) {
         header("location:modificadati.php?error=true");

     }else{

	//reindirizzo a gestioneprofilo.php
	header("location:gestioneprofilo.php?datimodificati=true");

	//CHIUDO CONNESSIONE
    $connessione->close();

}

}

//************************FUNZIONE PER AGGIUNGERE MAIL**************************
function aggiungiemail(){


//VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
 //CONNESSIONE AL DBMS
  $connessione = new mysqli($host, $user, $password,$db);


  //ERRORE DI CONNESSIONE
if ($connessione->connect_error) {
die("Connection failed: " . $connessione->connect_error);
header("location:../erroreconnessione.html");
}

    // QUERY PER INSERIRE NEL DB LA NUOVA MAIL
    if (!$res=$connessione->query("INSERT INTO email VALUES ('".$_SESSION['cf']."', '".$_POST['email']."', '')")) {

		header("location:aggemail.php?error=true");

     }else{

				//reindirizzo a gestioneprofilo.php
				header("location:gestioneprofilo.php?aggemail=true");

	//CHIUDO CONNESSIONE
    $connessione->close();

}

}

//************************FUNZIONE PER AGGIUNGERE INDIRIZZO***************************
function aggiungiind(){


 //VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
 // CONNESSIONE AL DBMS
  $connessione = new mysqli($host, $user, $password,$db);


  //ERRORE DI CONNESSIONE
if ($connessione->connect_error) {
die("Connection failed: " . $connessione->connect_error);
header("location:../erroreconnessione.html");
}

    // QUERY PER INSERIRE IL NUOVO INDIRIZZO NEL DB
    if (!$res=$connessione->query("INSERT INTO indirizzi VALUES ('".$_SESSION['cf']."', '".$_POST['ind']."', '".$_POST['citta']."', '".$_POST['stato']."', '".$_POST['cap']."', '')")) {

		header("location:aggind.php?error=true");

     }else{

				//reindirizzo a gestioneprofilo.php
				header("location:gestioneprofilo.php?aggind=true");

    //CHIUDO CONNESSIONE
    $connessione->close();

}

}

//*******************FUNZIONE PER AGGIUNGERE TELEFONO****************************
function aggiungitel(){


 //VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
 // CONNESSIONE AL DBMS
  $connessione = new mysqli($host, $user, $password,$db);


  //ERRORE DI CONNESSIONE
if ($connessione->connect_error) {
die("Connection failed: " . $connessione->connect_error);
header("location:../erroreconnessione.html");
}

    //QUERY PER INSERIRE IL NUMERO NEL DB
    if (!$res=$connessione->query("INSERT INTO telefono VALUES ('".$_SESSION['cf']."', '".$_POST['num']."', '')")) {

		header("location:aggtel.php?error=true");

     }else{

				//reindirizzo a gestioneprofilo.php
				header("location:gestioneprofilo.php?aggtel=true");
    //CHIUDO CONNESSIONE
    $connessione->close();

}

}

//**************************CHIUDI CONTO*******************************
	function chiudiconto(){
//VARIABILI DI CONNESSIONE
   $servername = "localhost";	// nome di host
   $username = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $dbname="heroku_16f3a281c2f1459";//nome database
        //CONNESSIONE AL DBMS
				$conn = new mysqli($servername, $username, $password, $dbname);
        //ERRORE DI CONNESSIONE
      if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
      header("location:../erroreconnessione.html");
      }

        //QUERY PER CANCELLARE I DATI DELL'UTENTE DAL DB
				$sql1 = "DELETE FROM preferenze WHERE ref_utente = '".$_SESSION['cf']."'";
				$sql2 = "DELETE FROM email WHERE ref_utente = '".$_SESSION['cf']."'";
				$sql3 = "DELETE FROM telefono WHERE ref_utente = '".$_SESSION['cf']."'";
				$sql4 = "DELETE FROM indirizzi WHERE ref_utente = '".$_SESSION['cf']."'";
				$sql5 = "DELETE FROM preferenze WHERE ref_utente = '".$_SESSION['cf']."'";
				$sql6 = "DELETE FROM metodo_carta WHERE ref_utente = '".$_SESSION['cf']."'";
				$sql7 = "DELETE FROM metodo_iban WHERE ref_utente = '".$_SESSION['cf']."'";
				$sql8 = "DELETE FROM utente WHERE cf = '".$_SESSION['cf']."'";


				$result1 = $conn->query($sql1);
				if($result1){
					$result2 = $conn->query($sql2);
					if($result2){
						$result3 = $conn->query($sql3);
						if($result3){
							$result4 = $conn->query($sql4);
							if($result4){
								$result5 = $conn->query($sql5);
								if($result5){
									$result6 = $conn->query($sql6);
									if($result6){
										$result7 = $conn->query($sql7);
										if($result7){
											$result8 = $conn->query($sql8);
											if($result8){
												header("location:../index.html");
											} else {
												header("location:gestioneprofilo.php?error=true");
											}
										} else {
											header("location:gestioneprofilo.php?error=true");
										}
									} else {
										header("location:gestioneprofilo.php?error=true");
									}
								} else {
									header("location:gestioneprofilo.php?error=true");
								}
							} else {
								header("location:gestioneprofilo.php?error=true");
							}
						} else {
							header("location:gestioneprofilo.php?error=true");
						}
					} else {
						header("location:gestioneprofilo.php?error=true");
					}
				} else {
					header("location:gestioneprofilo.php?error=true");
				}

        //CHIUDO CONNESSIONE
				$conn->close();

}





//*****************FUNZIONE PER MODIFICARE LA PASSWORD**************************
 function modificapw(){

	 //VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
	 //CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);


    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }

	 // QUERY PER VERIFICARE CHE PWATTUALE SIA GIUSTA
	 $sql = "SELECT * FROM utente WHERE password = '".$_POST['pwattuale']."' AND cf = '".$_SESSION['cf']."'";
	$res = $connessione->query($sql);

	if ($res->num_rows>0) {
			//QUERY PER AGGIORNARE LA PASSWORD
			$sql = "UPDATE utente SET password = '".$_POST['pwnuova']."' WHERE cf = '".$_SESSION['cf']."'";
			$result = $connessione->query($sql);

			if($result){

			header("location: modificapw.php?success=true");

			} else {
				header("location: modificapw.php?error=true");
			}

		} else {
			header("location: modificapw.php?error=true");
		}

    //CHIUDO CONNESSIONE
		$connessione->close();


}



//**************** FUNZIONE PER IMPOSTARE IL LIMITE MENSILE**********************
function limitemensile(){
	//VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
	 //CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);


    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }


	$limite=str_replace(',','.',$_POST['limite']);

  //QUERY PER AGGIORNARE IL LIMITE MENSILE NEL DB
	if(!$res=$connessione->query("UPDATE preferenze SET limite_mensile = '".$limite."' WHERE ref_utente='".$_SESSION['cf']."'")){
		header("location:limitispesa.php?errore=true");
	} else {

		header("location:limitispesa.php?success=true");
				//CHIUDO CONNESSIONE
				$connessione->close();
	}
}

//********************FUNZIONE PER RIMUOVERE IL LIMITE MENSILE**********************
function rimuovilimite(){
	//VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
	 //CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);


    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
    die("Connection failed: " . $connessione->connect_error);
    header("location:../erroreconnessione.html");
  }

  //QUERY PER AGGIORNARE IL LIMITE MENSILE --0 SIGNIFICA CHE NON C'È NESSUN LIMITE
	if(!$res=$connessione->query("UPDATE preferenze SET limite_mensile = 0 WHERE ref_utente='".$_SESSION['cf']."'")){

		header("location:limitispesa.php?error=true");

	} else {

				header("location:limitispesa.php?success=true");
				//CHIUDO CONNESSIONE
				$connessione->close();
	}
}

//*****************NOTIFICHE : INVIO DENARO*******************
function avvisomailpag(){

	 //VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
	 //CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);


    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }

//QUERY PER RICAVARE LE PREFERENZE
	$sql = "SELECT * FROM preferenze WHERE ref_utente = '".$_SESSION['cf']."'";
  //QUERY PER AGGIORNARE LE PREFERENZE
	$sql1 = "UPDATE preferenze SET avviso_mail_pag = '1' WHERE ref_utente = '".$_SESSION['cf']."'";
	$sql2 = "UPDATE preferenze SET avviso_mail_pag = '0' WHERE ref_utente = '".$_SESSION['cf']."'";

	$result=$connessione->query($sql);
	if($result->num_rows>0){
		$row=$result->fetch_assoc();
		if($row['avviso_mail_pag'] == 0){

			$connessione->query($sql1);

			header("location: notifiche.php");

		} else if ($row['avviso_mail_pag'] == 1){

			$connessione->query($sql2);

			header("location: notifiche.php");
		}
	} else {
    header("location: notifiche.php?error=true");
	}

//CHIUDO CONNESSIONE
$connessione->close();



}



function avvisowapag(){

	 //VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
	 //CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);


    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }


	//QUERY PER RICAVARE LE PREFERENZE
	$sql = "SELECT * FROM preferenze WHERE ref_utente = '".$_SESSION['cf']."'";
  //QUERY PER AGGIORNARE LE PREFERENZE
	$sql1 = "UPDATE preferenze SET avviso_wa_pag = '1' WHERE ref_utente = '".$_SESSION['cf']."'";
	$sql2 = "UPDATE preferenze SET avviso_wa_pag = '0' WHERE ref_utente = '".$_SESSION['cf']."'";


	$result=$connessione->query($sql);

	if($result->num_rows>0){
			$row=$result->fetch_assoc();
		if($row['avviso_wa_pag'] == 0){

			$connessione->query($sql1);

			header("location: notifiche.php");

		} else if ($row['avviso_wa_pag'] == 1){

			$connessione->query($sql2);

			header("location: notifiche.php");
		}
	} else {
    header("location: notifiche.php?error=true");
	}


//CHIUDO CONNESSIONE
$connessione->close();



}

//*******************NOTIFICHE: FONDI INSUFFICIENTI*******************

function avvisofondimail(){

	//VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
	 //CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);


    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }

 //QUERY PER RICAVARE LE PREFERENZE
$sql = "SELECT * FROM preferenze WHERE ref_utente = '".$_SESSION['cf']."'";
  //QUERY PER AGGIORNARE PREFERENZE
	$sql1 = "UPDATE preferenze SET avviso_fondi_mail = '1' WHERE ref_utente = '".$_SESSION['cf']."'";
	$sql2 = "UPDATE preferenze SET avviso_fondi_mail = '0' WHERE ref_utente = '".$_SESSION['cf']."'";


	$result=$connessione->query($sql);
	if($result->num_rows>0){
			$row=$result->fetch_assoc();
		if($row['avviso_fondi_mail'] == 0){

			$connessione->query($sql1);

			header("location: notifiche.php");

		} else if ($row['avviso_fondi_mail'] == 1){

			$connessione->query($sql2);

			header("location: notifiche.php");
		}
	} else {
		header("location: notifiche.php?error=true");
	}

//CHIUDO CONNESSIONE
$connessione->close();



}



function avvisofondiwa(){

	//VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
	 //CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);


    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }



 //QUERY PER RICAVARE LE PREFERENZE
	$sql = "SELECT * FROM preferenze WHERE ref_utente = '".$_SESSION['cf']."'";
   //QUERY PER AGGIORNARE LE PREFERENZE
	$sql1 = "UPDATE preferenze SET avviso_fondi_wa = '1' WHERE ref_utente = '".$_SESSION['cf']."'";
	$sql2 = "UPDATE preferenze SET avviso_fondi_wa = '0' WHERE ref_utente = '".$_SESSION['cf']."'";

	$result=$connessione->query($sql);
	if($result->num_rows>0){
			$row=$result->fetch_assoc();
		if($row['avviso_fondi_wa'] == 0){

			$connessione->query($sql1);

			header("location: notifiche.php");

		} else if ($row['avviso_fondi_wa'] == 1){

			$connessione->query($sql2);

			header("location: notifiche.php");
		}
	} else {
		header("location: notifiche.php?error=true");
	}

//CHIUDO CONNESSIONE
$connessione->close();



}


//**************************NOTIFICHE: LIMITE SUPERATO ***************************

function avvisolimitemail(){
//VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
	 //CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);


    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }


//QUERY PER RICAVARE LE PREFERENZE
	$sql = "SELECT * FROM preferenze WHERE ref_utente = '".$_SESSION['cf']."'";

  //QUERY PER AGGIORNARE LE PREFERENZE
	$sql1 = "UPDATE preferenze SET avviso_limite_mail = '1' WHERE ref_utente = '".$_SESSION['cf']."'";
	$sql2 = "UPDATE preferenze SET avviso_limite_mail = '0' WHERE ref_utente = '".$_SESSION['cf']."'";


	$result=$connessione->query($sql);
	if($result->num_rows>0){
			$row=$result->fetch_assoc();
		if($row['avviso_limite_mail'] == 0){

			$connessione->query($sql1);

			header("location: notifiche.php");

		} else if ($row['avviso_limite_mail'] == 1){

			$connessione->query($sql2);

			header("location: notifiche.php");
		}
	} else {
		header("location: notifiche.php?error=true");
	}

//CHIUDO CONNESSIONE
$connessione->close();



}



function avvisolimitewa(){

	 //VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
	 //CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);


    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }


//QUERY PER RICAVARE LE PREFERENZE
$sql = "SELECT * FROM preferenze WHERE ref_utente = '".$_SESSION['cf']."'";
  //QUERY PER AGGIORNARE LE PREFERENZE
	$sql1 = "UPDATE preferenze SET avv_limite_wa = '1' WHERE ref_utente = '".$_SESSION['cf']."'";
	$sql2 = "UPDATE preferenze SET avv_limite_wa = '0' WHERE ref_utente = '".$_SESSION['cf']."'";


	$result=$connessione->query($sql);
	if($result->num_rows>0){
			$row=$result->fetch_assoc();
		if($row['avv_limite_wa'] == 0){

			$connessione->query($sql1);

			header("location: notifiche.php");

		} else if ($row['avv_limite_wa'] == 1){

			$connessione->query($sql2);

			header("location: notifiche.php");
		}
	} else {
		header("location: notifiche.php?error=true");
	}

//CHIUDO CONNESSIONE
$connessione->close();

}


//**************************NOTIFICHE: ESTRATTO CONTO ***************************

function avvisomailec(){

	 //VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
	 //CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);


    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }


//QUERY PER RICAVARE LE PREFERENZE
	$sql = "SELECT * FROM preferenze WHERE ref_utente = '".$_SESSION['cf']."'";
  //QUERY PER AGGIORNARE LE PREFERENZE
	$sql1 = "UPDATE preferenze SET avviso_mail_ec = '1' WHERE ref_utente = '".$_SESSION['cf']."'";
	$sql2 = "UPDATE preferenze SET avviso_mail_ec = '0' WHERE ref_utente = '".$_SESSION['cf']."'";

	$result=$connessione->query($sql);
	if($result->num_rows>0){
			$row=$result->fetch_assoc();
		if($row['avviso_mail_ec'] == 0){

			$connessione->query($sql1);

			header("location: notifiche.php");

		} else if ($row['avviso_mail_ec'] == 1){

			$connessione->query($sql2);

			header("location: notifiche.php");
		}
	} else {
		header("location: notifiche.php?error=true");
	}

//CHIUDO CONNESSIONE
$connessione->close();



}





function avvisowaec(){

	//VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
	 //CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);


    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }


	//QUERY PER RICAVARE LE PREFERENZE
	$sql = "SELECT * FROM preferenze WHERE ref_utente = '".$_SESSION['cf']."'";
  //QUERY PER AGGIORNARE LE PREFERENZE
	$sql1 = "UPDATE preferenze SET avviso_wa_ec = '1' WHERE ref_utente = '".$_SESSION['cf']."'";
	$sql2 = "UPDATE preferenze SET avviso_wa_ec = '0' WHERE ref_utente = '".$_SESSION['cf']."'";

	$result=$connessione->query($sql);
	if($result->num_rows>0){
			$row=$result->fetch_assoc();
		if($row['avviso_wa_ec'] == 0){

			$connessione->query($sql1);

			header("location: notifiche.php");

		} else if ($row['avviso_wa_ec'] == 1){

			$connessione->query($sql2);

			header("location: notifiche.php");
		}
	} else {
		header("location: notifiche.php?error=true");
	}

//CHIUDO CONNESSIONE
$connessione->close();



}



//*************************NOTIFICHE: ERRORE PAGAMENTO*********************

function avvisoerroremail(){

	//VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
	 //CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);


    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }



	//QUERY PER RICAVARE LE PREFERENZE
$sql = "SELECT * FROM preferenze WHERE ref_utente = '".$_SESSION['cf']."'";
  //QUERY PER AGGIORNARE LE PREFERENZE
	$sql1 = "UPDATE preferenze SET avviso_errore_mail = '1' WHERE ref_utente = '".$_SESSION['cf']."'";
	$sql2 = "UPDATE preferenze SET avviso_errore_mail = '0' WHERE ref_utente = '".$_SESSION['cf']."'";

	$result=$connessione->query($sql);
	if($result->num_rows>0){
			$row=$result->fetch_assoc();
		if($row['avviso_errore_mail'] == 0){

			$connessione->query($sql1);

			header("location: notifiche.php");

		} else if ($row['avviso_errore_mail'] == 1){

			$connessione->query($sql2);

			header("location: notifiche.php");
		}
	} else {
		header("location: notifiche.php?error=true");
	}

//CHIUDO CONNESSIONE
$connessione->close();



}


function avvisoerrorewa(){

	 //VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
	 //CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);


    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }


//QUERY PER RICAVARE LE PREFERENZE
	$sql = "SELECT * FROM preferenze WHERE ref_utente = '".$_SESSION['cf']."'";
  //QUERY PER AGGIORNARE LE PREFERENZE
	$sql1 = "UPDATE preferenze SET avviso_errore_wa = '1' WHERE ref_utente = '".$_SESSION['cf']."'";
	$sql2 = "UPDATE preferenze SET avviso_errore_wa = '0' WHERE ref_utente = '".$_SESSION['cf']."'";

	$result=$connessione->query($sql);
	if($result->num_rows>0){
			$row=$result->fetch_assoc();
		if($row['avviso_errore_wa'] == 0){

			$connessione->query($sql1);

			header("location: notifiche.php");

		} else if ($row['avviso_errore_wa'] == 1){

			$connessione->query($sql2);

			header("location: notifiche.php");
		}
	} else {
		header("location: notifiche.php?error=true");
	}

//CHIUDO CONNESSIONE
$connessione->close();

}



//*************************NOTIFICHE: RICHIEDI DENARO*********************

function avvisorichiestamail(){

	//VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
	 //CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);


    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }


//QUERY PER RICAVARE LE PREFERENZE
	$sql = "SELECT * FROM preferenze WHERE ref_utente = '".$_SESSION['cf']."'";
  //QUERY PER AGGIORNARE LE PREFERENZE
	$sql1 = "UPDATE preferenze SET avviso_richiesta_mail = '1' WHERE ref_utente = '".$_SESSION['cf']."'";
	$sql2 = "UPDATE preferenze SET avviso_richiesta_mail = '0' WHERE ref_utente = '".$_SESSION['cf']."'";

	$result=$connessione->query($sql);
	if($result->num_rows>0){
			$row=$result->fetch_assoc();
		if($row['avviso_richiesta_mail'] == 0){

			$connessione->query($sql1);

			header("location: notifiche.php");

		} else if ($row['avviso_richiesta_mail'] == 1){

			$connessione->query($sql2);

			header("location: notifiche.php");
		}
	} else {
		header("location: notifiche.php?error=true");
	}

//CHIUDO CONNESSIONE
$connessione->close();



}


function avvisorichiestawa(){

	 //VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
	 //CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);


    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }


	//QUERY PER RICAVARE LE PREFERENZE
$sql = "SELECT * FROM preferenze WHERE ref_utente = '".$_SESSION['cf']."'";
  //QUERY PER AGGIORNARE PREFERENZE
	$sql1 = "UPDATE preferenze SET avviso_richiesta_wa = '1' WHERE ref_utente = '".$_SESSION['cf']."'";
	$sql2 = "UPDATE preferenze SET avviso_richiesta_wa = '0' WHERE ref_utente = '".$_SESSION['cf']."'";

	$result=$connessione->query($sql);
	if($result->num_rows>0){
			$row=$result->fetch_assoc();
		if($row['avviso_richiesta_wa'] == 0){

			$connessione->query($sql1);

			header("location: notifiche.php");

		} else if ($row['avviso_richiesta_wa'] == 1){

			$connessione->query($sql2);

			header("location: notifiche.php");
		}
	} else {
		header("location: notifiche.php?error=true");
	}


//CHIUDO CONNESSIONE
$connessione->close();



}

//*************************NOTIFICHE: RICEVI PAGAMENTO*********************

function avvisoricevimail(){

	//VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
	 //CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);


    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }


		//QUERY PER RICAVARE LE PREFERENZE
$sql = "SELECT * FROM preferenze WHERE ref_utente = '".$_SESSION['cf']."'";
  //QUERY AGGIORNARE PREFERENZE
	$sql1 = "UPDATE preferenze SET avviso_ricevi_mail = '1' WHERE ref_utente = '".$_SESSION['cf']."'";
	$sql2 = "UPDATE preferenze SET avviso_ricevi_mail = '0' WHERE ref_utente = '".$_SESSION['cf']."'";

	$result=$connessione->query($sql);
	if($result->num_rows>0){
			$row=$result->fetch_assoc();
		if($row['avviso_ricevi_mail'] == 0){

			$connessione->query($sql1);

			header("location: notifiche.php");

		} else if ($row['avviso_ricevi_mail'] == 1){

			$connessione->query($sql2);

			header("location: notifiche.php");
		}
	} else {
		header("location: notifiche.php?error=true");
	}

//CHIUDO CONNESSIONE
$connessione->close();



}


function avvisoriceviwa(){

	 //VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
	 //CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);


    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }


		//QUERY PER RICAVARE LE PREFERENZE
	$sql = "SELECT * FROM preferenze WHERE ref_utente = '".$_SESSION['cf']."'";
 //QUERY AGGIORNA PREFERENZE
	$sql1 = "UPDATE preferenze SET avviso_ricevi_wa = '1' WHERE ref_utente = '".$_SESSION['cf']."'";
	$sql2 = "UPDATE preferenze SET avviso_ricevi_wa = '0' WHERE ref_utente = '".$_SESSION['cf']."'";


	$result=$connessione->query($sql);
	if($result->num_rows>0){
			$row=$result->fetch_assoc();
		if($row['avviso_ricevi_wa'] == 0){

			$connessione->query($sql1);

			header("location: notifiche.php");

		} else if ($row['avviso_ricevi_wa'] == 1){

			$connessione->query($sql2);

			header("location: notifiche.php");
		}
	} else {
		header("location: notifiche.php?error=true");
	}

//CHIUDO CONNESSIONE
$connessione->close();



}

//******************RIMUOVI EMAIL*************************
function rimuovimail(){

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

	$email = $_GET['email'];

    // query per la modifica della tabella
    if (!$res=$connessione->query("DELETE FROM email WHERE email = '".$email."'")) {
		header("location:gestioneprofilo.php?error=true");

     }else{

				//reindirizzo a gestioneprofilo.php
				header("location:gestioneprofilo.php?rimuovimail=true");

}

//CHIUDO CONNESSIONE
$connessione->close();



}

//***************RIMUOVI INDIRIZZO******************************
function rimuoviind(){
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

	$ind = $_GET['indirizzo'];

    // query per la modifica della tabella
    if (!$res=$connessione->query("DELETE FROM indirizzi WHERE indirizzo = '".$ind."'")) {
		header("location:gestioneprofilo.php?error=true");

     }else{

				//reindirizzo a gestioneprofilo.php
				header("location:gestioneprofilo.php?rimuoviind=true");

	}

  //CHIUDO Connessione
  $connessione->close();



}

//******************RIMUOVI NUMERO TELEFONO****************************
function rimuovinumero(){
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

	$tel = $_GET['numero'];

    // query per la modifica della tabella
    if (!$res=$connessione->query("DELETE FROM telefono WHERE numero = '".$tel."'")) {
		header("location:gestioneprofilo.php?error=true");

     }else{

				//reindirizzo a gestioneprofilo.php
				header("location:gestioneprofilo.php?rimuovitel=true");


      }

      $connessione->close();
}


//**********************MODIFICA MAIL/ CAMBIA MAIL PRINCIPALE****************************
function modmail(){


		 //VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
		 //CONNESSIONE AL DBMS
		  $connessione = new mysqli($host, $user, $password,$db);


      //ERRORE DI CONNESSIONE
    if ($connessione->connect_error) {
    die("Connection failed: " . $connessione->connect_error);
    header("location:../erroreconnessione.html");
    }


	$email = $_GET['email2'];
	 // QUERY PER AGGIORNARE LA MAIL
	$sql= "UPDATE email SET email= '".$_POST['email']."' WHERE ref_utente='".$_SESSION['cf']."' and email='".$email."'";
  //QUERY PER MODIFICARE MAIL PRINCIPALE
	$sql1 = "UPDATE email SET principale = '' WHERE ref_utente = '".$_SESSION['cf']."' AND principale='Principale'";
	$sql2 = "UPDATE email SET principale = 'Principale' WHERE email= '".$_POST['email']."'";

	$result = $connessione->query($sql);

	if ($result) {
		if(isset($_POST["check1"])){

			$result1 = $connessione->query($sql1);

				if ($result1) {
					$result2 = $connessione->query($sql2);
					if($result2){
						header("location:gestioneprofilo.php?modmail=true");
					}else{
							header("location:gestioneprofilo.php?error=true");
					}
				} else {
					header("location:gestioneprofilo.php?error=true");
				}

			} else {
				header("location:gestioneprofilo.php?modmail=true");
			}
			} else {
				header("location:gestioneprofilo.php?error=true");
			}




//CHIUDO CONNESSIONE
$connessione->close();


}


//**********************MODIFICA INDIRIZZO/ CAMBIA PRINCIPALE****************************
function modind(){


		//VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
		 //CONNESSIONE AL DBMS
		  $connessione = new mysqli($host, $user, $password,$db);


      //ERRORE DI CONNESSIONE
    if ($connessione->connect_error) {
    die("Connection failed: " . $connessione->connect_error);
    header("location:../erroreconnessione.html");
    }


	$indirizzo = $_GET['indirizzo2'];
	 // QUERY PER AGGIORNARE L'INDIRIZZO
	$sql= "UPDATE indirizzi SET indirizzo = '".$_POST['ind']."' WHERE ref_utente='".$_SESSION['cf']."' and indirizzo='".$indirizzo."'";
  //QUERY PER MODIFICARE L'INDIRIZZO PRINCIPALE
	$sql1 = "UPDATE indirizzi SET principale = '' WHERE ref_utente = '".$_SESSION['cf']."' AND principale='Principale'";
	$sql2 = "UPDATE indirizzi SET principale = 'Principale' WHERE indirizzo = '".$_POST['ind']."'";

	$result = $connessione->query($sql);

	if ($result) {
		if(isset($_POST["check3"])){

			$result1 = $connessione->query($sql1);

				if ($result1) {
					$result2 = $connessione->query($sql2);
					if($result2){
						header("location:gestioneprofilo.php?modind=true");
					}else{
							header("location:gestioneprofilo.php?error=true");
					}
				} else {
					header("location:gestioneprofilo.php?error=true");
				}
			} else {
				header("location:gestioneprofilo.php?modind=true");
			}
			} else {
				header("location:gestioneprofilo.php?error=true");
			}




//CHIUDO CONNESSIONE
$connessione->close();


}

//**********************MODIFICA TELEFONO/ CAMBIA PRINCIPALE****************************
function modtel(){


		 //VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
		 //CONNESSIONE AL DBMS
		  $connessione = new mysqli($host, $user, $password,$db);


      //ERRORE DI CONNESSIONE
    if ($connessione->connect_error) {
    die("Connection failed: " . $connessione->connect_error);
    header("location:../erroreconnessione.html");
    }


	$numero = $_GET['numero2'];
	 // QUERY PER AGGIORNARE NUMERO TELEFONO
	$sql= "UPDATE telefono SET numero= '".$_POST['numero']."' WHERE ref_utente='".$_SESSION['cf']."' and numero='".$numero."'";
  //QUERY PER MODIFICARE NUMERO PRINCIPALE
	$sql1 = "UPDATE telefono SET principale = '' WHERE ref_utente = '".$_SESSION['cf']."' AND principale='Principale'";
	$sql2 = "UPDATE telefono SET principale = 'Principale' WHERE numero = '".$_POST['numero']."'";

	$result = $connessione->query($sql);

	if ($result) {

		if(isset($_POST["check2"])){

			$result1 = $connessione->query($sql1);

				if ($result1) {
					$result2 = $connessione->query($sql2);
					if($result2){
						header("location:gestioneprofilo.php?modtel=true");
					}else{
							header("location:gestioneprofilo.php?error=true");
					}
				} else {
					header("location:gestioneprofilo.php?error=true");
				}
			} else {
				header("location:gestioneprofilo.php?modtel=true");
			}
			} else {
				header("location:gestioneprofilo.php?error=true");
			}




//CHIUDO CONNESSIONE
$connessione->close();


}


//*******************************AGGIUNGI CARTA*********************************
function aggiungicarta(){

	//VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
 // CONNESSIONE AL DBMS
  $connessione = new mysqli($host, $user, $password,$db);


  //ERRORE DI CONNESSIONE
if ($connessione->connect_error) {
die("Connection failed: " . $connessione->connect_error);
header("location:../erroreconnessione.html");
}

    //QUERY PER INSERIRE CARTA NEL DB

	//supponiamo che ogni carta che viene inserita abbia saldo 1000 EUR per fare le simulazioni
    if (!$res=$connessione->query("INSERT INTO metodo_carta VALUES ('".$_SESSION['cf']."', '".$_POST['numerocarta']."', '".$_POST['intestatario']."', '".$_POST['scadenza']."', '".$_POST['ccv']."', '".$_POST['tipocarta']."', '1000.00')")) {

		header("location:aggcarta.php?error=true");

     }else{


				//reindirizzo a gestioneprofilo.php
				header("location:portafoglio.php?aggcarta=true");

}

//CHIUDO Connessione
$connessione->close();


}

//*******************************AGGIUNGI CONTO*********************************
function aggiungiconto(){

	//VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
 // CONNESSIONE AL DBMS
  $connessione = new mysqli($host, $user, $password,$db);


  //ERRORE DI CONNESSIONE
if ($connessione->connect_error) {
die("Connection failed: " . $connessione->connect_error);
header("location:../erroreconnessione.html");
}

    //QUERY PER INSERIRE CONTO NEL DB

	//supponiamo che ogni conto inserito abbia saldo 1000EURO giusto per fare le simulazioni
    if (!$res=$connessione->query("INSERT INTO metodo_iban VALUES ('".$_SESSION['cf']."', '".$_POST['iban']."', '".$_POST['banca']."', '".$_POST['intestatario']."', '1000.00')")) {

		header("location:aggconto.php?error=true");

     }else{


				//reindirizzo a gestioneprofilo.php
				header("location:portafoglio.php?aggconto=true");

      }

      //CHIUDO Connessione
      $connessione->close();

}

//*******************************MODIFICA METODO PREFERITO*********************************
function modmetodopreferito(){
	//VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
 // CONNESSIONE AL DBMS
  $connessione = new mysqli($host, $user, $password,$db);


  //ERRORE DI CONNESSIONE
if ($connessione->connect_error) {
die("Connection failed: " . $connessione->connect_error);
header("location:../erroreconnessione.html");
}

	$metodo = $_GET["metodo"];
    //QUERY PER AGGIORNARE METODO PREFERITO
    if (!$res=$connessione->query("UPDATE preferenze SET metodo_preferito = '".$metodo."' WHERE ref_utente='".$_SESSION['cf']."'")){
		header("location:portafoglio.php?error=true");

     }else{

				//reindirizzo a gestioneprofilo.php
				header("location:portafoglio.php?modmetpref=true");

      }

      //CHIUDO Connessione
      $connessione->close();

}

//*******************************ELIMINA CARTA*********************************
function eliminacarta(){
	//VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
 // CONNESSIONE AL DBMS
  $connessione = new mysqli($host, $user, $password,$db);


  //ERRORE DI CONNESSIONE
if ($connessione->connect_error) {
die("Connection failed: " . $connessione->connect_error);
header("location:../erroreconnessione.html");
}

	$carta = $_GET["numerocarta"];
    //QUERY PER CANCELLARE CARTA DAL DB
    if (!$res=$connessione->query("DELETE FROM metodo_carta WHERE ref_utente='".$_SESSION['cf']."' and numero_carta = '".$carta."'")){
		header("location:portafoglio.php?error=true");

     }else{


				//reindirizzo a gestioneprofilo.php
				header("location:portafoglio.php?rimuovimet=true");
      }

      //CHIUDO CONNESSIONE
      $connessione->close();
}

//*******************************ELIMINA CONTO*********************************
function eliminaconto(){
//VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
 // CONNESSIONE AL DBMS
  $connessione = new mysqli($host, $user, $password,$db);


  //ERRORE DI CONNESSIONE
if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
}


	$iban = $_GET["iban"];
    //QUERY PER CANCELLARE CONTO BANCARIO DAL DB
    if (!$res=$connessione->query("DELETE FROM metodo_iban WHERE ref_utente='".$_SESSION['cf']."' and iban = '".$iban."'")){
		header("location:portafoglio.php?error=true");

     }else{


				//reindirizzo a gestioneprofilo.php
				header("location:portafoglio.php?rimuovimet=true");

      }

      //CHIUDO Connessione
      $connessione->close();

}


//*******************************AGGIUNGI CHAT ID TELEGRAM*********************************
function aggiungichatid(){
//VARIABILI DI CONNESSIONE
   $host = "localhost";	// nome di host
   $user = "bee3b716298b4a";// username dell'utente in connessione
   $password = "bad87d03";// password dell'utente
   $db="heroku_16f3a281c2f1459";//nome database
 // CONNESSIONE AL DBMS
  $connessione = new mysqli($host, $user, $password,$db);


  //ERRORE DI CONNESSIONE
if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
}

    //QUERY PER CANCELLARE CONTO BANCARIO DAL DB
    if (!$res=$connessione->query("UPDATE preferenze SET chatid='".$_POST['chatid']."' WHERE ref_utente='".$_SESSION['cf']."'")){
		header("location:notifiche.php?error=true");

     }else{


				//reindirizzo a gestioneprofilo.php
				header("location:notifiche.php?success=true");

      }

      //CHIUDO Connessione
      $connessione->close();

}



?>
