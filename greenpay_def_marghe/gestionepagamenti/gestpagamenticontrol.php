<?php

//Simona Raccuglia

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//CONTROL DI GESTIONE PAGAMENTI

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

//require '../vendor/autoload.php';

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';



//INIZIA LA SESSIONE
session_start();





//*****************************INVIA DENARO A PRIVATO********************************
function inviadenaroprivato(){
$host = "localhost";
$user = "bee3b716298b4a";
$password = "bad87d03";
$db = "heroku_16f3a281c2f1459";
 // CONNESSIONE AL DBMS
  $connessione = new mysqli($host, $user, $password,$db);

  //ERRORE DI CONNESSIONE
if ($connessione->connect_error) {
die("Connection failed: " . $connessione->connect_error);
header("location:../erroreconnessione.html");
}

  $cfdest=cfdest();
  $cod="";
  $data = date("Y-m-d");
  $imp=$_POST['importo'];
  $importo=str_replace(',','.',$imp);
  $metodo=$_POST['metodopag'];
  $note=$_POST['note'];
  $dest=$_POST["destinatario"];

//QUERY PER RICAVARE LA MAIL DELL'UTENTE
  $sql = "SELECT * FROM email WHERE ref_utente='".$_SESSION['cf']."' AND principale='Principale'";
  $result = $connessione->query($sql);
  $row=$result->fetch_assoc();
  $destmail=$row["email"];
  //QUERY PER RICAVARE LA MAIL DEL DESTINATARIO
  $sql = "SELECT * FROM email WHERE (ref_utente='".$cfdest."' AND principale='Principale')";
  $result = $connessione->query($sql);
  $row=$result->fetch_assoc();
  $destmail2=$row["email"];
//QUERY PER RICAVARE CHATID UTENTE
  $sql = "SELECT * FROM preferenze WHERE ref_utente='".$_SESSION['cf']."'";
  $result = $connessione->query($sql);
  $row=$result->fetch_assoc();
  $id1=$row["chatid"];
//QUERY PER RICAVARE CHATID DESTINATARIO
  $sql = "SELECT * FROM preferenze WHERE ref_utente='".$cfdest."'";
  $result = $connessione->query($sql);
  $row=$result->fetch_assoc();
  $id2=$row["chatid"];





		if(verificautente()){
			if(verificasaldo()){
				if(controllalimite()){
				$cod=codmovimento();

				//AGGIUNGO IL MOVIMENTO NEL DB

				$sql = "INSERT INTO movimenti VALUES('".$cod."', '".$_SESSION['cf']."', '".$cfdest."', '".$importo."', '".$data."', '".$metodo."', 'Pagamento', '".$note."', 0)";
				$sql2 = "INSERT INTO movimenti VALUES('".$cod."', '".$cfdest."', '".$_SESSION['cf']."', '".$importo."', '".$data."', '".$metodo."', 'Accredito', '".$note."', 0)";
				$result = $connessione->query($sql);
				$result2 = $connessione->query($sql2);

				if($result && $result2){
					if(aggiornasaldo()){
					    //CONTROLLO QUALI NOTIFICHE HA ATTIVATO L'UTENTE PER L'INVIO DENARO
					    if(controlloprefinviodenaro()==1){
							//entrambi
						inviodenaromail($destmail, $cod, $dest, $imp, $data, $metodo, $note);
		    				inviadenarotelegram($id1, $cod, $dest, $imp, $data, $metodo, $note);

						} else if (controlloprefinviodenaro()==2){
							//solo mail
						inviodenaromail($destmail, $cod, $dest, $imp, $data, $metodo, $note);

						} else if (controlloprefinviodenaro()==3){
							//solo telegram
						inviadenarotelegram($id1, $cod, $dest, $imp, $data, $metodo, $note);
						}


            //CONTROLLO QUALI NOTIFICHE HA ATTIVATO IL DESTINATARIO PER RICEVERE DENARO
            if(controlloprefricevi($cfdest)==1){
              //entrambi 
            ricevidenaromail($destmail2, $cod, $destmail, $imp, $data, $note);
	ricevidenarotelegram($id2, $cod, $destmail, $imp, $data, $note);	    

          } else if (controlloprefricevi($cfdest)==2){
              //solo mail
            ricevidenaromail($destmail2, $cod, $destmail, $imp, $data, $note);

          } else if (controlloprefricevi($cfdest)==3){
              //solo telegram
	ricevidenarotelegram($id2, $cod, $destmail, $imp, $data, $note);	  
            }


						header("location:../gestioneprofilo/riepilogo.php?success=true");

					} else {

            //CONTROLLO QUALI NOTIFICHE HA ATTIVATO L'UTENTE PER GLI ERRORI
            if(controllopreferrore()==1){
							//entrambi
						errorepagamentomail($destmail, $dest, $imp);
		    				errorepagamentotelegram($id1, $dest, $imp);
						} else if(controllopreferrore()==2){
							//solo mail
						errorepagamentomail($destmail, $dest, $imp);
						} else if(controllopreferrore()==3){
							//solo  telegram
		    				errorepagamentotelegram($id1, $dest, $imp);

						}

						header("location:invia.php?error3=true");
					}
				} else {

          //CONTROLLO QUALI NOTIFICHE HA ATTIVATO L'UTENTE PER GLI ERRORI
          if(controllopreferrore()==1){
							//entrambi
						errorepagamentomail($destmail, $dest, $imp);
		  				errorepagamentotelegram($id1, $dest, $imp);
						} else if(controllopreferrore()==2){
							//solo mail
						errorepagamentomail($destmail, $dest, $imp);
						} else if(controllopreferrore()==3){
							//solo  telegram
		  				errorepagamentotelegram($id1, $dest, $imp);

						}

          header("location:invia.php?error3=true");
				}


			} else{

        //CONTROLLO QUALI NOTIFICHE HA ATTIVATO L'UTENTE PER IL LIMITE SUPERATO
        if(controllopreflimite()==1){
					//entrambi
				limitemensilemail($destmail, $dest, $imp);
				limitesuperatotelegram($id1, $dest, $imp);
				} else if(controllopreflimite()==2){
					//solo mail
				limitemensilemail($destmail, $dest, $imp);
				} else if(controllopreflimite()==3){
					//solo telegram
				limitesuperatotelegram($id1, $dest, $imp);

				}

				header("location:invia.php?error2=true");
			}
		} else{

        //CONTROLLO QUALI NOTIFICHE HA ATTIVATO L'UTENTE PER I FONDI INSUFFICIENTI
        if(controllopreffondi()==1){
					//entrambi
				saldoinsufficientemail($destmail, $dest, $imp, $metodo);
				saldoinsufficientetelegram($id1, $dest, $imp, $metodo);
				} else if(controllopreffondi()==2){
					//solo mail
				saldoinsufficientemail($destmail, $dest, $imp, $metodo);
				} else if(controllopreffondi()==3){
					//solo telegram
				saldoinsufficientetelegram($id1, $dest, $imp, $metodo);

				}
				header("location:invia.php?error1=true");
		}

		}  else {
      //SE L'UTENTE NON ESISTE LO SI INVITA
			header("location:invitautente.php");
		}


//CHIUDO LA CONNESSIONE
$connessione->close();

}




//********OTTIENI CF DESTINATARIO*******************
function cfdest(){

//VARIABILI DI CONNESSIONE
$host = "localhost";
 $user = "bee3b716298b4a";
 $password = "bad87d03";
 $db = "heroku_16f3a281c2f1459";
 // CONNESSIONE AL DBMS
  $connessione = new mysqli($host, $user, $password,$db);

  $cfdest="";

  //ERRORE DI CONNESSIONE
if ($connessione->connect_error) {
die("Connection failed: " . $connessione->connect_error);
header("location:../erroreconnessione.html");
}


   //QUERY PER CERCARE IL DESTINATARIO TRAMITE EMAIL

	$sql = "SELECT * from email WHERE email = '".$_POST['destinatario']."'";
	$result = $connessione->query($sql);

	if ($result->num_rows > 0) {

		$row=$result->fetch_assoc();
		$cfdest=$row["ref_utente"];
    //CHIUDO LA CONNESSIONE
    $connessione->close();
		return $cfdest;


	} else {
		//CERCO  DESTINATARIO TRAMITE TELEFONO

		$sql = "SELECT * from telefono WHERE numero = '".$_POST['destinatario']."'";
		$result = $connessione->query($sql);

			if ($result->num_rows > 0) {
				$row=$result->fetch_assoc();
				$cfdest=$row["ref_utente"];
        //CHIUDO LA CONNESSIONE
        $connessione->close();
				return $cfdest;
			}

	}

}







//********************VERIFICA ESISTENZA UTENTE***************************

function verificautente(){

//VARIABILI DI CONNESSIONE
$host = "localhost";
 $user = "bee3b716298b4a";
 $password = "bad87d03";
 $db = "heroku_16f3a281c2f1459";
 // CONNESSIONE AL DBMS
  $connessione = new mysqli($host, $user, $password,$db);

  //ERRORE DI CONNESSIONE
if ($connessione->connect_error) {
die("Connection failed: " . $connessione->connect_error);
header("location:../erroreconnessione.html");
}


   //QUERY PER CERCARE IL DESTINATARIO TRAMITE EMAIL

	$sql = "SELECT * from email WHERE email = '".$_POST['destinatario']."'";
	$result = $connessione->query($sql);

	if ($result->num_rows > 0) {

    //CHIUDO LA CONNESSIONE
    $connessione->close();
		return true;


	} else {
		//CERCO TRAMITE TELEFONO

		$sql = "SELECT * from telefono WHERE numero = '".$_POST['destinatario']."'";
		$result = $connessione->query($sql);

			if ($result->num_rows > 0) {

        //CHIUDO LA CONNESSIONE
        $connessione->close();
				return true;

			} else {
        //IL DESTINATARIO NON ESISTE -- CHIUDO CONNESSIONE
				$connessione->close();
				return false;

			}

	}

}



