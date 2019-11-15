<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL | E_STRICT);
 session_start();
 
include ('pdfprova2.php');
include ('GestioneMovimentiControl.php');


  $ogg= new PDF(); 
  $ogg2= new GestioneMovimentiControl();

              


//var_dump($b);

 $mese=$_POST['a'];// L
  $ciao=$ogg2->ritornaMese($mese);
  
                   $pagamentitot=$ogg2->pagamentiTot2($mese);
                   $accredititot=$ogg2->accreditiTot2($mese); 
                   $saldofine=$ogg2->saldoFineMese($mese);
                   $saldoinizio=$ogg2->saldoInizioMese($mese);
                   $saldoreale=$saldofine-$saldoinizio;



//echo $ciao;
 


$ogg->stampa($ciao,$saldofine, $saldoinizio,$accredititot,$pagamentitot,$mese);









?>