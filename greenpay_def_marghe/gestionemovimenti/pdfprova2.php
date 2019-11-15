<?php

//mostra gli errori su schermo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL | E_STRICT);


require('fpdf.php');

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('logo.png',10,6,50);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(40,50,'Estratto Conto Mensile ',0,0,'C');
    // Line break
    $this->Ln(40);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}


function stampa($mese,$saldoF,$saldoI,$totA , $totP,$mesemovimenti){







// Instanciation of inherited class
$pdf = new PDF();
$cf=$_SESSION['cf'];
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
    $pdf->Cell(0,5,'Codice Cliente:'.$cf,0,1);
    $pdf->Cell(0,15,'Mese : '.$mese,0,1);
            $pdf->Cell(0,15,'Saldo Inizio Mese : '.$saldoI.' EUR',0,1);

          
                $pdf->Cell(0,10,'movimento         mitt/dest                          cifra           data            metodo               operazione',1,1);



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

        // esecuzione della query per la creazione del database
        if (!$res=$connessione->query("SELECT * FROM  $mesemovimenti where mittente='$ciao'  and metodo_pag='gp' and tipo_op='pagamento'
          union SELECT * FROM  $mesemovimenti where  destinatario='$ciao' and tipo_op='accredito' 
          order by data ")) {
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
                        if($tipo_op=="pagamento"){
                        $pdf->Cell(0,10,''.$cod_movimento.'                '.' '.$destinatario.'            '.$cifra.'        '.$data.'        '.$metodo_pag.'                      '.$tipo_op.'',1,1);

                        }else{

                    $pdf->Cell(0,10,''.$cod_movimento.'                '.'      '.$mittente.'                '.$cifra.'        '.$data.'        '.$metodo_pag.'                     '.$tipo_op.'',1,1);

                        }

                      


                 }
        }

        // chiusura della connessione
        $connessione->close();


            $pdf->Cell(0,10,'Tot. Accrediti :                                                                                                         '.$totA.'   EUR',1,1);
            $pdf->Cell(0,10,'Tot. Pagamenti :                                                                                                             '.$totP.'   EUR',1,1);
            $pdf->Cell(0,10,'Saldo Fine Mese :                                                                                                              '.$saldoF.' EUR',1,1);



       /* $pdf->Cell(0,10,'Totale Pagamenti',0,1);                                                                                                           + 200 EUR ',1,1);     
        $pdf->Cell(0,10,'Totale Accrediti :'0,1);                                                                                                                   - 100 EUR ',1,1);     
        $pdf->Cell(0,10,'Saldo GP fine mese:',0,1);                                                                                                               '.$saldoF,1,1);
                               
*/
           $pdf->Cell(0,100,'',0,1);
            $pdf->Cell(0,10,'N.B. Elenco transazione disponibile nella sezione online.',0,1);

           $pdf->Cell(0,10,'Per eventuali problemi inviare un email a xxx.',0,1);
           $pdf->Cell(0,10,'Cordiali Saluti',0,1);
           $pdf->Cell(5,10,'GreenPay',0,1);






$pdf->Output();
}

}//CLASSE

?>