//***********************VERIFICA SALDO E CONTROLLO SCADENZA CARTE DI CREDITO************************
function verificasaldo(){

//VARIABILI DI CONNESSIONE
$host = "localhost";
 $user = "bee3b716298b4a";
 $password = "bad87d03";
 $db = "heroku_16f3a281c2f1459";
	 // CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);

	  $importo=str_replace(',','.',$_POST['importo']);
	  $saldomittente=0;
	  $metodo=$_POST['metodopag'];
	  $sql="";
    $oggi=date("Y-m-d");

    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }

//QUERY PER OTTENERE IL SALDO IN BASE AL METODO DI PAGAMENTO USATO
		if($metodo=='gp'){

			$sql = "SELECT * from utente WHERE cf = '".$_SESSION['cf']."'";

		} else if(strlen($metodo)==16){
			$sql = "SELECT * from metodo_carta WHERE ref_utente = '".$_SESSION['cf']."' AND numero_carta = '".$metodo."'";


		} else if(strlen($metodo)==27){
			$sql = "SELECT * from metodo_iban WHERE ref_utente = '".$_SESSION['cf']."' AND iban = '".$metodo."'";

		}

		$result = $connessione->query($sql);

		if ($result->num_rows > 0) {

				$row = $result->fetch_assoc();
				$saldomittente=$row["saldo"];

        //CONTROLLO SCADENZA CARTA DI CREDITO

        if(strlen($metodo)==16){
          $scadenza=$row["scadenza_carta"];
          if($oggi>=$scadenza){
            return false;
          }
        }


			}

		if($saldomittente>=$importo){
      //SALDO SUFFICIENTE --CHIUDO CONNESSIONE
			$connessione->close();
			return true;
		} else {
      //SALDO INSUFFICIENTE -- CHIUDO CONNESSIONE
			$connessione->close();
			return false;
		}

}


//****************CODICE MOVIMENTO******************
function codmovimento(){

//VARIABILI DI CONNESSIONE
$host = "localhost";
 $user = "bee3b716298b4a";
 $password = "bad87d03";
 $db = "heroku_16f3a281c2f1459";
	 // CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);

	  $cod="";

    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }

    //CODICE PROGRESSIVO PER OGNI NUOVO MOVIMENTO
		$sql = "SELECT MAX(cod_movimento) FROM movimenti";
		$result = $connessione->query($sql);

			if ($result->num_rows > 0) {

				$row = $result->fetch_assoc();
				$cod=$row["MAX(cod_movimento)"]+1;
				$connessione->close();
				return $cod;

			} else {
        //PRIMO MOVIMENTO NEL DB HA CODICE 1
				$cod=1;
				$connessione->close();
				return $cod;
			}

}


//***********************AGGIORNA SALDO***********************************
function aggiornasaldo(){

//VARIABILI DI CONNESSIONE
$host = "localhost";
 $user = "bee3b716298b4a";
 $password = "bad87d03";
 $db = "heroku_16f3a281c2f1459";
	 // CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);

		$saldomittente="";
		$saldodestinatario="";
		$importo=str_replace(',','.',$_POST['importo']);
		$metodo=$_POST['metodopag'];


    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }

		//OTTENGO SALDO MITTENTE IN BASE AL METODO DI PAGAMENTO USATO
		$sql="";

		if($metodo=='gp'){

		$sql = "SELECT * FROM utente WHERE cf='".$_SESSION['cf']."'";

		} else if(strlen($metodo)==16){

			$sql = "SELECT * FROM metodo_carta WHERE ref_utente='".$_SESSION['cf']."' AND numero_carta='".$metodo."'";

		} else if(strlen($metodo)==27){

			$sql = "SELECT * FROM metodo_iban WHERE ref_utente='".$_SESSION['cf']."' AND iban='".$metodo."'";

		}

		$result = $connessione->query($sql);


			if ($result->num_rows > 0) {

				$row = $result->fetch_assoc();
        //SOTTRAGGO L'IMPORTO AL SALDO DEL MITTENTE E AGGIORNO
				$saldomittente=$row["saldo"]-$importo;

				if($metodo=='gp'){

				$sql = "UPDATE utente SET saldo = '".$saldomittente."' WHERE cf='".$_SESSION['cf']."'";

				} else if(strlen($metodo)==16){

					$sql = "UPDATE metodo_carta SET saldo = '".$saldomittente."' WHERE ref_utente='".$_SESSION['cf']."' AND numero_carta='".$metodo."'";

				} else if(strlen($metodo)==27){

					$sql = "UPDATE metodo_iban SET saldo = '".$saldomittente."' WHERE ref_utente='".$_SESSION['cf']."' AND iban='".$metodo."'";

				}


				$result = $connessione->query($sql);

					if ($result) {

						//AGGIORNA SALDO GREENPAY DEL DESTINATARIO TRAMITE EMAIL
						$sql = "SELECT * FROM utente join email on cf=ref_utente WHERE email ='".$_POST['destinatario']."'";
						$result = $connessione->query($sql);

						if ($result->num_rows > 0) {

							$row = $result->fetch_assoc();
              //SOMMO L'IMPORTO ALL'ATTUALE SALDO GREENPAY E AGGIORNO
							$saldodestinatario=$row["saldo"]+$importo;
							$cfdest = $row["cf"];

							$sql = "UPDATE utente SET saldo = '".$saldodestinatario."' WHERE cf ='".$cfdest."'";
							$result = $connessione->query($sql);

								if ($result) {
                  //CHIUDO CONNESSIONE
									$connessione->close();
									return true;


								} else {
                  //CHIUDO CONNESSIONE
									$connessione->close();
									return false;

								}


						} else {

						//AGGIORNA SALDO DESTINATARIO TRAMITE TELEFONO

						$sql = "SELECT * FROM utente join telefono on cf=ref_utente WHERE numero ='".$_POST['destinatario']."'";
						$result = $connessione->query($sql);

						if ($result->num_rows > 0) {

							$row = $result->fetch_assoc();
              //SOMMO L'IMPORTO AL SALDO GREENPAY ATTUALE DEL DESTINATARIO
							$saldodestinatario=$row["saldo"]+$importo;
							$cfdest = $row["cf"];

							$sql = "UPDATE utente SET saldo = '".$saldodestinatario."' WHERE cf ='".$cfdest."'";
							$result = $connessione->query($sql);

								if ($result) {
                  //CHIUDO CONNESSIONE
									$connessione->close();
									return true;


								} else {
                  //CHIUDO CONNESSIONE
									$connessione->close();
									return false;

								}


						}

						}



					} else {
            //CHIUDO CONNESSIONE
						$connessione->close();
						return false;

					}


			}


}








//*****************************INVIA DENARO A AZIENDA********************************
function inviadenarobusiness(){
//VARIABILI DI CONNESSIONE
$host = "localhost";
 $user = "bee3b716298b4a";
 $password = "bad87d03";
 $db = "heroku_16f3a281c2f1459";
 // CONNESSIONE AL DBMS
  $connessione = new mysqli($host, $user, $password,$db);

  //ERRORE DI CONNESSIONE
if ($connessione->connect_error) {
die("Connection failed: " . $connessione->connect_error);
header("location:../erroreconnessione.html");
}

  $cod="";
  $data = date("Y-m-d");
  $imp=$_POST['importo'];
  $importo=str_replace(',','.',$imp);
  $metodo=$_POST['metodopag'];
  $note=$_POST['note'];
  $azienda=$_POST['destinatario'];

//QUERY PER RICAVARE MAIL UTENTE
  $sql = "SELECT * FROM email WHERE ref_utente='".$_SESSION['cf']."' AND principale='Principale'";
  $result = $connessione->query($sql);
  $row=$result->fetch_assoc();
  $destmail=$row["email"];
	
//QUERY PER RICAVARE CHATID UTENTE
  $sql = "SELECT * FROM preferenze WHERE ref_utente='".$_SESSION['cf']."'";
  $result = $connessione->query($sql);
  $row=$result->fetch_assoc();
  $id=$row["chatid"];







		if(verificaazienda()){
			if(verificasaldo()){
				if(controllalimite()){
				$cod=codmovimento();

				//AGGIUNGO IL MOVIMENTO NEL DB

				$sql = "INSERT INTO movimenti VALUES('".$cod."', '".$_SESSION['cf']."', '".$azienda."', '".$importo."', '".$data."', '".$metodo."', 'Pagamento', '".$note."',0)";
				$result = $connessione->query($sql);
				

				if($result){
					if(aggiornasaldobusiness()){
            //CONTROLLO QUALI NOTIFICHE HA ATTIVATO L'UTENTE
            if(controlloprefinviodenaro()==1){
							//entrambi
						inviodenaromail($destmail, $cod, $azienda, $imp, $data, $metodo, $note);
		    				inviadenarotelegram($id,$cod, $azienda, $imp, $data, $metodo, $note);
						} else if(controlloprefinviodenaro()==2){
							//solo email
						inviodenaromail($destmail, $cod, $azienda, $imp, $data, $metodo, $note);
						} else if(controlloprefinviodenaro()==3){
							//solo telegram
		    				inviadenarotelegram($id,$cod, $azienda, $imp, $data, $metodo, $note);

						}

						header("location:../gestioneprofilo/riepilogo.php?success=true");

					} else {
            if(controllopreferrore()==1){
							//entrambi
						errorepagamentomail($destmail, $azienda, $imp);
		    				errorepagamentotelegram($id, $azienda, $imp);
						} else if(controllopreferrore()==2){
							//solo email
						errorepagamentomail($destmail, $azienda, $imp);
						} else if(controllopreferrore()==3){
							//solo telegram
						errorepagamentotelegram($id, $azienda, $imp);
						}

						header("location:invia2.php?error4=true");
					}
				} else {
          if(controllopreferrore()==1){
             //entrambi
           errorepagamentomail($destmail, $azienda, $imp);
		errorepagamentotelegram($id, $azienda, $imp);
           } else if(controllopreferrore()==2){
             //solo email
           errorepagamentomail($destmail, $azienda, $imp);
           } else if(controllopreferrore()==3){
             //solo telegram
		errorepagamentotelegram($id, $azienda, $imp);
           }

					 header("location:invia2.php?error4=true");
				}


			} else{
        if(controllopreflimite()==1){
					//entrambi --agg wa
				limitemensilemail($destmail, $azienda, $imp);
				limitesuperatotelegram($id, $azienda, $imp);
				} else if(controllopreflimite()==2){
					//solo email
				limitemensilemail($destmail, $azienda, $imp);
				} else if(controllopreflimite()==3){
				//solo telegram
				limitesuperatotelegram($id, $azienda, $imp);
				}

				header("location:invia2.php?error3=true");
			}
		} else {
      if(controllopreffondi()==1){
				//entrambi --agg wa
			saldoinsufficientemail($destmail, $azienda, $imp, $metodo);
	      		saldoinsufficientetelegram($id, $azienda, $imp, $metodo);
			} else if(controllopreffondi()==2){
				//solo mail
			saldoinsufficientemail($destmail, $azienda, $imp, $metodo);
			} else if(controllopreffondi()==3){
				//solo telegram
	      		saldoinsufficientetelegram($id, $azienda, $imp, $metodo);
			}
			header("location:invia2.php?error1=true");
		}


	} else {

			header("location:invia2.php?error2=true");
		}

    //CHIUDO LA CONNESSIONE
    $connessione->close();

}

