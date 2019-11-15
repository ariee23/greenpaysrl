<?php

include("gestpagamenticontrol.php");

//cronjob che lo esegue ogni giorno per controllare quali pagamenti periodici fare


	//VARIABILI DI CONNESSIONE
$host = "localhost";
	$username = "bee3b716298b4a";
	$password = "bad87d03";
	$dbname = "heroku_16f3a281c2f1459";
	 // CONNESSIONE AL DBMS
	  $connessione = new mysqli($host, $user, $password,$db);


	  //ERRORE DI CONNESSIONE
	  if ($connessione->connect_error) {
		die("Connection failed: " . $connessione->connect_error);
	}

  //cerco i pagamenti periodici attivi
		$sql = "SELECT * FROM pagamento_periodico WHERE attivo=1";
		$result = $connessione->query($sql);

			if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()){
        $cod=$row["cod_pagamento"];
        $mittente=$row["mittente"];
        $destinatario=$row["destinatario"];
        $cifra=$row["cifra"];
        $metodo=$row["metodo"];
				$datainizio=strtotime($row["data_inizio"]);
        $periodicita=$row["periodicita"];
        $pagamentifatti=$row["pagamentifatti"];
        $pagamentidafare=$row["pagamentidafare"];
        $dataoggi=strtotime("today");
        $add=$pagamentifatti*$periodicita;
        $dataprossimopagamento= strtotime("+" .$add. "months", $datainizio);




      if($dataoggi==$dataprossimopagamento){

          //fai pagamento
          if(pagamentoperiodico($cod, $mittente, $destinatario, $cifra, $metodo)){

          //aumenta i pagamenti fatti
          $pagamentifatti += 1;
          $sql2 = "UPDATE pagamento_periodico SET pagamentifatti='".$pagamentifatti."' WHERE cod_pagamento='".$cod."'";
          $result2 = $connessione->query($sql2);

        } else{
          
        }
      } else {
        
      }

          if($pagamentifatti==$pagamentidafare){
            $sql3 = "UPDATE pagamento_periodico SET attivo=0 WHERE cod_pagamento='".$cod."'";
            $result3 = $connessione->query($sql3);

            if($result3){

            }else{
              
            }

          } else {
            
          }

      }

    } else {
      
    }








 ?>
