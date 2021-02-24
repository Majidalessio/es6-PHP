<?php

function display() 
{
    
if(isset($_POST['submit']))     //check if the sumbit button is setted
{
	
	$mySessionID=$_POST['mySessionID'];     //define the session id
	session_id($mySessionID);               //set the session id
	session_start();                        //start the session
	if (!isset($_SESSION['mySessionID']))   //check if the session is initialized, if not php will locate the same index page
        {
            header('Location:form.php');
            exit;
	} 
        else        //variable defined through post array
        $mySessionID=$_SESSION['mySessionID'];
	$pw=$_SESSION['pw'];
	$cognome=$_SESSION['cognome'];
	$nome =$_SESSION['nome'];
	$codice=$_SESSION['codice'];
	$email=$_SESSION['email'];
	$sesso=$_SESSION['sesso'];
	
	$ErrForm="";
	$styleErrForm="padding:0%";
	//root of the DB
        $dbname="quintab_esercizio5";                                                 //name of the schema
        $port="3307";                                                                 //port used on xampp
	$conn=mysqli_connect("127.0.0.1","root","",$dbname,$port);     //change with your username and password
	if ($conn==FALSE)                           //false means that the DB were not found
	{	
            $ErrForm= "Errore di connessione";
        }
	else
        {
            //inserisco i dati nella tabella datiUtente
            mysqli_query($conn,"insert into datiUtente (idUtente, Cognome, Nome, Sesso, CodiceFiscale) values ('$cognome','$nome','$sesso','$codice')");
            $result=mysqli_query($conn,"select idUtente from datiUtente where nome ='$nome' and cognome='$cognome'");                               //???????
            if ($result==FALSE || $result->num_rows !=1)
            {
                $ErrForm="Errore durante lettura datiUente";	
                $result->close();
            }
            else
            {				
                $row = $result->fetch_assoc();
                $id=$row["idUtente"];
                $result->close();
                $pw=md5($pw);
                $result=mysqli_query($conn,"insert into DatiSensibili (Password, Mail, idUtente) values ('$pw','$email','$id')");
                if ($result==FALSE)
                {
                    $ErrForm="Errore durante inserimento credenziali";
                    $result->close();				
                }
            }
        }
	
	if($ErrForm!="")
		$title="Errore durante il salvataggio"." ".$ErrForm;
	else 
	$title="Dati salvati correttamente";
	$hidden="hidden";
	$submitButton="Esci";
	$url="";		

	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$url= "http://".$host.$uri."/form.php";
	$nameSubmit="again";
}
else
{
	$mySessionID=$_GET['mySessionID'];

        session_id($mySessionID);               //set the session id
	session_start();                        //start the session
        //variable defined through session array
	$pw=$_SESSION['pw'];
	$cognome="Cognome: ".$_SESSION['cognome'];
	$nome = "Nome:".$_SESSION['nome'];
	$codice= "Codice Fisicale: ".$_SESSION['codice'];
	$email= "Indirizzo eMail: ".$_SESSION['email'];
	$sesso= "Sesso: ".$_SESSION['sesso'];
	$ErrForm="";
	$hidden="";
	$title="Riepilogo dati";
	$submitButton="save";
	$nameSubmit="submit";
	$url="{$_SERVER['PHP_SELF']}";          //url of the current file
}

//html code
 $str = <<<HTML_FORM
   	<!DOCTYPE html>
<html>
<head>
<title> My site</title>
<link rel="stylesheet" href="css/stili.css" type="text/css">
</head>
<body >
<div >
<form   action='$url' method="POST" name="invio">
  <div id="titolo" >$title</div>
  <div class="testo2" $hidden>$cognome</div>
  <div class="testo2" $hidden>$nome</div>
  <div class="testo2" $hidden>$sesso</div>
  <div class="testo2" $hidden>$codice</div>
  <div class="testo2" $hidden>$email</div>
  <div class="testo2" $hidden>Password: ***********</div>
   <input type="hidden" name="mySessionID" value='$mySessionID'>
    <p>
   <button id="conf" name='$nameSubmit' >$submitButton</button>
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