//*****************************VERIFICA ESISTENZA AZIENDA********************************
function verificaazienda(){

//VARIABILI DI CONNESSIONE
$host = "localhost";
 $user = "bee3b716298b4a";
 $password = "bad87d03";
 $db = "heroku_16f3a281c2f1459";
 // CONNESSIONE AL DBMS
  $connessione = new mysqli($host, $user, $password,$db);



			//QUERY PER CERCARE L'AZIENDA NEL DB

			$sql = "SELECT * FROM esercizio_commerciale WHERE nome='".$_POST['destinatario']."'";
			$result = $connessione->query($sql);

				if($result->num_rows>0){
          //TROVATA --CHIUDO LA CONNESSIONE
          $connessione->close();
          return true;

					} else {
            //NON TROVATA --CHIUDO LA CONNESSIONE
            $connessione->close();
						return false;

					}

}


//*********************AGGIORNA SALDO BUSINESS**************************


function aggiornasaldobusiness(){

//VARIABILI DI CONNESSIONE
$host = "localhost";
 $user = "bee3b716298b4a";
 $password = "bad87d03";
 $db = "heroku_16f3a281c2f1459";
	 // CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);

		$saldomittente="";
		$saldodestinatario="";
		$importo=str_replace(',','.',$_POST['importo']);
		$metodo=$_POST['metodopag'];


    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }

		//RICAVO SALDO MITTENTE IN BASE AL METODO DI PAGAMENTO
		$sql="";

		if($metodo=='gp'){

		$sql = "SELECT * FROM utente WHERE cf='".$_SESSION['cf']."'";

		} else if(strlen($metodo)==16){

			$sql = "SELECT * FROM metodo_carta WHERE ref_utente='".$_SESSION['cf']."' AND numero_carta='".$metodo."'";

		} else if(strlen($metodo)==27){

			$sql = "SELECT * FROM metodo_iban WHERE ref_utente='".$_SESSION['cf']."' AND iban='".$metodo."'";

		}

		$result = $connessione->query($sql);


			if ($result->num_rows > 0) {

				$row = $result->fetch_assoc();
        //SOTTRAGGO L'IMPORTO AL SALDO MITTENTE E AGGIORNO IL DB
				$saldomittente=$row["saldo"]-$importo;

				if($metodo=='gp'){

				$sql = "UPDATE utente SET saldo = '".$saldomittente."' WHERE cf='".$_SESSION['cf']."'";

				} else if(strlen($metodo)==16){

					$sql = "UPDATE metodo_carta SET saldo = '".$saldomittente."' WHERE ref_utente='".$_SESSION['cf']."' AND numero_carta='".$metodo."'";

				} else if(strlen($metodo)==27){

					$sql = "UPDATE metodo_iban SET saldo = '".$saldomittente."' WHERE ref_utente='".$_SESSION['cf']."' AND iban='".$metodo."'";

				}


				$result = $connessione->query($sql);

					if ($result) {


						//AGGIORNA SALDO DESTINATARIO AZIENDA
						$sql = "SELECT * FROM esercizio_commerciale WHERE nome ='".$_POST['destinatario']."'";
						$result = $connessione->query($sql);

						if ($result->num_rows > 0) {

							$row = $result->fetch_assoc();
              //SOMMO IMPORTO AL SALDO GREENPAY DELL'AZIENDA E AGGIORNO IL DB
							$saldodestinatario=$row["saldo"]+$importo;

							$sql = "UPDATE esercizio_commerciale SET saldo = '".$saldodestinatario."' WHERE nome ='".$POST_['destinatario']."'";
							$result = $connessione->query($sql);

								if ($result) {
                  //CHIUDO CONNESSIONE
									$connessione->close();
									return true;


								} else {
                  //CHIUDO CONNESSIONE
									$connessione->close();
									return false;

								}


						}





					} else {
            //CHIUDO CONNESSIONE
						$connessione->close();
						return false;

					}


			}


}

//************************INVITA UTENTE**************************************
function invitautente(){

$mail = new PHPMailer(TRUE);


$destinatario=$_POST["destinatario"];

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
   $mail->addAddress($destinatario);

   // Set the subject.
   $mail->Subject = 'Iscriviti a GreenPay!';

   // Set the mail message body.
  $mail->isHTML(TRUE);
  $mail->Body = '<html><p>Ciao, uno dei nostri utenti ti ha invitato a iscriverti su GreenPay!<br> Clicca su <a href="http://greenpay-app.herokuapp.com/autenticazione/RegistrazioneBoundary.php">questo link</a> per iscriverti e iniziare ad utilizzare i nostri servizi!:)</p></html>';
  $mail->AltBody = 'Iscriviti a GreenPay';




   // Send the mail.
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

	header("location:../gestioneprofilo/riepilogo.php?success4=true");


}

//****************************************CONTROLLA LIMITE MENSILE******************************
function controllalimite(){

//VARIABILI DI CONNESSIONE
$host = "localhost";
 $user = "bee3b716298b4a";
 $password = "bad87d03";
 $db = "heroku_16f3a281c2f1459";
 // CONNESSIONE AL DBMS
  $connessione = new mysqli($host, $user, $password,$db);

  //ERRORE DI CONNESSIONE
if ($connessione->connect_error) {
die("Connection failed: " . $connessione->connect_error);
header("location:../erroreconnessione.html");
}


  //DATA INIZIO È IL PRIMO DEL MESE CORRENTE
  $datainizio = date("Y")."-".date("m")."-1";
  $datafine="";
  //DATA FINE È L'ULTIMO GIORNO DEL MESE CORRENTE
  if(date("m")=='11'||date("m")=='04'||date("m")=='06'||date("m")=='09'){
  $datafine = date("Y")."-".date('m')."-30";
  }else if(date("m")=='02' && date("L")){
  $datafine = date("Y")."-".date('m')."-29";
  } if(date("m")=='02' && !date("L") ){
  $datafine = date("Y")."-".date('m')."-28";
  } else{
	  $datafine = date("Y")."-".date('m')."-31";
  }

  $soldispesi=0;
  $importo=str_replace(',','.',$_POST["importo"]);
  $limitemensile=0;


			//QUERY PER RICAVARE TUTTI I PAGAMENTI FATTI DALL'UTENTE NEL MESE CORRENTE

			$sql = "SELECT * FROM movimenti WHERE mittente='".$_SESSION['cf']."' AND data>='".$datainizio."' AND data<= '".$datafine."'";
			$result = $connessione->query($sql);

				if($result->num_rows>0){
					while($row=$result->fetch_assoc()){
            //PER OGNI PAGAMENTO FATTO QUESTO MESE AGGIUNGO L'IMPORTO AL TOTALE DEI SOLDI SPESI
						$soldispesi += $row["cifra"];
					}

				} else {
          //NESSUN PAGAMENTO EFFETTUATO QUESTO MESE
					$soldispesi=0;

				}

        //RICAVO IL LIMITE MENSILE IMPOSTATO DALL'UTENTE
				$sql = "SELECT * FROM preferenze WHERE ref_utente='".$_SESSION['cf']."'";
				$result = $connessione->query($sql);

				if($result->num_rows>0){
					$row=$result->fetch_assoc();
					$limitemensile= $row["limite_mensile"];


				} else {

					return false;

				}

				if($limitemensile==0){
          //SE IL LIMITE È 0 SIGNIFICA CHE L'UTENTE NON HA IMPOSTATO LIMITI
					return true;
				} else if($soldispesi+$importo>$limitemensile){
            //LIMITE SUPERATO
						return false;
						} else{
							return true;
						}



}

//***************************RICARICA CONTO********************************
function ricaricaconto(){
//VARIABILI DI CONNESSIONE
$host = "localhost";
 $user = "bee3b716298b4a";
 $password = "bad87d03";
 $db = "heroku_16f3a281c2f1459";
	 // CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);

    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }

	$data=date("Y-m-d");
	$imp=$_POST['importo'];
	$importo = str_replace(',','.',$imp);
  $dest="Conto GreenPay";
//QUERY PER RICAVARE EMAIL UTENTE
  $sql = "SELECT * FROM email WHERE ref_utente='".$_SESSION['cf']."' AND principale='Principale'";
  $result = $connessione->query($sql);
  $row=$result->fetch_assoc();
  $destmail=$row["email"];
