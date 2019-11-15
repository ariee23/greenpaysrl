
		function validaAggCarta(){
			var numcarta = document.getElementById("numerocarta");
			var intest = document.getElementById("intestatario");
			var scad = document.getElementById("scadenza");
			var ccv = document.getElementById("ccv");
			var err1 = document.getElementById("errore1");
			var err2 = document.getElementById("errore2");
			var err3 = document.getElementById("errore3");
			var err4 = document.getElementById("errore4");

			var regex1 = /^[0-9]{16}$/;
			var regex2 = /^[a-zA-Z'\.\-\s\,]{3,}$/;
			var regex3 = /^[0-9]{3,4}$/;


			if(numcarta.value == "" || !regex1.test(numcarta.value)){
				numcarta.style.borderColor="red";
				err1.innerHTML = "Numero carta non valido";
			}


			if(intest.value == "" || !regex2.test(intest.value) ){
				intest.style.borderColor="red";
				err2.innerHTML = "Intestatario non valido";
			}

			if(scad.value == ""){
				scad.style.borderColor="red";
				err3.innerHTML = "Data non valida";
			}

			if(ccv.value == "" || !regex3.test(ccv.value) ){
				ccv.style.borderColor="red";
				err4.innerHTML = "CCV non valido";
			}

			if(numcarta.value == "" || intest.value == "" || scad.value == "" || ccv.value == "" || !regex1.test(numcarta.value) ||  !regex2.test(intest.value) || !regex3.test(ccv.value)){
				return false;
			} else {
				return true;
			}

		}


		function validaAggConto(){
			var iban = document.getElementById("iban");
			var intest = document.getElementById("intestatario");
			var banca = document.getElementById("banca");
			var err1 = document.getElementById("errore1");
			var err2 = document.getElementById("errore2");
			var err3 = document.getElementById("errore3");
			var regex1 = /^[0-9a-zA-Z]{27}$/;
			var regex2 = /^[a-zA-Z'\.\-\s\,]{3,}$/;


			if(iban.value == "" || !regex1.test(iban.value)){
				iban.style.borderColor="red";
				err1.innerHTML = "IBAN non valido";
			}


			if(intest.value == "" || !regex2.test(intest.value) ){
				intest.style.borderColor="red";
				err2.innerHTML = "Intestatario non valido";
			}

			if(banca.value == "" || !regex2.test(banca.value) ){
				banca.style.borderColor="red";
				err3.innerHTML = "Banca non valida";
			}




			if(iban.value == "" || intest.value == "" || banca.value == "" ||  !regex1.test(iban.value) ||  !regex2.test(intest.value) || !regex2.test(banca.value)){
				return false;
			} else {
				return true;
			}

		}

		function validaInvia(){
			var dest = document.getElementById("destinatario");
			var imp = document.getElementById("importo");
			var err1 = document.getElementById("errore1");
			var err2 = document.getElementById("errore2");
			var regex1 = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			var regex2 = /^[0-9]+[.,][0-9]+$/;
			var regex3 = /^[0-9]{9,10}$/;

			if(dest.value == "" || (!regex1.test(dest.value) && !regex3.test(dest.value))){
				dest.style.borderColor="red";
				err1.innerHTML = "Destinatario non valido";

			}

			if(imp.value == "" || !regex2.test(imp.value)){
				imp.style.borderColor="red";
				err2.innerHTML = "Importo non valido. Usare il formato 00,00";
			}

			if(dest.value == "" || (!regex1.test(dest.value) && !regex3.test(dest.value)) || imp.value == "" || !regex2.test(imp.value)){
				return false;
			} else {
				return true;
			}


		}

		function validaChatID(){
			var chatid = document.getElementById("chatid");
			var err = document.getElementById("errore");
			var regex = /^[0-9]{9}$/;

			if(chatid.value == "" || !regex.test(chatid.value)){
				chatid.style.borderColor="red";
				err.innerHTML = "ChatID non valido";
				return false;

			} else {
				return true;
			}


		}




		function validaRicarica(){
			var imp = document.getElementById("importo");
			var err = document.getElementById("errore1");
			var regex = /^[0-9]+[.,][0-9]+$/;

			if(imp.value == "" || !regex.test(imp.value)){
				imp.style.borderColor="red";
				err.innerHTML = "Importo non valido. Usare il formato 00,00";
				return false;
			} else {
				return true;
			}


		}

		function validaInvia2(){
			var nome = document.getElementById("nome");
			var imp = document.getElementById("importo");
			var err1 = document.getElementById("errore1");
			var err2 = document.getElementById("errore2");
			var regex = /^[0-9]+[.,][0-9]+$/;

			if(nome.value == ""){
				nome.style.borderColor="red";
				err1.innerHTML = "Esercizio commerciale non valido";

			}

			if(imp.value == "" || !regex.test(imp.value)){
				imp.style.borderColor="red";
				err2.innerHTML = "Importo non valido. Usare il formato 00,00";
			}

			if(nome.value == "" || imp.value == "" || !regex.test(imp.value)){
				return false;
			} else {
				return true;
			}


		}

		function validaInvito(){
			var dest = document.getElementById("destinatario");
			var err = document.getElementById("errore");
			var regex1 = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

			if(dest.value == "" || !regex1.test(dest.value)){
				dest.style.borderColor="red";
				err.innerHTML = "Destinatario non valido";
				return false;

			} else {
				return true;
			}

		}

		function validaLimite(){
			var lim = document.getElementById("limite");
			var err1 = document.getElementById("errore1");
			var regex = /^[0-9]+[.,][0-9]+$/;

			if(lim.value == "" || !regex.test(lim.value)){
				lim.style.borderColor="red";
				err1.innerHTML = "Importo non valido. Usare il formato 00,00";
				return false;
			} else {
				return true;
			}


		}

		function validaModPw(){
			var pwattuale = document.getElementById("pwattuale");
			var pwnuova = document.getElementById("pwnuova");
			var confermanuova = document.getElementById("confermanuova");
			var err1 = document.getElementById("errore1");
			var err2 = document.getElementById("errore2");
			var err3 = document.getElementById("errore3");

			//verifica pwattuale giusta in php

			if(pwattuale.value == ""){
				pwattuale.style.borderColor="red";
				err1.innerHTML = "Inserire password attuale";

			}

			if(pwnuova.value == "" || pwnuova.value.length < 5){
				pwnuova.style.borderColor="red";
				err2.innerHTML = "La password deve contenere almeno 5 caratteri";
			}

			if(confermanuova.value == "" || confermanuova.value != pwnuova.value){
				confermanuova.style.borderColor = "red";
				err3.innerHTML = "Le password non coincidono";
			}

			if(pwattuale.value == "" || pwnuova.value == "" || pwnuova.value.length < 5 || confermanuova.value != pwnuova.value){
				return false;
			} else {
				return true;
			}
		}


		function validaModDati(){
			var nome = document.getElementById("nome");
			var cognome = document.getElementById("cognome");
			var nascita = document.getElementById("nascita");
			var citta = document.getElementById("citta");
			var stato = document.getElementById("stato");
			var err1 = document.getElementById("errore1");
			var err2 = document.getElementById("errore2");
			var err3 = document.getElementById("errore3");
			var err4 = document.getElementById("errore4");
			var err5 = document.getElementById("errore5");
			var regex = /^[a-zA-Z'\.\-\s\,]{3,}$/;

			if(nome.value == "" || !regex.test(nome.value)){
				nome.style.borderColor = "red";
				err1.innerHTML = "Nome non valido";
			}


			if(cognome.value == "" || !regex.test(cognome.value) ){
				cognome.style.borderColor = "red";
				err2.innerHTML = "Cognome non valido";
			}

			if(nascita.value == ""){
				nascita.style.borderColor = "red";
				err3.innerHTML = "Data non valida";
			}

			if(citta.value == "" || !regex.test(citta.value) ){
				citta.style.borderColor="red";
				err4.innerHTML = "Città non valida";
			}

			if(stato.value == "" || !regex.test(stato.value) ){
				stato.style.borderColor="red";
				err5.innerHTML = "Stato non valida";
			}

			if(nome.value == "" || cognome.value == "" || nascita.value == "" || citta.value == "" || !regex.test(nome.value) ||  !regex.test(cognome.value) || !regex.test(citta.value) || stato.value == "" || !regex.test(stato.value)){
				return false;
			} else {
				return true;
			}

		}

		function validaPagPer(){
			var escomm = document.getElementById("escomm");
			var imp = document.getElementById("imp");
			var inizio = document.getElementById("inizio");
			var num = document.getElementById("num");
			var err1 = document.getElementById("errore1");
			var err2 = document.getElementById("errore2");
			var err3 = document.getElementById("errore3");
			var err4 = document.getElementById("errore4");
			var regex = /^[0-9]+[.,][0-9]+$/;
			var regex2 = /^[1-9]+[0-9]*$/;

			if(escomm.value == ""){
				escomm.style.borderColor = "red";
				err1.innerHTML = "Esercizio commerciale non valido";

			}

			if(imp.value == "" || !regex.test(imp.value)){
				imp.style.borderColor = "red";
				err2.innerHTML = "Importo non valido. Usare il formato 00,00";
			}

			if(inizio.value == ""){
				inizio.style.borderColor = "red"
				err3.innerHTML = "Data non valida";
			}

			if(num.value != "" && !regex2.test(num.value)){
				num.style.borderColor = "red";
				err4.innerHTML = "Numero pagamenti non valido";
			}



			if(escomm.value == "" || imp.value == "" || inzio.value == "" || !regex.test(imp.value) || (imp.value!= "" && !regex2.test(num.value))){
				return false;
			} else {
				return true;
			}


		}

		

		function validaLogin(){
			var email = document.getElementById("email");
			var pw = document.getElementById("password");
			var err1 = document.getElementById("errore1");
			var err2 = document.getElementById("errore2");
			var regex1 = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

			if(email.value == "" || !regex1.test(email.value)){
				email.style.borderColor="red";
				err1.innerHTML = "Email non valida";

			}



			if(pw.value == ""){
				pw.style.borderColor="red";
				err2.innerHTML = "Inserire la password";
			}

			if(email.value == "" || !regex1.test(email.value) || pw.value == ""){
				return false;
			} else {
				return true;
			}


		}


		function validaReg(){
			var cf = document.getElementById("cf");
			var nome = document.getElementById("nome");
			var cognome = document.getElementById("cognome");
			var email = document.getElementById("email");
			var pw = document.getElementById("password");
			var nascita = document.getElementById("nascita");
			var ind = document.getElementById("indirizzo");
			var citta = document.getElementById("citta");
			var stato = document.getElementById("stato");
			var cap = document.getElementById("cap");
			var tel = document.getElementById("telefono");
			var err1 = document.getElementById("errore1");
			var err2 = document.getElementById("errore2");
			var err3 = document.getElementById("errore3");
			var err4 = document.getElementById("errore4");
			var err5 = document.getElementById("errore5");
			var err6 = document.getElementById("errore6");
			var err7 = document.getElementById("errore7");
			var err8 = document.getElementById("errore8");
			var err9 = document.getElementById("errore9");
			var err10 = document.getElementById("errore10");
			var err11 = document.getElementById("errore11");
			var regex1 = /^[0-9a-zA-Z]{16}$/;
			var regex2 = /^[a-zA-Z'\.\-\s\,]{3,}$/;
			var regex3 = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			var regex4 = /^[[A-Za-z0-9'\.\-\s\,]+$/;
			var regex5= /^[0-9]{5}$/;
			var regex6 = /^[0-9]{9,10}$/;


			if(cf.value == "" || !regex1.test(cf.value)){
				cf.style.borderColor="red";
				err1.innerHTML = "Codice fiscale non valido";

			}

			if(nome.value == "" || !regex2.test(nome.value)){
				nome.style.borderColor="red";
				err2.innerHTML = "Nome non valido";
			}

			if(cognome.value == "" || !regex2.test(cognome.value)){
				cognome.style.borderColor="red";
				err3.innerHTML = "Cognome non valido";
			}

			if(email.value == "" || !regex3.test(email.value)){
				email.style.borderColor="red";
				err4.innerHTML = "Email non valida";
			}

			if(pw.value == "" || pw.value.length<5){
				pw.style.borderColor="red";
				err5.innerHTML = "Password non valida. La password deve essere lunga almeno 5 caratteri.";
			}

			if(nascita.value == ""){
				nascita.style.borderColor="red";
				err6.innerHTML = "Data non valida";
			}

			if(ind.value == "" || !regex4.test(ind.value)){
				ind.style.borderColor="red";
				err7.innerHTML = "Indirizzo non valido";
			}

			if(citta.value == "" || !regex2.test(citta.value)){
				citta.style.borderColor="red";
				err8.innerHTML = "Città non valida";
			}

			if(stato.value == "" || !regex2.test(stato.value)){
				stato.style.borderColor="red";
				err9.innerHTML = "Stato non valido";
			}

			if(cap.value == "" || !regex5.test(cap.value)){
				cap.style.borderColor="red";
				err10.innerHTML = "Cap non valido";

			}

			if(tel.value == "" || !regex6.test(tel.value)){
				tel.style.borderColor="red";
				err11.innerHTML = "Numero non valido";

			}

			if(cf.value == "" || nome.value == "" || cognome.value == "" || email.value == "" || pw.value == "" || nascita.value == "" || citta.value == "" || stato.value == "" ||  cap.value == "" ||  tel.value == "" || !regex1.test(cf.value) || !regex2.test(nome.value) || !regex2.test(cognome.value) || !regex3.test(email.value) || pw.value.length<5 || !regex4.test(ind.value) ||  !regex2.test(citta.value) || !regex2.test(stato.value) || !regex5.test(cap.value) || !regex6.test(tel.value)){
				return false;
			} else {
				return true;
			}


		}

		function validaAggEmail(){
			var email = document.getElementById("email");
			var err1 = document.getElementById("errore1");
			var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

			if(email.value == "" || !regex.test(email.value)){
				email.style.borderColor = "red";
				err1.innerHTML = "Email non valida";
				return false;
			} else {
				return true;
			}
		}

		function validaAggTel(){
			var num = document.getElementById("num");
			var err1 = document.getElementById("errore1");
			var regex = /^[0-9]{9,10}$/;

			if(num.value == "" || !regex.test(num.value)){
				num.style.borderColor = "red";
				err1.innerHTML = "Numero non valido";
				return false;

			} else {
				return true;
			}
		}


		function validaAggInd(){
			var ind = document.getElementById("ind");
			var citta = document.getElementById("citta");
			var stato = document.getElementById("stato");
			var cap = document.getElementById("cap");
			var err1 = document.getElementById("errore1");
			var err2 = document.getElementById("errore2");
			var err3 = document.getElementById("errore3");
			var err4 = document.getElementById("errore4");
			var regex = /^[[A-Za-z0-9'\.\-\s\,]+$/;
			var regex2= /^[0-9]{5}$/;

			if(ind.value == "" || !regex.test(ind.value)){
				ind.style.borderColor = "red";
				err1.innerHTML = "Indirizzo non valido";

			}

			if(citta.value == "" || !regex.test(citta.value)){
				citta.style.borderColor = "red";
				err2.innerHTML = "Città non valida";

			}

			if(stato.value == "" || !regex.test(stato.value)){
				stato.style.borderColor = "red";
				err3.innerHTML = "Stato non valido";

			}

			if(cap.value == "" || !regex2.test(cap.value)){
				cap.style.borderColor = "red";
				err4.innerHTML = "CAP non valido";

			}

			if(ind.value == "" || citta.value == "" || stato.value == "" || cap.value == "" || !regex.test(ind.value) || !regex.test(citta.value) || !regex.test(stato.value) || !regex2.test(cap.value)){
				return false;
			} else {
				return true;
			}
		}
