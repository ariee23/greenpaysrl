

  <?php

  //mostra gli errori su schermo
  /*ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL | E_STRICT);*/
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  use PHPMailer\PHPMailer\SMTP;

  require '../PHPMailer/src/Exception.php';
  require '../PHPMailer/src/PHPMailer.php';
  require '../PHPMailer/src/SMTP.php';
 ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL | E_STRICT);


  class GestioneMovimentiControl{




  /***************************************************************************
               ****    METODO PER VISUALIZZARE LA CRONOLOGIA    ****
  *****************************************************************************/ 

       /**
       *Restituisce la cronologia dei movimenti dell'utente loggato.
       * 
       * @param nessuno
       * @return void
       * @throws nessuno
       */

    



       function visualizzaCronologia(){
     //VARIABILI DI CONNESSIONE
     
       //VARIABILI DI CONNESSIONE
     $host = "localhost";   // nome di host
     $user = "bee3b716298b4a";// username dell'utente in connessione
     $password = "bad87d03";// password dell'utente
     $db="heroku_16f3a281c2f1459";//nome database
       //CONNESSIONE AL DBMS
        $connessione = new mysqli($host, $user, $password,$db);
  $ciao=$_SESSION['cf'];


      //ERRORE DI CONNESSIONE
    if ($connessione->connect_error) {
    die("Connection failed: " . $connessione->connect_error);
    header("location:../erroreconnessione.html");
    }
    //SELECT * FROM  movimenti where mittente='$ciao' and tipo_op='pagamento'
      //     UNION select * from movimenti where destinatario='$ciao' and tipo_op='accredito'




    $sql1="SELECT * FROM  movimenti where mittente='$ciao' and tipo_op='pagamento'
           UNION select * from movimenti where destinatario='$ciao' and tipo_op='accredito' ORDER BY data";


           $sqlsimo="SELECT * FROM  movimenti where mittente='$ciao' 
           UNION select * from movimenti where destinatario='$ciao' ORDER BY data";

          // esecuzione della query per la creazione del database
          if (!$res=$connessione->query($sqlsimo)) {
              echo "Errore della query: " . $connessione->error . ".";

          }else{
   
                   while ($row = $res->fetch_assoc()) {

                          //assegno a delle variabili il contenuto di ogni campo della tabella utente
                          $cod_movimento=$row["cod_movimento"];
                          $mittente=$row["mittente"];
                          $destinatario=$row["destinatario"];
                          $cifra=$row["cifra"];
                          $data=$row["data"];
                          $metodo_pag=$row["metodo_pag"];
                          $tipo_op=$row["tipo_op"];
                          $note=$row["note"];


                          $color=" ";
                        if($mittente==$ciao)
                          {$color="red";
  }else {
                                                  $color="green";

  }



                          printf ("%s", "<tr>");

                          printf ("%s", "<td style='color:$color;'>");
                          printf ("%s", "".$cod_movimento);
                          printf ("%s", "</td>");

                       

                          printf ("%s", "<td style='color:$color;'>");
                          printf ("%s", "".$mittente);
                          printf ("%s", "</td>");

                          printf ("%s", "<td style='color:$color;'>");
                          printf ("%s", "".$destinatario);
                          printf ("%s", "</td>");

  if($mittente==$ciao){ 
                          printf ("%s", "<td style='color:$color;'>");

                          printf ("%s", "-".$cifra." €");
                          printf ("%s", "</td>");
                        }else{
  printf ("%s", "<td style='color:$color;'>");

                          printf ("%s", " ".$cifra." €");
                          printf ("%s", "</td>");
                          }

                          printf ("%s", "<td style='color:$color;' >");
                          printf ("%s", "".$data);
                          printf ("%s", "</td>");
     
                          printf ("%s", "<td style='color:$color;' >");
                          printf ("%s", "".$metodo_pag);
                          printf ("%s", "</td>");

                         

                     

          

                          printf ("%s", "</tr>");
                          printf ("%s", "</font>");




                   }
          }

          // chiusura della connessione
          $connessione->close();



       }


























  /***************************************************************************+
               ****    METODO PER RIMUOVERE UN ABBONAMENTO    ****
  *****************************************************************************/ 



       /**
       *Permette la rimozione di un abbonamento attivo.
       * 
       * @param $codiceAbbonamento è il codice dell'abbonamento che l'utente vuole rimuovere.
       * @return void
       * @throws nessuno
       */


  function rimuoviAbbonamento($codiceAbbonamento){
    //VARIABILI DI CONNESSIONE
     $host = "localhost";   // nome di host
     $user = "bee3b716298b4a";// username dell'utente in connessione
     $password = "bad87d03";// password dell'utente
     $db="heroku_16f3a281c2f1459";//nome database
       //CONNESSIONE AL DBMS
        $connessione = new mysqli($host, $user, $password,$db);





  $ciao=$_SESSION['cf'];



  // verifica su eventuali errori di connessione
  if ($connessione->connect_errno) {
      echo "Connessione fallita: ". $connessione->connect_error . ".";
      exit();
  }
            //  printf ("%s", "");


  // esecuzione della query per la creazione del database
  if (!$res=$connessione->query("DELETE FROM pagamento_periodico WHERE cod_pagamento=$codiceAbbonamento and  mittente=$ciao")) {
      echo "Errore della query: " . $connessione->error . ".";

  }else{
   
                   
  }

  // chiusura della connessione
  $connessione->close();



  }




  /**************************************************************************
              ****    METODO PER VISUALIZZARE abbonamenti 2    ****
   **************************************************************************/ 

       /**
       *Restituisce gli abbonamenti dell'utente loggato.
       * 
       * @param nessuno
       * @return void
       * @throws nessuno
       */


       function visualizzaAbbonamento(){

          //VARIABILI DI CONNESSIONE
     $host = "localhost";   // nome di host
     $user = "bee3b716298b4a";// username dell'utente in connessione
     $password = "bad87d03";// password dell'utente
     $db="heroku_16f3a281c2f1459";//nome database
       //CONNESSIONE AL DBMS
        $connessione = new mysqli($host, $user, $password,$db);




          $ciao=$_SESSION['cf'];


          // verifica su eventuali errori di connessione
          if ($connessione->connect_errno) {
          echo "Connessione fallita: ". $connessione->connect_error . ".";
          exit();
          }


          // esecuzione della query per la creazione del database
          if (!$res=$connessione->query("select * from  pagamento_periodico where mittente='$ciao'")) {
              echo "Errore della query: " . $connessione->error . ".";

           }else{
   
                   while ($row = $res->fetch_assoc()) {

       //assegno a delle variabili il contenuto di ogni campo della tabella utente
                    $cod_pagamento=$row["cod_pagamento"];
                    $mittente=$row["mittente"];
                    $destinatario=$row["destinatario"];
                    $p=$row["periodicita"];
                    $cifra=$row["cifra"];
                    $data_inizio=$row["data_inizio"];


           


              printf ("%s", "<tr>");

              printf ("%s", "<td>");
              printf ("%s", "".$cod_pagamento);
           //   $_SESSION['abbonamento']=$cod_pagamento;

              printf ("%s", "</td>");

              /*printf ("%s", "<td>");
              printf ("%s","".$mittente);
              printf ("%s", "</td>");
  */
              printf ("%s", "<td>");
              printf ("%s", "".$destinatario);
              printf ("%s", "</td>");

              printf ("%s", "<td>");
              printf ("%s", "".$p);
              printf ("%s", "</td>");

              printf ("%s", "<td>");
              printf ("%s", "".$cifra);
              printf ("%s", "</td>");

              printf ("%s", "<td>");
              printf ("%s", "".$data_inizio);
              printf ("%s", "</td>");

              printf ("%s", "<td>");
           /*   printf ("%s", " <td><a href='#'  onClick='return ConfermaInvio() <?php $ogg= new GestioneMovimentiControl();
                          $ogg->rimuoviAbbonamento($cod_pagamento); ?>'>Revoca abbonamento</a>");
  */

  /*
   printf ("%s"," <td><a href='#' onClick=' var annulla = window.confirm(");
    printf("%s","'Si è scelto di inviare questo modulo al destinatario. Interrompere l'esecuzione?');");
    printf("%s","if (annulla) {return annulla;}else {document.write('<?php rimuoviAbbonamento($cod_pagamento); ?>');");
    printf("%s","}> Revoca abbonamento</a>");


  */
    $_SESSION['abbonamento']="";
    $s=$_SESSION['abbonamento'];
   // $c="'abbonamento'";

    printf ("%s", " <td><button name='prova' type='submit' class='btn btn-info btn-lg' data-toggle='modal' data-target='#myModal' onClick='$s=$cod_pagamento;'value='".$cod_pagamento."'>x</button>
  ");




              printf ("%s", "</td>");

          

              printf ("%s", "</tr>");



  }
  }


  // chiusura della connessione
  $connessione->close();



  }





  function pagamentiTot2($movimentiMese){
    //VARIABILI DI CONNESSIONE
     $host = "localhost";   // nome di host
     $user = "bee3b716298b4a";// username dell'utente in connessione
     $password = "bad87d03";// password dell'utente
     $db="heroku_16f3a281c2f1459";//nome database
       //CONNESSIONE AL DBMS
        $connessione = new mysqli($host, $user, $password,$db);

  $ciao=$_SESSION['cf'];

  // verifica su eventuali errori di connessione
  if ($connessione->connect_errno) {
      echo "Connessione fallita: ". $connessione->connect_error . ".";
      exit();
  }
            //  printf ("%s", "");

  //HO FATTO LE VISTE DIVIDENDO I MOVIMENTI PER MESE QUINDI IMPOSTARE TUTTO DI CONSEGUENZA
  //METTERE COME ATTRIBUTO IL MESE E CAMBIARE IL NOME DELLA TABELLA A SECONDO DI QUESTO. EASY. BESTEMMIE FINITE.




$sql1="SELECT sum(cifra) as tot FROM $movimentiMese where tipo_op='pagamento' and mittente='$ciao' and tipo_op='gp' group by mittente having sum(cifra)";

$querysimo="SELECT sum(cifra) as tot FROM $movimentiMese where mittente='$ciao' and tipo_op='gp' group by mittente having sum(cifra)";
  // esecuzione della query per la creazione del database
  if (!$res=$connessione->query($querysimo)) {
      echo "Errore della query: " . $connessione->error . ".";

  }else{
  $contatorerighe=0;

     while ($row = $res->fetch_assoc()) {

       //assegno a delle variabili il contenuto di ogni campo della tabella utente
                 
                    $tot=$row["tot"];

               // printf ("%s", "-".$tot." EUR");

                $totP="-".$tot;
                return $totP;
                $contatorerighe++;
      }

      if($contatorerighe==0){//printf("0");

  return "0";

    }
  }


  // chiusura della connessione
  $connessione->close();



  }


  function accreditiTot2($movimentiMese){
    //VARIABILI DI CONNESSIONE
     $host = "localhost";   // nome di host
     $user = "bee3b716298b4a";// username dell'utente in connessione
     $password = "bad87d03";// password dell'utente
     $db="heroku_16f3a281c2f1459";//nome database
       //CONNESSIONE AL DBMS
      $connessione = new mysqli($host, $user, $password,$db);

  $ciao=$_SESSION['cf'];

  // verifica su eventuali errori di connessione
  if ($connessione->connect_errno) {
      echo "Connessione fallita: ". $connessione->connect_error . ".";
      exit();
  }
           

           $sql1="SELECT sum(cifra) as tot FROM $movimentiMese where tipo_op='accredito' and destinatario='$ciao'  group by mittente having sum(cifra)";


           $sqlsimo="SELECT sum(cifra) as tot FROM $movimentiMese where destinatario='$ciao'  group by mittente having sum(cifra)";









  // esecuzione della query per la creazione del database
  if (!$res=$connessione->query($sqlsimo)) {
      echo "Errore della query: " . $connessione->error . ".";

  }else{
  $contatorerighe=0;

     while ($row = $res->fetch_assoc()) {

       //assegno a delle variabili il contenuto di ogni campo della tabella utente
                   $totA=$row["tot"];
                 
                //printf ("%s", $totA);
  return $totA;
                $contatorerighe++;
     }
     if($contatorerighe==0){//printf("0");
     return "0";}



   }







  // chiusura della connessione
  $connessione->close();



  }














  function saldoFineMese($movimentiMese){
    //VARIABILI DI CONNESSIONE
     $host = "localhost";   // nome di host
     $user = "bee3b716298b4a";// username dell'utente in connessione
     $password = "bad87d03";// password dell'utente
     $db="heroku_16f3a281c2f1459";//nome database
       //CONNESSIONE AL DBMS
      $connessione = new mysqli($host, $user, $password,$db);

  $ciao=$_SESSION['cf'];

  // verifica su eventuali errori di connessione
  if ($connessione->connect_errno) {
      echo "Connessione fallita: ". $connessione->connect_error . ".";
      exit();
  }
            //  printf ("%s", "");

  //HO FATTO LE VISTE DIVIDENDO I MOVIMENTI PER MESE QUINDI IMPOSTARE TUTTO DI CONSEGUENZA
  //METTERE COME ATTRIBUTO IL MESE E CAMBIARE IL NOME DELLA TABELLA A SECONDO DI QUESTO. EASY. BESTEMMIE FINITE.

  // esecuzione della query per la creazione del database

  $cifram1="m1.cifra";
  $cifram2="m2.cifra";
  $mitt1="m1.mittente";
  $mitt2="m2.destinatario";
  $op1="m1.tipo_op";
  $op2="m2.tipo_op";
  $t1="m1.metodo_pag";
  $t2="m2.metodo_pag";
  $accrediti="";
  $pagamenti="";

  //SE IL TOTALE DEGLI ACCREDITI è NULLO...........................

  if (!$res=$connessione->query("SELECT sum(cifra) as tot
  from $movimentiMese 
  where /*tipo_op='accredito'
  and */ destinatario='$ciao' ")) {
      echo "Errore della query: " . $connessione->error . ".";

  }else{

     while ($row = $res->fetch_assoc()) { $accrediti=$row["tot"];}

  }

  if (!$res=$connessione->query("SELECT sum(cifra) as tot
  from $movimentiMese 
  where /*tipo_op='pagamento'
  and*/ mittente='$ciao' and metodo_pag='gp'")) {
      echo "Errore della query: " . $connessione->error . ".";

  }else{

     while ($row = $res->fetch_assoc()) { $pagamenti=$row["tot"];}

  }

  if((!is_null($pagamenti))&&(!is_null($accrediti))){

  /*if (!$res=$connessione->query("SELECT (sum($cifram2))-(sum($cifram1))as tot from $movimentiMese m1 , $movimentiMese m2 where  $mitt1='$ciao'and $mitt1=$mitt2 and $op1='pagamento' and $op2='accredito'and $t1='gp' ")) {
      echo "Errore della query: " . $connessione->error . ".";

  }*/

  $sql1="  (SELECT sum(cifra)-(SELECT sum(cifra)
  from $movimentiMese  
  where tipo_op='pagamento'
  and metodo_pag='gp'
  and mittente='$ciao') AS SALDO_FINE
  from $movimentiMese 
  where tipo_op='accredito'
  and destinatario='$ciao') ";



  $sqlsimo="  (SELECT sum(cifra)-(SELECT sum(cifra)
  from $movimentiMese  
  where  metodo_pag='gp'
  and mittente='$ciao') AS SALDO_FINE
  from $movimentiMese 
  where 
 destinatario='$ciao') ";

  if (!$res=$connessione->query($sqlsimo)) {
      echo "Errore della query: " . $connessione->error . ".";

  }


  else{
  $contatorerighe=0;

     while ($row = $res->fetch_assoc()) {

       //assegno a delle variabili il contenuto di ogni campo della tabella utente
     

                   $totA=$row["SALDO_FINE"];
                 
              //  printf ("%s", $totA);
                return $totA;
                $contatorerighe++;
     }
     if($contatorerighe==0){
      //printf("0");

  return "0";
   }

     //controllare se pagamenti null o accrediti null



   }

  }else if((is_null($pagamenti))&&(!is_null($accrediti))){
    //se i pagamenti sono nulli e gli accrediti no
   // echo $accrediti; 
    return $accrediti;

  }else if((!is_null($pagamenti))&&(is_null($accrediti))){
    //se accrediti sono nulli e pagamenti no
    //echo "".$pagamenti;
     return $pagamenti;
  }








  // chiusura della connessione
  $connessione->close();



  }







  function visualizzaCronologiaMese($mese){
     //VARIABILI DI CONNESSIONE
     
       //VARIABILI DI CONNESSIONE
     $host = "localhost";   // nome di host
     $user = "bee3b716298b4a";// username dell'utente in connessione
     $password = "bad87d03";// password dell'utente
     $db="heroku_16f3a281c2f1459";//nome database
       //CONNESSIONE AL DBMS
        $connessione = new mysqli($host, $user, $password,$db);
  $ciao=$_SESSION['cf'];


      //ERRORE DI CONNESSIONE
    if ($connessione->connect_error) {
    die("Connection failed: " . $connessione->connect_error);
    header("location:../erroreconnessione.html");
    }






$sql1="SELECT * FROM  $mese where mittente='$ciao'  and metodo_pag='gp' and tipo_op='pagamento'
            union SELECT * FROM  $mese where  destinatario='$ciao' and tipo_op='accredito' 
            order by data ;";

$sqlsimo="SELECT * FROM  $mese where mittente='$ciao'  and metodo_pag='gp' 
            union SELECT * FROM  $mese where  destinatario='$ciao' 
            order by data ";



          // esecuzione della query per la creazione del database
          if (!$res=$connessione->query($sqlsimo)) {
              echo "Errore della query: " . $connessione->error . ".";

          }else{
   
                   while ($row = $res->fetch_assoc()) {

                          //assegno a delle variabili il contenuto di ogni campo della tabella utente
                          $cod_movimento=$row["cod_movimento"];
                          $mittente=$row["mittente"];
                          $destinatario=$row["destinatario"];
                          $cifra=$row["cifra"];
                          $data=$row["data"];
                          $metodo_pag=$row["metodo_pag"];
                          $tipo_op=$row["tipo_op"];
                          $note=$row["note"];
  $color=" ";
                        if($mittente==$ciao)
                          {
                                                  $color="red";
  }else {
                                                  $color="green";

  }



                          printf ("%s", "<tr>");

                          printf ("%s", "<td style='color:$color;'>");
                          printf ("%s", "".$cod_movimento);
                          printf ("%s", "</td>");

                       
  if($mittente==$ciao){ 
                          printf ("%s", "<td style='color:$color;'>");

                          printf ("%s", "-".$cifra);
                          printf ("%s", "</td>");
                        }else{
                          printf ("%s", "<td style='color:$color;'>");

                          printf ("%s", " ".$cifra);
                          printf ("%s", "</td>");
                          }

                          printf ("%s", "<td style='color:$color;' >");
                          printf ("%s", "".$data);
                          printf ("%s", "</td>");
     
                          printf ("%s", "<td style='color:$color;' >");
                          printf ("%s", "".$metodo_pag);
                          printf ("%s", "</td>");

                          printf ("%s", "<td style='color:$color;' >");
                          printf ("%s", "".$tipo_op);
                          printf ("%s", "</td>");

                        printf ("%s", "<td style='color:$color;' >");
                        printf ("%s", "".$note);
                        printf ("%s", "</td>");

          

                          printf ("%s", "</tr>");
                          printf ("%s", "</font>");



                   }
          }

          // chiusura della connessione
          $connessione->close();



       }

















  function saldoInizioMese($movimentiMese){
    //VARIABILI DI CONNESSIONE
     $host = "localhost";   // nome di host
     $user = "bee3b716298b4a";// username dell'utente in connessione
     $password = "bad87d03";// password dell'utente
     $db="heroku_16f3a281c2f1459";//nome database
       //CONNESSIONE AL DBMS
      $connessione = new mysqli($host, $user, $password,$db);

  $ciao=$_SESSION['cf'];

  // verifica su eventuali errori di connessione
  if ($connessione->connect_errno) {
      echo "Connessione fallita: ". $connessione->connect_error . ".";
      exit();
  }
            //  printf ("%s", "");

  //HO FATTO LE VISTE DIVIDENDO I MOVIMENTI PER MESE QUINDI IMPOSTARE TUTTO DI CONSEGUENZA
  //METTERE COME ATTRIBUTO IL MESE E CAMBIARE IL NOME DELLA TABELLA A SECONDO DI QUESTO. EASY. BESTEMMIE FINITE.

  // esecuzione della query per la creazione del database

  $movimentiMese2="";

  if($movimentiMese=="movimentigennaio") $movimentiMese2="movimentidicembre";
  if($movimentiMese=="movimentifebbraio") $movimentiMese2="movimentigennaio";
  if($movimentiMese=="movimentimarzo") $movimentiMese2="movimentifebbraio";
  if($movimentiMese=="movimentiaprile") $movimentiMese2="movimentimarzo";

  if($movimentiMese=="movimentimaggio") $movimentiMese2="movimentiaprile";
  if($movimentiMese=="movimentigiugno") $movimentiMese2="movimentimaggio";
  if($movimentiMese=="movimentiluglio") $movimentiMese2="movimentigiugno";
  if($movimentiMese=="movimentiagosto") $movimentiMese2="movimentiluglio";
  if($movimentiMese=="movimentisettembre") $movimentiMese2="movimentiagosto";
  if($movimentiMese=="movimentiottobre") {$movimentiMese2="movimentisettembre";}
  if($movimentiMese=="movimentinovembre") $movimentiMese2="movimentiottobre";
  if($movimentiMese=="movimentidicembre") $movimentiMese2s="movimentinovembre";






  $cifram1="m1.cifra";
  $cifram2="m2.cifra";
  $mitt1="m1.mittente";
  $mitt2="m2.destinatario";
  $op1="m1.tipo_op";
  $op2="m2.tipo_op";
  $t1="m1.metodo_pag";
  $t2="m2.metodo_pag";
  $accrediti="";
  $pagamenti="";

  //SE IL TOTALE DEGLI ACCREDITI è NULLO...........................

  if (!$res=$connessione->query("SELECT sum(cifra) as tot
  from $movimentiMese2
  where /*tipo_op='accredito'
  and */
  destinatario='$ciao' ")) {
      echo "Errore della query: " . $connessione->error . ".";

  }else{

     while ($row = $res->fetch_assoc()) { $accrediti=$row["tot"];}

  }

  if (!$res=$connessione->query("SELECT sum(cifra) as tot
  from $movimentiMese2
  where /*tipo_op='pagamento'
  and */mittente='$ciao' and metodo_pag='gp'")) {
      echo "Errore della query: " . $connessione->error . ".";

  }else{

     while ($row = $res->fetch_assoc()) { $pagamenti=$row["tot"];}

  }

  if((!is_null($pagamenti))&&(!is_null($accrediti))){

  /*if (!$res=$connessione->query("SELECT (sum($cifram2))-(sum($cifram1))as tot from $movimentiMese m1 , $movimentiMese m2 where  $mitt1='$ciao'and $mitt1=$mitt2 and $op1='pagamento' and $op2='accredito'and $t1='gp' ")) {
      echo "Errore della query: " . $connessione->error . ".";

  }*/

  $sql1="(SELECT sum(cifra)-(SELECT sum(cifra)
  from $movimentiMese2
  where tipo_op='pagamento'
  and metodo_pag='gp'
  and mittente='$ciao') AS SALDO_FINE
  from $movimentiMese2
  where tipo_op='accredito'
  and destinatario='$ciao')  ";


  $sqlsimo="(SELECT sum(cifra)-(SELECT sum(cifra)
  from $movimentiMese2
  where 
   metodo_pag='gp'
  and mittente='$ciao') AS SALDO_FINE
  from $movimentiMese2
  where 
   destinatario='$ciao')  ";

  if (!$res=$connessione->query($sqlsimo)) {
      echo "Errore della query: " . $connessione->error . ".";

  }


  else{
  $contatorerighe=0;

     while ($row = $res->fetch_assoc()) {

       //assegno a delle variabili il contenuto di ogni campo della tabella utente
     

                   $totA=$row["SALDO_FINE"];
                 
               // printf ("%s", $totA);
                $contatorerighe++;
                return $totA;
   // echo "sss".$movimentiMese2;  
    if(is_null($totA)){return "0";}


     }

     //controllare se pagamenti null o accrediti null



   }

  }else if((is_null($pagamenti))&&(!is_null($accrediti))){
    //se i pagamenti sono nulli e gli accrediti no
    //echo $accrediti; 
    return $accrediti;
   // echo "sss".$movimentiMese2;

  }else if((!is_null($pagamenti))&&(is_null($accrediti))){
    //se accrediti sono nulli e pagamenti no
   // echo "-".$pagamenti; 
      return $pagamenti;

   // echo "sss".$movimentiMese2;

  }else if((is_null($pagamenti))&&(is_null($accrediti))){
    //se accrediti sono nulli e pagamenti no
    //echo "0"; 
      return "0";

   // echo "sss".$movimentiMese2;

  }








  // chiusura della connessione
  $connessione->close();




  }

  function  ritornaMese($mese){
  if($mese=="movimentigennaio") return "Gennaio";
    if($mese=="movimentifebbraio")return "Febbraio";

  if($mese=="movimentimarzo")return "Marzo";

  if($mese=="movimentiaprile")return "Aprile";
    if($mese=="movimentimaggio")return "Maggio";

  if($mese=="movimentigiugno")return "Giugno";

  if($mese=="movimentiluglio")return "Luglio";

  if($mese=="movimentiagosto")return "Agosto";
    if($mese=="movimentisettembre")return "Settembre";
      if($mese=="movimentiottobre")return "Ottobre";
        if($mese=="movimentinovembre")return "Novembre";
          if($mese=="movimentidicembre")return "Dicembre";
  }





  function stampaTipologia($tipo,$mese,$metodo){





       //SCELTA DELLA QUERY IN BASE ALL'INPUT
  if($tipo=="none"&&$mese=="none"){

        if($metodo=="carta"||$metodo=="gp"||$metodo=="conto corrente"){
          echo "operazioni con $metodo";

        }
  }

  else if($metodo=="none"&&$mese=="none"){

          if ($tipo=="pagamento"){echo "operazioni di pagamento";}
              else if($tipo=="accredito"){echo "operazioni di accredito";}
  }
  else if($metodo=="none"&&$tipo=="none"){
  if($mese=="movimentigennaio") echo "operazioni nel mese di Gennaio";
   if($mese=="movimentifebbraio")echo "operazioni nel mese di Febbraio";

  if($mese=="movimentimarzo")echo "operazioni nel mese di Marzo";

  if($mese=="movimentiaprile")echo "operazioni nel mese di Aprile";
    if($mese=="movimentimaggio")echo "operazioni nel mese di Maggio";

  if($mese=="movimentigiugno")echo "operazioni nel mese di Giugno";

  if($mese=="movimentiluglio")echo "operazioni nel mese di Luglio";

  if($mese=="movimentiagosto")echo "operazioni nel mese di Agosto";
    if($mese=="movimentisettembre")echo "operazioni nel mese di Settembre";
      if($mese=="movimentiottobre")echo "operazioni nel mese di Ottobre";
        if($mese=="movimentinovembre")echo "operazioni nel mese di Novembre";
          if($mese=="movimentidicembre")echo "operazioni nel mese di Dicembre";
          




  }else if($mese=="none"&&$metodo!="none"&&$tipo!="none"){



  if ($tipo=="pagamento"){
  echo "pagamenti effettuati con $metodo";


           }else if($tipo=="accredito"){
     echo "accrediti ricevuti da $metodo";

           }






  }else if($tipo=="none"&&$metodo!="none"&&$mese!="none"){

            if($mese=="movimentigennaio") echo "operazioni nel mese di Gennaio effettuati con $metodo";
    if($mese=="movimentifebbraio")echo "operazioni nel mese di Febbraio  effettuati con $metodo";

  if($mese=="movimentimarzo")echo "operazioni nel mese di Marzo  effettuati con $metodo";

  if($mese=="movimentiaprile")echo "operazioni nel mese di Aprile  effettuati con $metodo";
    if($mese=="movimentimaggio")echo "operazioni nel mese di Maggio v";

  if($mese=="movimentigiugno")echo "operazioni nel mese di Giugno  effettuati con $metodo";

  if($mese=="movimentiluglio")echo "operazioni nel mese di Luglio  effettuati con $metodo";

  if($mese=="movimentiagosto")echo "operazioni nel mese di Agosto  effettuati con $metodo";
    if($mese=="movimentisettembre")echo "operazioni nel mese di Settembre  effettuati con $metodo";
      if($mese=="movimentiottobre")echo "operazioni nel mese di Ottobre  effettuati con $metodo";
        if($mese=="movimentinovembre")echo "operazioni nel mese di Novembre  effettuati con $metodo";
          if($mese=="movimentidicembre")echo "operazioni nel mese di Dicembre  effettuati con $metodo";



  }else if($metodo=="none"&&$mese!="none"&&$tipo!="none"){
  $tipo2="";
  if($tipo=="pagamento")$tipo2="pagamenti";
  if($tipo=="accredito")$tipo2="accrediti";

          if($mese=="movimentigennaio") echo "$tipo2 nel mese di Gennaio ";
    if($mese=="movimentifebbraio")echo "$tipo2 nel mese di Febbraio  ";

  if($mese=="movimentimarzo")echo "$tipo2 nel mese di Marzo  ";

  if($mese=="movimentiaprile")echo "$tipo2 nel mese di Aprile  ";
    if($mese=="movimentimaggio")echo "$tipo2 nel mese di Maggio ";

  if($mese=="movimentigiugno")echo "$tipo2 nel mese di Giugno  ";

  if($mese=="movimentiluglio")echo "$tipo2 nel mese di Luglio ";

  if($mese=="movimentiagosto")echo "$tipo2 nel mese di Agosto  ";
    if($mese=="movimentisettembre")echo "$tipo2 nel mese di Settembre  ";
      if($mese=="movimentiottobre")echo "$tipo2 nel mese di Ottobre  ";
        if($mese=="movimentinovembre")echo "$tipo2 nel mese di Novembre  ";
          if($mese=="movimentidicembre")echo "$tipo nel mese di Dicembre  ";


    
  }else if($metodo!="none"&&$tipo!="none"&&$mese!="none"){


  $tipo2="";
  if($tipo=="pagamento")$tipo2="pagamenti";
  if($tipo=="accredito")$tipo2="accrediti";

          if($mese=="movimentigennaio") echo "$tipo2 nel mese di Gennaio effettuati con $metodo";
    if($mese=="movimentifebbraio")echo "$tipo2 nel mese di Febbraio  effettuati con $metodo";

  if($mese=="movimentimarzo")echo "$tipo2 nel mese di Marzo  effettuati con $metodo";

  if($mese=="movimentiaprile")echo "$tipo2 nel mese di Aprile  effettuati con $metodo";
    if($mese=="movimentimaggio")echo "$tipo2 nel mese di Maggio v";

  if($mese=="movimentigiugno")echo "$tipo2 nel mese di Giugno  effettuati con $metodo";

  if($mese=="movimentiluglio")echo "$tipo2 nel mese di Luglio  effettuati con $metodo";

  if($mese=="movimentiagosto")echo "$tipo2 nel mese di Agosto  effettuati con $metodo";
    if($mese=="movimentisettembre")echo "$tipo2 nel mese di Settembre  effettuati con $metodo";
      if($mese=="movimentiottobre")echo "$tipo2 nel mese di Ottobre  effettuati con $metodo";
        if($mese=="movimentinovembre")echo "$tipo2 nel mese di Novembre  effettuati con $metodo";
          if($mese=="movimentidicembre")echo "$tipo nel mese di Dicembre  effettuati con $metodo";




  }

  }


























  function visualizzaFiltro_v2($tipo,$mese,$metodo){

        //VARIABILI DI CONNESSIONE
     $host = "localhost";   // nome di host
     $user = "bee3b716298b4a";// username dell'utente in connessione
     $password = "bad87d03";// password dell'utente
     $db="heroku_16f3a281c2f1459";//nome database
       //CONNESSIONE AL DBMS
        $connessione = new mysqli($host, $user, $password,$db);
  $ciao=$_SESSION['cf'];


  // verifica su eventuali errori di connessione
  if ($connessione->connect_errno) {
      echo "Connessione fallita: ". $connessione->connect_error . ".";
      exit();
  }



echo "tipo".$tipo; 
echo "mese".$mese; 
echo "metodo".$tipo; 



  $q="";
    $qs="";



  //SCELTA DELLA QUERY IN BASE ALL'INPUT
  if($tipo=="none"&&$mese=="none"){

        if($metodo=="carta"||$metodo=="gp"||$metodo=="conto corrente"){

           //$q="select * from  movimenti where   metodo_pag='$metodo' and mittente='$ciao' union select * from  movimenti where   metodo_pag='$metodo' and destinatario='$ciao' order by data";

           $qs="select * from  movimenti where   metodo_pag='$metodo' and mittente='$ciao' union select * from  movimenti where   metodo_pag='$metodo' and destinatario='$ciao' order by data";





        }
  }

  else if($metodo=="none"&&$mese=="none"){

          if ($tipo=="pagamento"){

         // $q="select * from  movimenti where mittente='$ciao' and tipo_op='$tipo'";

          $qs="select * from  movimenti where mittente='$ciao' ";

           }else if($tipo=="accredito"){
           //$q="select * from  movimenti where destinatario ='$ciao' and tipo_op='$tipo'";
                     $qs="select * from  movimenti where destinatario='$ciao' ";

     
           }
  }
  else if($metodo=="none"&&$tipo=="none"){
             $qs="select * from  $mese where destinatario ='$ciao' union select * from  $mese where mittente ='$ciao' order by data ";

  }else if($mese=="none"&&$metodo!="none"&&$tipo!="none"){



  if ($tipo=="pagamento"){

       //   $q="select * from  movimenti where mittente='$ciao' and tipo_op='$tipo' ";
                    $qs="select * from  movimenti where mittente='$ciao'  ";


           }else if($tipo=="accredito"){
           //$q="select * from  movimenti where destinatario ='$ciao' and tipo_op='$tipo' ";
                               $qs="select * from  movimenti where destinatario='$ciao'  ";

     
           }






  }else if($tipo=="none"&&$metodo!="none"&&$mese!="none"){

             $qs="select * from  $mese where destinatario ='$ciao' and metodo_pag='$metodo'
             union select * from  $mese where mittente ='$ciao' and metodo_pag='$metodo' order by data ";



  }else if($metodo=="none"&&$mese!="none"&&$tipo!="none"){


   if ($tipo=="pagamento"){

      //    $q="select * from  $mese where mittente='$ciao' and tipo_op='$tipo' ";
                    $qs="select * from  $mese where mittente='$ciao' ";


           }else if($tipo=="accredito"){
      //     $q="select * from  $mese where destinatario ='$ciao' and tipo_op='$tipo' ";
                      $qs="select * from  $mese where destinatario ='$ciao' ";

     
           }

    
  }else if($metodo!="none"&&$tipo!="none"&&$mese!="none"){


         if ($tipo=="pagamento"){

         // $q="select * from  $mese where mittente='$ciao' and tipo_op='$tipo' and metodo_pag='$metodo'";

                    $qs="select * from  $mese where mittente='$ciao'  and metodo_pag='$metodo'";


           }else if($tipo=="accredito"){
       //    $q="select * from  $mese where destinatario ='$ciao' and tipo_op='$tipo' and metodo_pag='$metodo'";
                      $qs="select * from  $mese where destinatario ='$ciao' and metodo_pag='$metodo'";

     
           }



  }


  // esecuzione della query per la creazione del database
  if (!$res=$connessione->query($qs)) {
     // echo "Errore della query: " . $connessione->error . ".";

  }else{
   
                   while ($row = $res->fetch_assoc()) {

       //assegno a delle variabili il contenuto di ogni campo della tabella utente
                    $cod_movimento=$row["cod_movimento"];
                    $mittente=$row["mittente"];
                    $destinatario=$row["destinatario"];
                    $cifra=$row["cifra"];
                    $data=$row["data"];
                    $metodo_pag=$row["metodo_pag"];
                    $tipo_op=$row["tipo_op"];


           

  $color=" ";
                        if($tipo_op=="pagamento")
                          {
                                                  $color="red";
  }else {
                                                  $color="green";

  }



                          printf ("%s", "<tr>");

                          printf ("%s", "<td style='color:$color;'>");
                          printf ("%s", "".$cod_movimento);
                          printf ("%s", "</td>");





                          printf ("%s", "<td style='color:$color;'>");
                          printf ("%s", "".$mittente." ");
                          printf ("%s", "</td>");



                          printf ("%s", "<td style='color:$color;'>");
                          printf ("%s", "".$destinatario." ");
                          printf ("%s", "</td>");

                       
  if($tipo_op=="pagamento"){ 
                          printf ("%s", "<td style='color:$color;'>");

                          printf ("%s", "-".$cifra);
                          printf ("%s", "</td>");
                        }else{
  printf ("%s", "<td style='color:$color;'>");

                          printf ("%s", "".$cifra);
                          printf ("%s", "</td>");
                          }

                          printf ("%s", "<td style='color:$color;' >");
                          printf ("%s", "".$data);
                          printf ("%s", "</td>");
     
                          printf ("%s", "<td style='color:$color;' >");
                          printf ("%s", "".$metodo_pag);
                          printf ("%s", "</td>");

                          printf ("%s", "<td style='color:$color;' >");
                          printf ("%s", "".$tipo_op);
                          printf ("%s", "</td>");

                        

          

                          printf ("%s", "</tr>");
                          printf ("%s", "</font>");




  }

  }



  // chiusura della connessione
  $connessione->close();



  }




















  function visualizzaCronologiaMesePDF($mese ,$pdf){
     //VARIABILI DI CONNESSIONE
     
       //VARIABILI DI CONNESSIONE
     $host = "localhost";   // nome di host
     $user = "bee3b716298b4a";// username dell'utente in connessione
     $password = "bad87d03";// password dell'utente
     $db="heroku_16f3a281c2f1459";//nome database
       //CONNESSIONE AL DBMS
        $connessione = new mysqli($host, $user, $password,$db);
  $ciao=$_SESSION['cf'];

      //ERRORE DI CONNESSIONE
    if ($connessione->connect_error) {
    die("Connection failed: " . $connessione->connect_error);
    header("location:../erroreconnessione.html");
    }

    $q1="SELECT * FROM  $mese where mittente='$ciao'  and metodo_pag='gp' and tipo_op='pagamento'
            union SELECT * FROM  $mese where  destinatario='$ciao' and tipo_op='accredito' 
            order by data ";
    $qs="SELECT * FROM  $mese where mittente='$ciao'  and metodo_pag='gp' 
            union SELECT * FROM  $mese where  destinatario='$ciao' 
            order by data ";

          // esecuzione della query per la creazione del database
          if (!$res=$connessione->query($qs)) {
              echo "Errore della query: " . $connessione->error . ".";

          }else{
   
                   while ($row = $res->fetch_assoc()) {

                          //assegno a delle variabili il contenuto di ogni campo della tabella utente
                          $cod_movimento=$row["cod_movimento"];
                          $mittente=$row["mittente"];
                          $destinatario=$row["destinatario"];
                          $cifra=$row["cifra"];
                          $data=$row["data"];
                          $metodo_pag=$row["metodo_pag"];
                          $tipo_op=$row["tipo_op"];
                          $note=$row["note"];

                    printf("%s", "$pdf->Cell(0,10,'$cod_movimento , $mittente,$destinatario,$cifra,$data,$metodo_pag,$tipo_op',0,1);");
                        


                   }
          }

          // chiusura della connessione
          $connessione->close();



       }











  function emailEstrattoConto($email){













  $mail = new PHPMailer(TRUE);
  if(date("d/m/Y")=="01/01/2019"||date("d/m/Y")=="01/02/2019"||date("d/m/Y")=="01/03/2019"||date("d/m/Y")=="01/04/2019"||date("d/m/Y")=="01/05/2019"||date("d/m/Y")=="01/06/2019"||date("d/m/Y")=="01/07/2019"||date("d/m/Y")=="01/08/2019"||date("d/m/Y")=="01/09/2019"||date("d/m/Y")=="01/10/2019"||date("d/m/Y")=="01/11/2019"||date("d/m/Y")=="01/12/2019"){

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
     $mail->addAddress($email);

     // Set the subject.
     $mail->Subject = 'Estratto conto mensile disponibile';

     // Set the mail message body.
    $mail->isHTML(TRUE);
    $mail->Body = "<html><p>Gentile Cliente, la informiamo della disponibilità del suo estratto conto mensile sulla nostra piattaforma, nella sezione 'Estratto conto',disponibile sia in formato telematico sia in pdf.
    </br></br>Cordiali Saluti.
    </br> GreenPay
    </p></html>";
    $mail->AltBody = 'Estratto conto mensile disponibile';




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


  }







  function estrattoContoTelegram($id){

    if(date("d/m/Y")=="01/01/2019"||date("d/m/Y")=="01/02/2019"||date("d/m/Y")=="01/03/2019"||date("d/m/Y")=="01/04/2019"||date("d/m/Y")=="01/05/2019"||date("d/m/Y")=="01/06/2019"||date("d/m/Y")=="01/07/2019"||date("d/m/Y")=="01/08/2019"||date("d/m/Y")=="01/09/2019"||date("d/m/Y")=="01/10/2019"||date("d/m/Y")=="01/11/2019"||date("d/m/Y")=="01/12/2019"){


           $msg="Gentile Cliente, la informiamo della disponibilità del suo estratto conto mensile sulla nostra piattaforma, nella sezione 'Estratto conto',disponibile sia in formato telematico sia in pdf.
  Cordiali Saluti.
  GreenPay";

      $apiToken = "975599523:AAEhdrbDLmLaRXahlCoqiJAoQdp8bRPoqWo";



      $data = [
          'chat_id' => $id,
          'text' => $msg
      ];

    $response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data) );


  }

  }





  function controlloEstratto(){

   //VARIABILI DI CONNESSIONE
     $host = "localhost";   // nome di host
     $user = "bee3b716298b4a";// username dell'utente in connessione
     $password = "bad87d03";// password dell'utente
     $db="heroku_16f3a281c2f1459";//nome database
       //CONNESSIONE AL DBMS
        $connessione = new mysqli($host, $user, $password,$db);
  $oggetto= new GestioneMovimentiControl();
  $ciao=$_SESSION['cf'];

  // verifica su eventuali errori di connessione
  if ($connessione->connect_errno) {
      echo "Connessione fallita: ". $connessione->connect_error . ".";
      exit();
  }
    
            if (!$res=$connessione->query("SELECT * FROM email where  ref_utente='$ciao' ")) {
                     echo "Errore della query: " . $connessione->error . ".";

            }else{

                        while ($row = $res->fetch_assoc()){ $email=$row["email"];}
             }

                 if (!$res=$connessione->query("SELECT * FROM preferenze where  ref_utente='$ciao' ")) {
                        echo "Errore della query: " . $connessione->error . ".";
                  }else{

                         while ($row = $res->fetch_assoc()){
                              $avvisoemail=$row["avviso_mail_ec"];
                              $avvisotelegram=$row["avviso_wa_ec"];
                              $chat_id=$row["chatid"];

                         }


                     if($avvisoemail==1){$oggetto->emailEstrattoConto($email);}
                     if($avvisotelegram==1){ $oggetto->estrattoContoTelegram($chat_id);}
                    }


  // chiusura della connessione
  $connessione->close();





  }









   
  }//classe



  ?>