//QUERY PER RICAVARE CHATID UTENTE
 $sql = "SELECT * FROM preferenze WHERE ref_utente='".$_SESSION['cf']."'";
  $result = $connessione->query($sql);
  $row=$result->fetch_assoc();
  $id=$row["chatid"];


			if(verificasaldo()){
				$cod=codmovimento();

				//AGGIUNGO IL MOVIMENTO NEL DB

				$sql = "INSERT INTO movimenti VALUES('".$cod."', '".$_SESSION['cf']."', '".$_SESSION['cf']."', '".$importo."', '".$data."', '".$_POST['metodopag']."', 'Ricarica GreenPay', '', 0)";
				$result = $connessione->query($sql);

				if($result){
					if(aggiornasaldoricarica()){
						header("location:../gestioneprofilo/riepilogo.php?success2=true");
					} else {
				    //CONTROLLO QUALI NOTIFICHE HA ATTIVATO L'UTENTE
				    if(controllopreferrore()==1){
							//entrambi
						errorepagamentomail($destmail, $dest, $imp);
					    	errorepagamentotelegram($id, $dest, $imp);
						} else if(controllopreferrore()==2){
							//solo email
						errorepagamentomail($destmail, $dest, $imp);
						} else if(controllopreferrore()==3){
						//solo telegram
					    	errorepagamentotelegram($id, $dest, $imp);
						}

						header("location:ricaricaconto.php?error3=true");
					}
				} else {
          if(controllopreferrore()==1){
             //entrambi
           errorepagamentomail($destmail, $dest, $imp);
	errorepagamentotelegram($id, $dest, $imp);
           } else if(controllopreferrore()==2){
             //solo email
           errorepagamentomail($destmail, $dest, $imp);
           } else if(controllopreferrore()==3){
           //solo telegram
	errorepagamentotelegram($id, $dest, $imp);
           }

					       header("location:ricaricaconto.php?error3=true");
				}

		} else {
      if(controllopreffondi()==1){
				//entrambi
			saldoinsufficientemail($destmail, $dest, $imp, $metodo);
	      		saldoinsufficientetelegram($id, $dest, $imp, $metodo);
			} else if(controllopreffondi()==2){
				//solo mail
			saldoinsufficientemail($destmail, $dest, $imp, $metodo);
			} else if(controllopreffondi()==3){
				//solo telegram
	      		saldoinsufficientetelegram($id, $dest, $imp, $metodo);
			}

			header("location:ricaricaconto.php?error2=true");
		}

    //CHIUDO LA CONNESSIONE
    $connessione->close();



}

//*********************AGGIORNA SALDO RICARICA**************************


function aggiornasaldoricarica(){

//VARIABILI DI CONNESSIONE
$host = "localhost";
 $user = "bee3b716298b4a";
 $password = "bad87d03";
 $db = "heroku_16f3a281c2f1459";
	 // CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);

		$saldometodo="";
		$saldogreenpay="";
		$importo=str_replace(',','.',$_POST['importo']);
		$metodo=$_POST['metodopag'];


    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }

		//RICAVO SALDO MITTENTE IN BASE AL METODO DI PAGAMENTO
		$sql="";

		if(strlen($metodo)==16){

			$sql = "SELECT * FROM metodo_carta WHERE ref_utente='".$_SESSION['cf']."' AND numero_carta='".$metodo."'";

		} else if(strlen($metodo)==27){

			$sql = "SELECT * FROM metodo_iban WHERE ref_utente='".$_SESSION['cf']."' AND iban='".$metodo."'";

		}

		$result = $connessione->query($sql);


			if ($result->num_rows > 0) {

				$row = $result->fetch_assoc();
        //SOTTRAGGO L'IMPORTO AL SALDO E AGGIORNO IL DB
				$saldometodo=$row["saldo"]-$importo;

				 if(strlen($metodo)==16){

					$sql = "UPDATE metodo_carta SET saldo = '".$saldometodo."' WHERE ref_utente='".$_SESSION['cf']."' AND numero_carta='".$metodo."'";

				} else if(strlen($metodo)==27){

					$sql = "UPDATE metodo_iban SET saldo = '".$saldometodo."' WHERE ref_utente='".$_SESSION['cf']."' AND iban='".$metodo."'";

				}


				$result = $connessione->query($sql);

					if ($result) {


            //RICAVO SALDO GREENPAY
            $sql = "SELECT * FROM  utente WHERE cf='".$_SESSION['cf']."'";
            $result = $connessione->query($sql);
            $row=$result->fetch_assoc();

						$saldogreenpay=$row["saldo"]+$importo;


							$sql = "UPDATE utente SET saldo = '".$saldogreenpay."' WHERE cf='".$_SESSION['cf']."'";
							$result = $connessione->query($sql);

								if ($result) {
                  //CHIUDO CONNESSIONE
									$connessione->close();
									return true;


								} else {
                  //CHIUDO CONNESSIONE
									$connessione->close();
									return false;

								}






					} else {
            //CHIUDO CONNESSIONE
						$connessione->close();
						return false;

					}


			}


}

//***************************INVIA RICHIESTA DENARO********************************
function inviarichiesta(){
//VARIABILI DI CONNESSIONE
$host = "localhost";
 $user = "bee3b716298b4a";
 $password = "bad87d03";
 $db = "heroku_16f3a281c2f1459";
	 // CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);

    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }

	$cod=codrichiesta();
	$data=date("Y-m-d");
	$imp=$_POST['importo'];
	$importo = str_replace(',','.',$imp);
	$destinatario=cfdest();
	$dest=$_POST["destinatario"];

  //QUERY PER RICAVARE MAIL utente
  $sql = "SELECT * FROM email WHERE ref_utente='".$_SESSION['cf']."' AND principale='Principale'";
    $result = $connessione->query($sql);
    $row=$result->fetch_assoc();
    $destmail=$row["email"];
  //QUERY PER RICAVARE CHATID UTENTE
  $sql = "SELECT * FROM preferenze WHERE ref_utente='".$_SESSION['cf']."'";
    $result = $connessione->query($sql);
    $row=$result->fetch_assoc();
    $id=$row["chatid"];



				//AGGIUNGO RICHIESTA NEL DB
				//L'ULTIMO VALORE INDICA CHE LA RICHIESTA NON HA ANCORA RICEVUTO RISPOSTA (1: NO RISPOSTA 2:RICHIESTA ACCETTATA 3:RICHIESTA RIFIUTATA)
			if(verificautente()){
				$sql = "INSERT INTO richieste VALUES('".$cod."', '".$_SESSION['cf']."', '".$destinatario."', '".$importo."', '".$data."', '".$_POST['note']."', 1)";
				$result = $connessione->query($sql);

				if($result){
          //CONTROLLO QUALI NOTIFICHE HA ATTIVATO L'UTENTE
          if(controlloprefrichiesta()==1){
						//entrambi
					richiedidenaromail($destmail, $dest, $imp);
		  			richiedidenarotelegram($id, $dest, $imp);
					} else if(controlloprefrichiesta()==2){
						//solo mail
					richiedidenaromail($destmail, $dest, $imp);
					} else if(controlloprefrichiesta()==3){
						//solo telegram
					richiedidenarotelegram($id, $dest, $imp);
					}

					header("location:../gestioneprofilo/riepilogo.php?success3=true");
					} else {
						header("location:richiedi.php?error=true");
					}

			} else {
				header("location:invitautente.php");
			}

      //CHIUDO LA CONNESSIONE
      $connessione->close();

}


//****************CODICE RICHIESTA******************
function codrichiesta(){

//VARIABILI DI CONNESSIONE
$host = "localhost";
 $user = "bee3b716298b4a";
 $password = "bad87d03";
 $db = "heroku_16f3a281c2f1459";
	 // CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);

	  $cod="";

    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }

    //CODICE PROGRESSIVO LE RICHIESE
		$sql = "SELECT MAX(cod_richiesta) FROM richieste";
		$result = $connessione->query($sql);

			if ($result->num_rows > 0) {

				$row = $result->fetch_assoc();
				$cod=$row["MAX(cod_richiesta)"]+1;
        //CHIUDO CONNESSIONE
				$connessione->close();
				return $cod;

			} else {
        //PRIMA RICHIESTA NEL DB HA CODICE 1 --CHIUDO CONNESSIONE
				$cod=1;
				$connessione->close();
				return $cod;
			}

}

//****************RIFIUTA RICHIESTA******************
function rifiutarichiesta(){

//VARIABILI DI CONNESSIONE
$host = "localhost";
 $user = "bee3b716298b4a";
 $password = "bad87d03";
 $db = "heroku_16f3a281c2f1459";
	 // CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);

	  $cod=$_GET["cod"];

    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }

    //AGGIORNO LA RICHIESTA NEL DB COME RIFIUTATA
		$sql = "UPDATE richieste SET risposta=3 WHERE cod_richiesta='".$cod."'";
		$result = $connessione->query($sql);

			if ($result) {
        //CHIUDO LA CONNESSIONE
        $connessione->close();
				header("location:richieste.php?success1=true");

			} else {
        //CHIUDO LA CONNESSIONE
        $connessione->close();
				header("location:richieste.php?error=true");
			}

}


