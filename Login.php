<?php
function display()
{
    if(isset($_POST['submit']))     //check if the sumbit button is setted
    {
        
	$mySessionID=$_POST['mySessionID'];     //define the session id
	session_id($mySessionID);               //set the session id
	session_start();                        //start the session
        $dbname="quintab_esercizio5";                                                 //name of the schema
        $port="3307";                                                                 //port used on xampp
	$conn=mysqli_connect("127.0.0.1","root","",$dbname,$port);     //change with your username and password
	if ($conn==FALSE)                           //false means that the DB were not found
	{	
            $ErrForm= "Errore di connessione";
        }
        else
        {
            $result=mysqli_query($conn,"select * from datiUtente inner join DatiSensibili on datiUtente.idUtente=DatiSensibili.idUtente where Mail ='$mail' and Password='$psw'");
              if ($result==FALSE || $result->num_rows !=1)
            {
                $ErrForm="Errore durante lettura datiUente";	
                $result->close();
            }
            else
            {				
                $row = $result->fetch_assoc();
                $id=$row["idUtente"];
                $cognome=$row["Cognome"];
                $nome=$row["Nome"];
                $sesso=$row["Sesso"];
                $cf=$row["CodiceFiscale"];
                $hidden="hidden";
                $hidden2="";
                $title="Riepilogo Dati:";
                $credenziali="";
            }
        }
    }
    else
    {
        $title="Log In";
        $mail="";
        $psw="";
        $hidden="";
        $hidden2="hidden";
        $credenziali="";
    }
$str= <<<HTML_FORM

        <html>
            <head>
                <title>Login Form</title>
                <link rel="stylesheet" href="css/stili.css?<?php echo time();" type="text/css">
            </head>
            <body>
                <div id="login">
                    <div class="spacer"><p><center>$title</center></p></div>
                    <div type="$hidden2">$credenziali</div>
                    <div class="spacer"><input type="text" placeholder="inserisci l'email" class="casella" value="$mail" type="$hidden"></div>
                    <div class="err" type="$hidden">Dato obbligatorio</div><br/>
                    <div class="spacer"><input type="password" placeholder="inserisci la password" class="casella" value="$psw" type="$hidden"></div>
                    <div class="err" type="$hidden">Dato obbligatorio</div><br/>
                    <div><button id="conf" name="submit" type="submit" type="$hidden">conferma</button></div>
                </div>
            </body>
        </html>
        
HTML_FORM;
return $str;
}
echo display();
?>

