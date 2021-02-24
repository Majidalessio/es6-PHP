<?php

function display() 
{

if(isset($_POST['submit']))         //check if the sumbit button is setted
{
	$mySessionID=$_POST['mySessionID'];     //define the session id
	session_id($mySessionID);               //set the session id
	session_start();                        //start the session
	if (!isset($_SESSION['mySessionID']))   //check if the session is initialized, if not php will locate the same index page
        {
	  header('Location:form.php');
	  exit;
	} 
        else
        {
        $mySessionID=$_SESSION['mySessionID'];
        //variable defined through post array
	$pw=$_POST['pw'];
	$_SESSION['pw']=$pw;
	$cognome=$_POST['cognome'];
	$_SESSION['cognome']=$cognome;
	$nome = $_POST['nome'];
	$_SESSION['nome']=$nome;
	$codice= $_POST['codice'];
	$_SESSION['codice']=$codice;
	$email= $_POST['email'];
	$_SESSION['email']=$email;
	$sesso= $_POST['sesso'];
	$_SESSION['sesso']=$sesso;	
        $host  = $_SERVER['HTTP_HOST'];
        //root of the file
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $save= 'save.php?mySessionID='.$mySessionID;                //name of the file saved+number of the current session
        header("Location: http://$host$uri/$save");
        die();
        }
}	
else 
{
    $mtsec = explode(' ', microtime());
    $mySessionID="indoNum-".$mtsec[1];
    session_id($mySessionID);
    session_start();
    $_SESSION['mySessionID']=$mySessionID;
    $cognome="";
    $nome="";
    $codice="";
    $email="";
    $pw="";
}   
$title="Inserisci i tuoi dati";
//html code	
 $str = <<<HTML_FORM
      	<!DOCTYPE html>
<html>
<head>
<title>FormPHP</title>
<link rel="stylesheet" href="css/stili.css?<?php echo time();" type="text/css">
</head>
<body >
<div  >
<form  action="{$_SERVER['PHP_SELF']}" method="POST" name="invio">
  <div id="titolo"><b>$title</b></div>
  <div class="testo">Cognome</div>
  <input class="casella" type="text" name="cognome"  placeholder="Inserisci qui il tuo cognome" value='$cognome'/>
  <div id="ErrSurname" class="errore">Dato obbligatorio</div><br/>
  <div class="testo">Nome</div>
  <input class="casella" type="text" name="nome" placeholder="Inserisci qui il tuo nome" value='$nome'/>
  <div id="ErrName" class="errore">Dato obbligatorio</div><br/>
  <div class="testo">Sesso </div>
  <div class="testo1 ">
  <input id="maschile" name="sesso" type=radio value="maschile"><label for="maschile" >  maschile</label>
    </div>
    <div class="testo1">
  <input id="femminile" name="sesso" type=radio value="feminile" checked> <label for="femminile">femminile</label>
  </div>
  <br>
  <div class="testo">Codice Fisicale</div>
  <input class="casella" type="text" name="codice"  placeholder="Inserisci qui il tuo codice fiscale" value='$codice'/>
  <div id="ErrCod" class="errore"></div><br/>
  <div class="testo">Indirizzo eMail</div>
  <input class="casella" type="text" name="email" placeholder="inserisci qui il tuo indirizzo eMail" value='$email'/>
  <div id="ErrMail" class="errore">Dato obbligatorio</div><br/>
  <div class="testo">Password</div>
  <input class="casella" type="password" name="pw" placeholder="Inserisci qui la tua password" value='$pw'/>
  <div id="ErrPw" class="errore">Dato obbligatorio</div><br/>
  <input class="casella" id="check"  name="check" type="checkbox" /><div id="mydiv">Ho letto l'informativa sulla privacy e acconsento al trattamento dei miei
  dati personali ai sensi dell'art. 13 del D. Lgs. 196/2003</div><br>
<input type="hidden" name="mySessionID" value='$mySessionID'>  
  <p>
   <button id="conf" name="submit" type="submit">conferma</button><button id="canc" type="reset">Annulla</button>
   </p>
</form>
</div>
</body>
</html>
HTML_FORM;

return $str;
}
echo display();
?>