//****************ACCETTA RICHIESTA******************
function accettarichiesta(){

  //VARIABILI DI CONNESSIONE
$host = "localhost";
   $user = "bee3b716298b4a";
   $password = "bad87d03";
   $db = "heroku_16f3a281c2f1459";
	 // CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);


    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }

  $cfdest=cfdest();
  $codmov="";
  $data = date("Y-m-d");
  $imp=$_POST['importo'];
  $importo=str_replace(',','.',$imp);
  $metodo=$_POST['metodopag'];
  $note=$_POST['note'];
  $codrichiesta=$_GET['codrichiesta'];
  $dest=$_POST["destinatario"];

  //MAIL utente
  $sql = "SELECT * FROM email WHERE ref_utente='".$_SESSION['cf']."' AND principale='Principale'";
  $result = $connessione->query($sql);
  $row=$result->fetch_assoc();
  $destmail=$row["email"];
	

  //CHATID utente
  $sql = "SELECT * FROM preferenze WHERE ref_utente='".$_SESSION['cf']."'";
  $result = $connessione->query($sql);
  $row=$result->fetch_assoc();
  $id1=$row["chatid"];



  //MAIL DESTINATARIO A CUI INVIARE AVVISI
  $sql = "SELECT * FROM email WHERE ref_utente='".$cfdest."' AND principale='Principale'";
  $result = $connessione->query($sql);
  $row=$result->fetch_assoc();
  $destmail2=$row["email"];
	
 //CHATID DESTINATARIO
  $sql = "SELECT * FROM preferenze WHERE ref_utente='".$cfdest."'";
  $result = $connessione->query($sql);
  $row=$result->fetch_assoc();
  $id2=$row["chatid"];




			if(verificasaldo()){
				if(controllalimite()){

				$codmov=codmovimento();

				//AGGIUNGO IL MOVIMENTO NEL DB

				$sql = "INSERT INTO movimenti VALUES('".$codmov."', '".$_SESSION['cf']."', '".$cfdest."', '".$importo."', '".$data."', '".$metodo."', 'Pagamento', '".$note."', 0)";
				$result = $connessione->query($sql);
				$sql2 = "INSERT INTO movimenti VALUES('".$codmov."', '".$cfdest."', '".$_SESSION['cf']."', '".$importo."', '".$data."', '".$metodo."', 'Accredito', '".$note."', 0)";
				$result2 = $connessione->query($sql2);

				if($result && $result2){
					if(aggiornasaldo()){
            //AGGIORNO LO STATO DELLA RICHIESTA COME ACCETTATA
						$sql = "UPDATE richieste SET risposta = 2 WHERE cod_richiesta='".$codrichiesta."'";
						$result = $connessione->query($sql);

							if ($result) {
                //CONTROLLO QUALI NOTIFICHE HA ATTIVATO L'UTENTE
                if(controlloprefinviodenaro()==1){
									//entrambi --agg wa
								inviodenaromail($destmail, $codmov, $dest, $imp, $data, $metodo, $note);
								inviadenarotelegram($id1,$codmov, $dest, $imp, $data, $metodo, $note);

								} else  if(controlloprefinviodenaro()==2){
									//solo mail
								inviodenaromail($destmail, $codmov, $dest, $imp, $data, $metodo, $note);

								} else if(controlloprefinviodenaro()==3){
									//solo telegram
								inviadenarotelegram($id1,$codmov, $dest, $imp, $data, $metodo, $note);

								}

                //CONTROLLO QUALI NOTIFICHE HA ATTIVATO IL DESTINATARIO PER RICEVERE DENARO
                if(controlloprefricevi($cfdest)==1){
                  //entrambi
                ricevidenaromail($destmail2, $codmov, $destmail, $imp, $data, $note);
		ricevidenarotelegram($id2, $codmov, $destmail, $imp, $data, $note);

              } else if (controlloprefricevi($cfdest)==2){
                  //solo mail
                ricevidenaromail($destmail2, $codmov, $destmail, $imp, $data, $note);

              } else if (controlloprefricevi($cfdest)==3){
                  //solo telegram
		ricevidenarotelegram($id2, $codmov, $destmail, $imp, $data, $note);
                }



								header("location:richieste.php?success2=true");

							} else {
								header("location:richieste.php?error=true");

							}
					} else {
            if(controllopreferrore()==1){
              //entrambi
              errorepagamentomail($destmail, $dest, $imp);
	errorepagamentotelegram($id1, $dest, $imp);
            } else if(controllopreferrore()==2){
              //solo mail
              errorepagamentomail($destmail, $dest, $imp);
            } else if(controllopreferrore()==3){
             //solo telegram
	errorepagamentotelegram($id1, $dest, $imp);
            }


						header("location:richieste.php?error=true");
					}
				} else {
          if(controllopreferrore()==1){
            //entrambi
            errorepagamentomail($destmail, $dest, $imp);
	errorepagamentotelegram($id1, $dest, $imp);
          } else if(controllopreferrore()==2){
            //solo mail
            errorepagamentomail($destmail, $dest, $imp);
          } else if(controllopreferrore()==3){
           //solo telegram
	errorepagamentotelegram($id1, $dest, $imp);
          }

					header("location:richieste.php?error=true");
				}


			} else{
        if(controllopreflimite()==1){
					//entrambi
				limitemensilemail($destmail, $dest, $imp);
				limitesuperatotelegram($id1, $dest, $imp);
				} else if(controllopreflimite()==2){
					//solo mail
				limitemensilemail($destmail, $dest, $imp);
				} else if(controllopreflimite()==3){
					//solo telegram
				limitesuperatotelegram($id1, $dest, $imp);

				}

				header("location:confermarichiesta.php?error2=true");
			}
		} else{
      if(controllopreffondi()==1){
        //entrambi
      saldoinsufficientemail($destmail, $dest, $imp, $metodo);
	saldoinsufficientetelegram($id1, $dest, $imp, $metodo);
	
      } else 	if(controllopreffondi()==2){
        //solo mail
      saldoinsufficientemail($destmail, $dest, $imp, $metodo);
      } else 	if(controllopreffondi()==3){
      //solo telegram
	      saldoinsufficientetelegram($id1, $dest, $imp, $metodo);
      }
				header("location:confermarichiesta.php?error1=true");
		}

    //CHIUDO LA CONNESSIONE
    $connessione->close();



}


//************************NOTIFICHE: SALDO INSUFFICIENTE**************************************
function saldoinsufficientemail($destmail, $dest, $imp, $metodo){


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
   $mail->Subject = 'Saldo insufficiente.';

   // Set the mail message body.
  $mail->isHTML(TRUE);
  $mail->Body = "<html><p>Gentile Cliente, la informiamo che non è stato possibile effettuare il pagamento di " .$imp." EUR all'utente " .$dest. ", in quanto il saldo del metodo di pagamento selezionato (" .$metodo. ") è insufficiente, oppure se sta utilizzando una carta di credito potrebbe essere scaduta. Per favore, riprovi con un altro metodo di pagamento.</p></html>";
  $mail->AltBody = 'Saldo insufficiente';


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


//************************NOTIFICHE: INVIO DENARO**************************************
function inviodenaromail($destmail, $cod, $dest, $imp, $data, $metodo, $note){


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
   $mail->Subject = 'Pagamento inviato!';

   // Set the mail message body.
  $mail->isHTML(TRUE);
  $mail->Body = "<html><p>Gentile cliente, la informiamo che il suo pagamento (cod: ".$cod. ") è avvenuto con successo. Di seguito i dettagli del pagamento:<br>Destinatario: " .$dest. "<br>Importo: " .$imp. "EUR <br>Data: " .$data. "<br>Metodo di pagamento: " .$metodo. "<br>Note: " .$note. "</p></html>";
  $mail->AltBody = 'Pagamento inviato';




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


//************************NOTIFICHE: LIMITE MENSILE SUPERATO**************************************
function limitemensilemail($destmail, $dest, $imp){


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
   $mail->Subject = 'Limite mensile superato.';

   // Set the mail message body.
  $mail->isHTML(TRUE);
  $mail->Body = "<html><p>Gentile Cliente, la informiamo che non è stato possibile effettuare il pagamento di " .$imp." EUR all'utente " .$dest. ", in quanto ha superato il limite mensile da lei stabilito. Modifichi o rimuova il limite mensile per effettuare il pagamento.</p></html>";
  $mail->AltBody = 'Limite mensile superato';




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


//************************NOTIFICHE: ERRORE PAGAMENTO**************************************
function errorepagamentomail($destmail, $dest, $imp){


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
   $mail->Subject = 'Errore pagamento';

   // Set the mail message body.
  $mail->isHTML(TRUE);
  $mail->Body = "<html><p>Gentile Cliente, la informiamo che non è stato possibile effettuare il pagamento di " .$imp." EUR all'utente " .$dest. ", in quanto si è verificato un errore. La preghiamo di riprovare.</p></html>";
  $mail->AltBody = 'Errore pagamento';




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


//************************NOTIFICHE: RICHIEDI DENARO**************************************
function richiedidenaromail($destmail, $dest, $imp){


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
   $mail->Subject = 'Richiesta di denaro.';

   // Set the mail message body.
  $mail->isHTML(TRUE);
  $mail->Body = "<html><p>Gentile Cliente, la informiamo che la richiesta di " .$imp. " EUR all'utente " .$dest. ", da lei effettuata è avvenuta con successo.</p></html>";
  $mail->AltBody = 'Richiesta di denaro';




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


//************************NOTIFICHE: RICEVI DENARO**************************************
function ricevidenaromail($destmail, $cod, $mitt, $imp, $data, $note){


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
   $mail->Subject = 'Denaro Ricevuto';

   // Set the mail message body.
  $mail->isHTML(TRUE);
  $mail->Body = "<html><p>Gentile cliente, la informiamo che ha ricevuto un pagamento (cod: ".$cod. ") sul suo conto GreenPay. Di seguito i dettagli del pagamento:<br>Mittente: " .$mitt. "<br>Importo: " .$imp. "EUR <br>Data: " .$data. "<br>Note: " .$note. "</p></html>";
  $mail->AltBody = 'Denaro Ricevuto';



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

//******************************CONTROLLO PREFERENZE: INVIO DENARO ********************************
function controlloprefinviodenaro(){

  //VARIABILI DI CONNESSIONE
$host = "localhost";
   $user = "bee3b716298b4a";
   $password = "bad87d03";
   $db = "heroku_16f3a281c2f1459";
	 // CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);

		$mail=0;
		$wa=0;

	  //ERRORE DI CONNESSIONE
	  if ($connessione->connect_error) {
		die("Connection failed: " . $connessione->connect_error);
	}

		$sql = "SELECT * FROM preferenze WHERE ref_utente='".$_SESSION['cf']."'";
		$result = $connessione->query($sql);

			if ($result->num_rows > 0) {

				$row = $result->fetch_assoc();
				$mail=$row["avviso_mail_pag"];
				$wa=$row["avviso_wa_pag"];
				$connessione->close();

			}

			if($mail==1 && $wa==1){
				return 1;
			} else if($mail==1 && $wa==0){
				return 2;
			} else if($mail==0 && $wa==1){
				return 3;
			} else {
				return 0;
			}
}

//******************************CONTROLLO PREFERENZE: LIMITE SPESA ********************************
function controllopreflimite(){

  //VARIABILI DI CONNESSIONE
   $host = "localhost";
   $user = "bee3b716298b4a";
   $password = "bad87d03";
   $db = "heroku_16f3a281c2f1459";
	 // CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);

		$mail=0;
		$wa=0;

	  //ERRORE DI CONNESSIONE
	  if ($connessione->connect_error) {
		die("Connection failed: " . $connessione->connect_error);
	}

		$sql = "SELECT * FROM preferenze WHERE ref_utente='".$_SESSION['cf']."'";
		$result = $connessione->query($sql);

			if ($result->num_rows > 0) {

				$row = $result->fetch_assoc();
				$mail=$row["avviso_limite_mail"];
				$wa=$row["avv_limite_wa"];
				$connessione->close();

			}

			if($mail==1 && $wa==1){
				return 1;
			} else if($mail==1 && $wa==0){
				return 2;
			} else if($mail==0 && $wa==1){
				return 3;
			} else {
				return 0;
			}
}

//******************************CONTROLLO PREFERENZE: FONDI INSUFFICIENTI ********************************
function controllopreffondi(){

  //VARIABILI DI CONNESSIONE
   $host = "localhost";
   $user = "bee3b716298b4a";
   $password = "bad87d03";
   $db = "heroku_16f3a281c2f1459";
	 // CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);

		$mail=0;
		$wa=0;

	  //ERRORE DI CONNESSIONE
	  if ($connessione->connect_error) {
		die("Connection failed: " . $connessione->connect_error);
	}

		$sql = "SELECT * FROM preferenze WHERE ref_utente='".$_SESSION['cf']."'";
		$result = $connessione->query($sql);

			if ($result->num_rows > 0) {

				$row = $result->fetch_assoc();
				$mail=$row["avviso_fondi_mail"];
				$wa=$row["avviso_fondi_wa"];
				$connessione->close();

			}
			if($mail==1 && $wa==1){
				return 1;
			} else if($mail==1 && $wa==0){
				return 2;
			} else if($mail==0 && $wa==1){
				return 3;
			} else {
				return 0;
			}
}


//******************************CONTROLLO PREFERENZE: ERRORE PAGAMENTO********************************
function controllopreferrore(){

  //VARIABILI DI CONNESSIONE
   $host = "localhost";
   $user = "bee3b716298b4a";
   $password = "bad87d03";
   $db = "heroku_16f3a281c2f1459";
	 // CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);

		$mail=0;
		$wa=0;

	  //ERRORE DI CONNESSIONE
	  if ($connessione->connect_error) {
		die("Connection failed: " . $connessione->connect_error);
	}

		$sql = "SELECT * FROM preferenze WHERE ref_utente='".$_SESSION['cf']."'";
		$result = $connessione->query($sql);

			if ($result->num_rows > 0) {

				$row = $result->fetch_assoc();
				$mail=$row["avviso_errore_mail"];
				$wa=$row["avviso_errore_wa"];
				$connessione->close();

			}

			if($mail==1 && $wa==1){
				return 1;
			} else if($mail==1 && $wa==0){
				return 2;
			} else if($mail==0 && $wa==1){
				return 3;
			} else {
				return 0;
			}
}

//******************************CONTROLLO PREFERENZE: RICHIESTA DENARO ********************************
function controlloprefrichiesta(){

  //VARIABILI DI CONNESSIONE
$host = "localhost";
   $user = "bee3b716298b4a";
   $password = "bad87d03";
   $db = "heroku_16f3a281c2f1459";
	 // CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);

		$mail=0;
		$wa=0;

	  //ERRORE DI CONNESSIONE
	  if ($connessione->connect_error) {
		die("Connection failed: " . $connessione->connect_error);
	}

		$sql = "SELECT * FROM preferenze WHERE ref_utente='".$_SESSION['cf']."'";
		$result = $connessione->query($sql);

			if ($result->num_rows > 0) {

				$row = $result->fetch_assoc();
				$mail=$row["avviso_richiesta_mail"];
				$wa=$row["avviso_richiesta_wa"];
				$connessione->close();

			}

			if($mail==1 && $wa==1){
				return 1;
			} else if($mail==1 && $wa==0){
				return 2;
			} else if($mail==0 && $wa==1){
				return 3;
			} else {
				return 0;
			}
}



//******************************CONTROLLO PREFERENZE: RICEVI DENARO********************************
function controlloprefricevi($cf){

//VARIABILI DI CONNESSIONE
$host = "localhost";
 $user = "bee3b716298b4a";
 $password = "bad87d03";
 $db = "heroku_16f3a281c2f1459";
	 // CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);

		$mail=0;
		$wa=0;

    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }

		$sql = "SELECT * FROM preferenze WHERE ref_utente='".$cf."'";
		$result = $connessione->query($sql);

			if ($result->num_rows > 0) {

				$row = $result->fetch_assoc();
				$mail=$row["avviso_ricevi_mail"];
				$wa=$row["avviso_ricevi_wa"];
				$connessione->close();

			}

			if($mail==1 && $wa==1){
				return 1;
			} else if($mail==1 && $wa==0){
				return 2;
			} else if($mail==0 && $wa==1){
				return 3;
			} else {
				return 0;
			}
}



//****************PAGAMENTO PERIODICO******************
function pagamentoperiodico($codperiodico, $mittente, $destinatario, $cifra, $metodo){

//VARIABILI DI CONNESSIONE
$host = "localhost";
 $user = "bee3b716298b4a";
 $password = "bad87d03";
 $db = "heroku_16f3a281c2f1459";
 // CONNESSIONE AL DBMS
  $connessione = new mysqli($host, $user, $password,$db);

  //ERRORE DI CONNESSIONE
if ($connessione->connect_error) {
die("Connection failed: " . $connessione->connect_error);
header("location:../erroreconnessione.html");
}

  $cod="";
  $data = date("Y-m-d");

  //MAIL UTENTE
  $sql = "SELECT * FROM email WHERE ref_utente='".$mittente."' AND principale='Principale'";
    $result = $connessione->query($sql);
    $row=$result->fetch_assoc();
    $destmail=$row["email"];
//CHATID UTENTE
  $sql = "SELECT * FROM preferenze WHERE ref_utente='".$mittente."' AND principale='Principale'";
    $result = $connessione->query($sql);
    $row=$result->fetch_assoc();
    $id=$row["chatid"];


			if(verificasaldoperiodico($mittente, $cifra, $metodo)){
				if(controllalimiteperiodico($mittente, $cifra)){

				$cod=codmovimento();

				//AGGIUNGO IL MOVIMENTO NEL DB

				$sql = "INSERT INTO movimenti VALUES('".$cod."', '".$mittente."', '".$destinatario."', '".$cifra."', '".$data."', '".$metodo."', 'Pagamento Periodico', '', '".$codperiodico."')";
				$result = $connessione->query($sql);

				if($result){
					if(aggiornasaldobusperiodico($mittente, $destinatario, $cifra, $metodo)){
            //CONTROLLO QUALI NOTIFICHE HA ATTIVATO L'UTENTE
            if(controlloprefinviodenaro()==1){
  							//entrambi --agg wa
  						inviodenaromail($destmail, $cod, $destinatario, $cifra, $data, $metodo, '');
		    				inviadenarotelegram($id,$cod, $destinatario, $cifra, $data, $metodo, '');
  						} else if(controlloprefinviodenaro()==2){
  							//solo email
  						inviodenaromail($destmail, $cod, $destinatario, $cifra, $data, $metodo, '');
  						} else if(controlloprefinviodenaro()==3){
  							//solo telegram
						inviadenarotelegram($id,$cod, $destinatario, $cifra, $data, $metodo, '');
  						}

						return true;

					} else {
            if(controllopreferrore()==1){
  							//entrambi
  						errorepagamentomail($destmail, $destinatario, $cifra);
		    				errorepagamentotelegram($id, $destinatario, $cifra);
  						} else if(controllopreferrore()==2){
  							//solo email
  						errorepagamentomail($destmail, $destinatario, $cifra);
  						} else if(controllopreferrore()==3){
  							//solo telegram
						errorepagamentotelegram($id, $destinatario, $cifra);

  						}

							return false;


					}
				} else {
          if(controllopreferrore()==1){
							//entrambi
						errorepagamentomail($destmail, $destinatario, $cifra);
		  				errorepagamentotelegram($id, $destinatario, $cifra);
						} else if(controllopreferrore()==2){
							//solo email
						errorepagamentomail($destmail, $destinatario, $cifra);
						} else if(controllopreferrore()==3){
							//solo telegram
						errorepagamentotelegram($id, $destinatario, $cifra);
						}	
						return false;
				}


			} else{
        if(controllopreflimite()==1){
  					//entrambi
  				limitemensilemail($destmail, $destinatario, $cifra);
				limitesuperatotelegram($id, $destinatario, $cifra);
  				} else if(controllopreflimite()==2){
  					//solo email
  				limitemensilemail($destmail, $destinatario, $cifra);
  				} else if(controllopreflimite()==3){
  				//solo telegram
				limitesuperatotelegram($id, $destinatario, $cifra);

  				}


				return false;

			}
		} else {
      if(controllopreffondi()==1){
				//entrambi
			saldoinsufficientemail($destmail, $destinatario, $cifra, $metodo);
	      		saldoinsufficientetelegram($id, $destinatario, $cifra, $metodo);
			} else if(controllopreffondi()==2){
				//solo mail
			saldoinsufficientemail($destmail, $destinatario, $cifra, $metodo);
			} else if(controllopreffondi()==3){
				//solo telegram
	      		saldoinsufficientetelegram($id, $destinatario, $cifra, $metodo);
			}

			return false;
		}


    //CHIUDO LA CONNESSIONE
    $connessione->close();


}


//***********************VERIFICA SALDO PERIODICO************************
function verificasaldoperiodico($mittente,$importo, $metodo){
//VARIABILI DI CONNESSIONE
$host = "localhost";
 $user = "bee3b716298b4a";
 $password = "bad87d03";
 $db = "heroku_16f3a281c2f1459";
	 // CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);

	  $saldomittente=0;
	  $sql="";

    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }

  //RICAVO IL SALDO IN BASE AL METODO DI PAGAMENTO
		if($metodo=='gp'){

			$sql = "SELECT * from utente WHERE cf = '".$mittente."'";

		} else if(strlen($metodo)==16){
			$sql = "SELECT * from metodo_carta WHERE ref_utente = '".$mittente."' AND numero_carta = '".$metodo."'";


		} else if(strlen($metodo)==27){
			$sql = "SELECT * from metodo_iban WHERE ref_utente = '".$mittente."' AND iban = '".$metodo."'";

		}

		$result = $connessione->query($sql);

		if ($result->num_rows > 0) {

				$row = $result->fetch_assoc();
				$saldomittente=$row["saldo"];

			}

		if($saldomittente>=$importo){
      //SALDO SUFFICIENTE
			$connessione->close();
			return true;
		} else {
      //SALDO INSUFFICIENTE
			$connessione->close();
			return false;
		}

}

//****************************************CONTROLLA LIMITE PERIODICO******************************
function controllalimiteperiodico($mittente, $importo){

//VARIABILI DI CONNESSIONE
$host = "localhost";
 $user = "bee3b716298b4a";
 $password = "bad87d03";
 $db = "heroku_16f3a281c2f1459";
 // CONNESSIONE AL DBMS
  $connessione = new mysqli($host, $user, $password,$db);

  //ERRORE DI CONNESSIONE
if ($connessione->connect_error) {
die("Connection failed: " . $connessione->connect_error);
header("location:../erroreconnessione.html");
}

//DATA INIZIO È IL PRIMO GIORNO DEL MESE CORRENTE
  $datainizio = date("Y")."-".date("m")."-1";
  $datafine="";
  //DATA FINE È L'ULTIMO GIORNO DEL MESE CORRENTE
  if(date("m")=='11'||date("m")=='04'||date("m")=='06'||date("m")=='09'){
  $datafine = date("Y")."-".date('m')."-30";
  }else if(date("m")=='02' && date("L")){
  $datafine = date("Y")."-".date('m')."-29";
  } if(date("m")=='02' && !date("L") ){
  $datafine = date("Y")."-".date('m')."-28";
  } else{
	  $datafine = date("Y")."-".date('m')."-31";
  }

  $soldispesi=0;
  $limitemensile=0;


			//RICAVO TUTTI I PAGAMENTI EFFETTUATI DALL'UTENTE NEL MESE CORRENTE

			$sql = "SELECT * FROM movimenti WHERE mittente='".$mittente."' AND (tipo_op='Pagamento' OR tipo_op='Pagamento Periodico') AND data>='".$datainizio."' AND data<= '".$datafine."'";
			$result = $connessione->query($sql);

				if($result->num_rows>0){
					while($row=$result->fetch_assoc()){
            //PER OGNI PAGAMENTO AGGIUNGO L'IMPORTO AL TOTALE DEI SOLDI SPESI
						$soldispesi += $row["cifra"];
					}

				} else {
          //NESSUN PAGAMENTO EFFETTUATO QUESTO MESE
					$soldispesi=0;

				}

        //RICAVO LIMITE MENSILE

  			$sql = "SELECT * FROM preferenze WHERE ref_utente='".$mittente."'";
  			$result = $connessione->query($sql);
        $row=$result->fetch_assoc();


				if($row[limite_mensile]==0){
          //SE IL LIMITE È 0 SIGNIFICA CHE L'UTENTE NON HA IMPOSTATO NESSUN LIMITE
					return true;
				} else if($soldispesi+$importo>$row[limite_mensile]){
          //LIMITE SUPERATO
						return false;
						} else{
              //LIMITE NON SUPERATO
							return true;
						}

            //CHIUDO LA CONNESSIONE
            $connessione->close();



}

//*********************AGGIORNA SALDO BUSINESS PERIODICO**************************


function aggiornasaldobusperiodico($mittente, $destinatario, $importo, $metodo){

//VARIABILI DI CONNESSIONE
$host = "localhost";
 $user = "bee3b716298b4a";
 $password = "bad87d03";
 $db = "heroku_16f3a281c2f1459";
	 // CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);

		$saldomittente="";
		$saldodestinatario="";


    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }

		//RICAVO SALDO MITTENTE IN BASE AL METODO DI PAGAMENTO
		$sql="";

		if($metodo=='gp'){

		$sql = "SELECT * FROM utente WHERE cf='".$mittente."'";

		} else if(strlen($metodo)==16){

			$sql = "SELECT * FROM metodo_carta WHERE ref_utente='".$mittente."' AND numero_carta='".$metodo."'";

		} else if(strlen($metodo)==27){

			$sql = "SELECT * FROM metodo_iban WHERE ref_utente='".$mittente."' AND iban='".$metodo."'";

		}

		$result = $connessione->query($sql);


			if ($result->num_rows > 0) {
        //SOTTRAGGO L'IMPORTO E AGGIORNO IL DB
				$row = $result->fetch_assoc();
				$saldomittente=$row["saldo"]-$importo;

				if($metodo=='gp'){

				$sql = "UPDATE utente SET saldo = '".$saldomittente."' WHERE cf='".$mittente."'";

				} else if(strlen($metodo)==16){

					$sql = "UPDATE metodo_carta SET saldo = '".$saldomittente."' WHERE ref_utente='".$mittente."' AND numero_carta='".$metodo."'";

				} else if(strlen($metodo)==27){

					$sql = "UPDATE metodo_iban SET saldo = '".$saldomittente."' WHERE ref_utente='".$mittente."' AND iban='".$metodo."'";

				}


				$result = $connessione->query($sql);

					if ($result) {


						//RICAVO SALDO DESTINATARIO AZIENDA
						$sql = "SELECT * FROM esercizio_commerciale WHERE nome ='".$destinatario."'";
						$result = $connessione->query($sql);

						if ($result->num_rows > 0) {

							$row = $result->fetch_assoc();
							$saldodestinatario=$row["saldo"]+$importo;

              //SOMMO L'IMPORTO E AGGIORNO IL DB
							$sql = "UPDATE esercizio_commerciale SET saldo = '".$saldodestinatario."' WHERE nome ='".$destinatario."'";
							$result = $connessione->query($sql);

								if ($result) {
									$connessione->close();
									return true;


								} else {
									$connessione->close();
									return false;

								}


						}





					} else {
						$connessione->close();
						return false;

					}


			}


}





//*******************PRIMO PAGAMENTO PERIODICO*****************************
function primoperiodico(){
//VARIABILI DI CONNESSIONE
$host = "localhost";
 $user = "bee3b716298b4a";
 $password = "bad87d03";
 $db = "heroku_16f3a281c2f1459";
// CONNESSIONE AL DBMS
$connessione = new mysqli($host, $user, $password,$db);

//ERRORE DI CONNESSIONE
if ($connessione->connect_error) {
die("Connection failed: " . $connessione->connect_error);
header("location:../erroreconnessione.html");
}


$cod="";
$oggi = date("Y-m-d");
$datainizio=$_POST["inizio"];
$imp=$_POST["importo"];
$importo=str_replace(',','.',$imp);
$metodo=$_POST["metodopag"];
$note=$_POST["note"];
$azienda=$_POST["destinatario"];

$codperiodico=codperiodico();

//MAIL UTENTE
$sql = "SELECT * FROM email WHERE ref_utente='".$_SESSION['cf']."' AND principale='Principale'";
$result = $connessione->query($sql);
$row=$result->fetch_assoc();
$destmail=$row["email"];

//CHATID UTENTE
$sql = "SELECT * FROM preferenze WHERE ref_utente='".$_SESSION['cf']."'";
$result = $connessione->query($sql);
$row=$result->fetch_assoc();
$id=$row["chatid"];








if(verificaazienda()){
if($oggi==$datainizio){
	//aggiungi pagamento periodico nel db
	if($_POST["num"]!= ""){
	$sql = "INSERT INTO pagamento_periodico VALUES('".$codperiodico."', '".$_SESSION['cf']."', '".$azienda."', '".$_POST["periodo"]."', '".$importo."', '".$datainizio."', '".$_POST["num"]."', 1, '".$metodo."', 1)";
	}else{

		$sql = "INSERT INTO pagamento_periodico VALUES('".$codperiodico."', '".$_SESSION['cf']."', '".$azienda."', '".$_POST["periodo"]."', '".$importo."', '".$datainizio."', 0, 1, '".$metodo."', 1)";
	}

	$result = $connessione->query($sql);

	if($result){

	//fai il primo pagamento
	if(verificaazienda()){
		if(verificasaldo()){
			if(controllalimite()){
			$cod=codmovimento();

			//AGGIUNGO IL MOVIMENTO NEL DB

			$sql = "INSERT INTO movimenti VALUES('".$cod."', '".$_SESSION['cf']."', '".$azienda."', '".$importo."', '".$oggi."', '".$metodo."', 'Pagamento Periodico', '".$note."', '".$codperiodico."')";
			$result = $connessione->query($sql);

			if($result){
				if(aggiornasaldobusiness()){
          //CONTROLLO NOTIFICHE ATTIVATE DALL'UTENTE
          if(controlloprefinviodenaro()==1){
						//entrambi
					inviodenaromail($destmail, $cod, $azienda, $imp, $oggi, $metodo, $note);
		  			inviadenarotelegram($id,$cod, $azienda, $imp, $oggi, $metodo, $note);
					} else if(controlloprefinviodenaro()==2){
						//solo email
						inviodenaromail($destmail, $cod, $azienda, $imp, $oggi, $metodo, $note);
					} else if(controlloprefinviodenaro()==3){
						//solo telegram
					inviadenarotelegram($id,$cod, $azienda, $imp, $oggi, $metodo, $note);
					}

					header("location:../gestioneprofilo/riepilogo.php?success=true");

				} else {
          if(controllopreferrore()==1){
						//entrambi
					errorepagamentomail($destmail, $azienda, $imp);
		  			errorepagamentotelegram($id, $azienda, $imp);
					} else if(controllopreferrore()==2){
						//solo email
					errorepagamentomail($destmail, $azienda, $imp);
					} else if(controllopreferrore()==3){
						//solo telegram
					errorepagamentotelegram($id, $azienda, $imp);
					}

					header("location:pagperiodico.php?error4=true");
				}
			} else {
        if(controllopreferrore()==1){
           //entrambi
         errorepagamentomail($destmail, $azienda, $imp);
	errorepagamentotelegram($id, $azienda, $imp);
         } else if(controllopreferrore()==2){
           //solo email
         errorepagamentomail($destmail, $azienda, $imp);
         } else if(controllopreferrore()==3){
           //solo telegram
	errorepagamentotelegram($id, $azienda, $imp);
         }

				 header("location:pagperiodico.php?error4=true");
			}


		} else{
      if(controllopreflimite()==1){
				//entrambi
			limitemensilemail($destmail, $azienda, $imp);
	      		limitesuperatotelegram($id, $azienda, $imp);
			} else if(controllopreflimite()==2){
				//solo email
			limitemensilemail($destmail, $azienda, $imp);
			} else if(controllopreflimite()==3){
			//solo telegram
	      		limitesuperatotelegram($id, $azienda, $imp);
			}

			header("location:pagperiodico.php?error3=true");
		}
	} else {
    if(controllopreffondi()==1){
  			//entrambi
  		saldoinsufficientemail($destmail, $azienda, $imp, $metodo);
	    	saldoinsufficientetelegram($id, $azienda, $imp, $metodo);
	    	
  		} else if(controllopreffondi()==2){
  			//solo mail
  		saldoinsufficientemail($destmail, $azienda, $imp, $metodo);
  		} else if(controllopreffondi()==3){
  			//solo telegram
	    	saldoinsufficientetelegram($id, $azienda, $imp, $metodo);
  		}

		header("location:pagperiodico.php?error1=true");
	}


} else {

		header("location:pagperiodico.php?error2=true");
	}

} else {
  if(controllopreferrore()==1){
		 //entrambi
	 errorepagamentomail($destmail, $azienda, $imp);
	  errorepagamentotelegram($id, $azienda, $imp);
	 } else if(controllopreferrore()==2){
		 //solo email
	 errorepagamentomail($destmail, $azienda, $imp);
	 } else if(controllopreferrore()==3){
		 //solo telegram
	  errorepagamentotelegram($id, $azienda, $imp);

	 }

	header("location:pagperiodico.php?error4=true");
}



} else {
	//se la data di inizio non è oggi aggiungo solo il pagamento periodico nel db
	if($_POST["num"] != ""){
	$sql = "INSERT INTO pagamento_periodico VALUES('".$codperiodico."', '".$_SESSION['cf']."', '".$azienda."', '".$_POST["periodo"]."', '".$importo."', '".$datainizio."', '".$_POST["num"]."', 0, '".$metodo."', 1)";
	} else {
	$sql = "INSERT INTO pagamento_periodico VALUES('".$codperiodico."', '".$_SESSION['cf']."', '".$azienda."', '".$_POST["periodo"]."', '".$importo."', '".$datainizio."', 0, 0, '".$metodo."', 1)";
	}

	$result = $connessione->query($sql);

	if($result){

		header("location:../gestioneprofilo/riepilogo.php?success5=true");

	} else {
		header("location:pagperiodico.php?error4=true");
	}

}
} else {
	//l'azienda non esiste
	header("location:pagperiodico.php?error2=true");
}

//CHIUDO LA CONNESSIONE
$connessione->close();


}


//****************CODICE PAGAMENTO PERIODICO*****************
function codperiodico(){

	//VARIABILI DI CONNESSIONE
$host = "localhost";
   $user = "bee3b716298b4a";
   $password = "bad87d03";
   $db = "heroku_16f3a281c2f1459";
	 // CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);

	  $cod="";

    //ERRORE DI CONNESSIONE
  if ($connessione->connect_error) {
  die("Connection failed: " . $connessione->connect_error);
  header("location:../erroreconnessione.html");
  }

    //CODICE PROGRESSIVO PER I PAGAMENTI PERIODICI
		$sql = "SELECT MAX(cod_pagamento) FROM pagamento_periodico";
		$result = $connessione->query($sql);

			if ($result->num_rows > 0) {

				$row = $result->fetch_assoc();
				$cod=$row["MAX(cod_pagamento)"]+1;
				$connessione->close();
				return $cod;

			} else {
        //SE È IL PRIMO PAGAMENTO PERIODICO NEL DB IL CODICE È 1
				$cod=1;
				$connessione->close();
				return $cod;
			}

}

//*****************NOTIFICHE: INVIA DENARO TELEGRAM**************************
function inviadenarotelegram($id,$cod, $dest, $imp, $data, $metodo, $note){
  
         $msg="Gentile Cliente, la informiamo che il suo pagamento (cod: ".$cod.") è avvenuto con successo. Di seguito i dettagli del pagamento:\nDestinatario: " .$dest. "\nImporto: " .$imp. " EUR\nData: " .$data. "\nMetodo di pagamento: " .$metodo. "\nNote: " .$note;
	
  	$apiToken = "975599523:AAEhdrbDLmLaRXahlCoqiJAoQdp8bRPoqWo";
	
	      

		$data = [
		    'chat_id' => $id,
		    'text' => $msg
		];

	$response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data) );
  
        
  
        

}

//*****************NOTIFICHE: SALDO INSUFFICIENTE TELEGRAM**************************
function saldoinsufficientetelegram($id, $dest, $imp, $metodo){
  
         $msg="Gentile Cliente, la informiamo che non è stato possibile effettuare il pagamento di " .$imp." EUR all'utente " .$dest. ", in quanto il saldo del metodo di pagamento selezionato (" .$metodo. ") è insufficiente, oppure se sta utilizzando una carta di credito potrebbe essere scaduta. Per favore, riprovi con un altro metodo di pagamento.";
	
  	$apiToken = "975599523:AAEhdrbDLmLaRXahlCoqiJAoQdp8bRPoqWo";
	
	      

		$data = [
		    'chat_id' => $id,
		    'text' => $msg
		];

	$response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data) );
  
        
     

}

//*****************NOTIFICHE: LIMITE SUPERATO TELEGRAM**************************
function limitesuperatotelegram($id, $dest, $imp){
  
         $msg="Gentile Cliente, la informiamo che non è stato possibile effettuare il pagamento di " .$imp." EUR all'utente " .$dest. ", in quanto ha superato il limite mensile da lei stabilito. Modifichi o rimuova il limite mensile per effettuare il pagamento.";
	
  	$apiToken = "975599523:AAEhdrbDLmLaRXahlCoqiJAoQdp8bRPoqWo";
	
	      

		$data = [
		    'chat_id' => $id,
		    'text' => $msg
		];

	$response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data) );
  
        
     

}


//*****************NOTIFICHE: ERRORE PAGAMENTO TELEGRAM**************************
function errorepagamentotelegram($id, $dest, $imp){
  
         $msg="Gentile Cliente, la informiamo che non è stato possibile effettuare il pagamento di " .$imp." EUR all'utente " .$dest. ", in quanto si è verificato un errore. La preghiamo di riprovare.";
	
  	$apiToken = "975599523:AAEhdrbDLmLaRXahlCoqiJAoQdp8bRPoqWo";
	
	      

		$data = [
		    'chat_id' => $id,
		    'text' => $msg
		];

	$response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data) );
  
        
     

}



//*****************NOTIFICHE: RICHIEDI DENARO TELEGRAM**************************
function richiedidenarotelegram($id, $dest, $imp){
  
         $msg="Gentile Cliente, la informiamo che la richiesta di " .$imp. " EUR all'utente " .$dest. ", da lei effettuata è avvenuta con successo.";
	
  	$apiToken = "975599523:AAEhdrbDLmLaRXahlCoqiJAoQdp8bRPoqWo";
	
	      

		$data = [
		    'chat_id' => $id,
		    'text' => $msg
		];

	$response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data));
  
        
     

}

//*****************NOTIFICHE: RICEVI DENARO TELEGRAM**************************
function ricevidenarotelegram($id, $cod, $mitt, $imp, $data, $note){
  
         $msg="Gentile cliente, la informiamo che ha ricevuto un pagamento (cod: ".$cod. ") sul suo conto GreenPay. Di seguito i dettagli del pagamento:\nMittente: " .$mitt. "\nImporto: " .$imp. "EUR\nData: " .$data. "\nNote: " .$note;
	
  	$apiToken = "975599523:AAEhdrbDLmLaRXahlCoqiJAoQdp8bRPoqWo";
	
	      

		$data = [
		    'chat_id' => $id,
		    'text' => $msg
		];

	$response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data));
  
        
     

}









?>
