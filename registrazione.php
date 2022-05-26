<html>
<head>
	<title>Registrati</title>
  <link rel="stylesheet" href="index.css" type="text/css">
</head>
<body>
<?php
	if(isset($_POST['username']))
		$username = $_POST['username'];
	else
		$username= "";
  if(isset($_POST['email']))
		$email = $_POST['email'];
	else
		$email = "";
	if(isset($_POST['password']))
		$passwd= $_POST['password'];
	else
		$passwd= "";
	if(isset($_POST['repassword']))
		$repassword = $_POST['repassword'];
	else
		$repassword = "";
    if(isset($_POST['nascita']))
		$nascita = $_POST['nascita'];
	else
		$nascita = "";
    if(isset($_POST['abbonamenti'])){
		$tipologia = $_POST['abbonamenti'];
  }
	else{
		$tipologia = "";
    }
    if(!empty($username) && !empty($email) && !empty($passwd)){
    if($passwd==$repassword){
        if(username_exist($username) or email_exist($email)){
            echo "<p> Utente già esistente. Riprova</p>";
            $flag_visualizzazione_sticky = true;
        }else{
          if(insert_utente($username,$email,$passwd,$nascita,$tipologia)){
            echo "<p> Utente $username registrato con successo</p>";
            $flag_visualizzazione_sticky=false;
          } else{
            echo "<p> Problemi nella registrazione dell'utente</p>";
            $flag_visualizzazione_sticky = true;
          }
        }
    }else{
        $flag_visualizzazione_sticky = true;
    }
  }else
  $flag_visualizzazione_sticky = true;
if($flag_visualizzazione_sticky){
?>

<p>
	<h3>Registrati</h3>
	</p>
	<form method="post" name="registrazione" action=<?php echo $_SERVER['PHP_SELF']?> >
		<p>
      <label for="username">Username
			<input type="text" name="username" id="username" value="<?php echo $username?>"/>
		</label>
    </p>
		<p>
		<label for="email">Mail
			<input type="text" name="email" id="email" value="<?php echo $email?>">
		</label>
		</p>
		<p>
		<label for="password">Password
			<input type="password" name="password" id="password" min="7" placeholder="Minimo 7 caratteri" value="<?php echo $passwd?>"/>
		</label>
		</p>
		<p>
		<label for="repassword">Ripeti la password
			<input type="password" name="repassword" id="repassword" min="7" value="<?php echo $repassword?>"/>
		</label>
		</p>
    <p>
      <label for="nascita">Data di nascita
			<input type="date" id="nascita" name="nascita" value="<?php echo $nascita?>"
       min="1922-01-01" max= "<?php $timestamp = strtotime("-18 year"); echo date('Y-m-d', $timestamp);?>">
		</label>
    </p>
    

   <fieldset >
            <input type="radio" onclick ="EnablePagamento()" name="abbonamenti" id="abbonamento1" value="1" class="abbonamenti" <?php if($tipologia=="1") echo "checked";?>/>
            <label class="label_abbonamenti" for="abbonamento1" ><img src="immagine.png"/></label>
                <input type="radio" onclick="EnablePagamento()" name="abbonamenti" id="abbonamento2"  value="2" class="abbonamenti" <?php if($tipologia=="2") echo "checked";?>/>
            <label class="label_abbonamenti" for="abbonamento2" ><img src="immagine.png"/></label>
                <input type="radio" onclick="EnablePagamento()" name="abbonamenti" id="abbonamento3" value="3" class="abbonamenti" <?php if($tipologia=="3") echo "checked";?>/>
            <label class="label_abbonamenti" for="abbonamento3"  ><img src="immagine.png"/></label>
            <button type="button" onclick="DisablePagamento()"> SALTA QUESTA OPZIONE</button>
    </fieldset>
    
    <div id="">
      
    </div>
      <div id="pagamento" style="display: <?php empty($_POST['abbonamenti']) ? print ("none"): print ("block"); ?>;">
            <div id="metodoPagamento">
              <div style="display:inline;">
              <input type="Radio" name="metodoPagamento" id="metodoCarta" value="carta">
               <img src="creditcard.png" style="width:25px" />
              </div>
              <div style="display:inline; float:right;">
                <input  type="Radio" name="metodoPagamento" id="metodoPaypal" value="Paypal">
             <img src="Paypal.png" style="width:25px" /></div>
            </div>
            <div id="campiAnagraficaCarta" style="display:flex; flex-flow: row wrap; gap:10px;">
              <label for="Nome">  Nome intestatario: </label>
                  <input type="text" name="nomeIntestatario" placeholder="Inserisci il nome intestatario..">
              <label for="Cognome"> Cognome intestatario:</label>
                  <input type="text" name="cognomeIntestatario" placeholder="Inserisci il cognome intestatario..">
            </div>
            <div id="campiDatiCarta" style="display:flex; flex-flow: row wrap;">
              <label for="Numero di carta" style="flex-flow: row wrap;"> Numero della carta:</label>
                  <input type="text" id="credit-card" name="numeroCarta" placeholder="Inserisci numero carta.." maxlength="16">
              <label for="CVV"> CVV:</label>
                  <input type="text" name="CVV" placeholder="Inserisci CVV.."  maxlength="3">            </div>
          </div>
    <p>
      
		<input type="submit" name="registra" value="Registrati"/>
    
		</p>
	</form>

    <script>
        document.forms.registrazione.addEventListener('submit',function(e){
        e.preventDefault();
        var vuoto=true;
        if(!registrazione.username.value=="" & registrazione.username.value.length<30){
          registrazione.username.style.border = "1px solid #ccc";

        }else{
              registrazione.username.style.border = "1px solid red";
              vuoto=false;
            }
        if(registrazione.email.value==""){
            registrazione.email.style.border = "1px solid red";
            vuoto=false;
        }else{
                registrazione.email.style.border = "1px solid #ccc";
                if(!registrazione.email.value.match(/^\w+([\.-]?\w+)@\w+([\.-]?\w+)(\.\w{2,3})+$/g) & registrazione.email.value.length<30){
                    registrazione.email.style.border = "1px solid red";
                    vuoto=false;
                 }
            }
        if(registrazione.password.value!=registrazione.repassword.value | registrazione.password.value=="" |registrazione.password.value.length< 7 | registrazione.password.value.length >255 ){
            registrazione.password.style.border = "1px solid red";
            registrazione.repassword.style.border = "1px solid red";
            vuoto=false;
        }else{
                registrazione.repassword.style.border = "1px solid #ccc";
                registrazione.password.style.border = "1px solid #ccc";
            }
        if(registrazione.nascita.value=="" | !registrazione.nascita.value.match(/\d{4]\-\d{2}\-\d{2}/g)){
            registrazione.nascita.style.border = "1px solid red";
            vuoto=false;
        }else{
                registrazione.nascita.style.border = "1px solid #ccc";
            }
        if(document.getElementById("pagamento").style.display!="none"){
            if(registrazione.nomeIntestatario.value==""){
                registrazione.nomeIntestatario.style.border = "1px solid red";
                vuoto=false;
            }
            else{
                registrazione.nomeIntestatario.style.border = "1px solid #ccc";
            } 
            if(registrazione.cognomeIntestatario.value==""){
                registrazione.cognomeIntestatario.style.border = "1px solid red";
                vuoto=false;
            }else{
                registrazione.cognomeIntestatario.style.border = "1px solid #ccc";
            }
            if(!document.getElementById("metodoCarta").checked & !document.getElementById("metodoPaypal").checked){
                metodoPagamento.style.border = "1px solid red";
                vuoto=false;
            }else{
                metodoPagamento.style.border = "none";
            }
            if(registrazione.numeroCarta.value==""){
                registrazione.numeroCarta.style.border = "1px solid red";
                vuoto=false;
            }else{
                if(!registrazione.numeroCarta.value.match(/^\d{16}$/g)){
                    registrazione.numeroCarta.style.border = "1px solid red";
                }else{
                registrazione.numeroCarta.style.border = "1px solid #ccc";
                }
            }
            if(registrazione.CVV.value==""){
                registrazione.CVV.style.border = "1px solid red";
                vuoto=false;
            }else{
                if(!registrazione.CVV.value.match(/^\d{3}$/g)){
                    registrazione.numeroCarta.style.border = "1px solid red";
                }else{
                registrazione.CVV.style.border = "1px solid #ccc";
                }
            }
        }
        if(!vuoto){
        alert("Modifica i campi errati");
        return false;
        }
        registrazione.submit();
        });
        function DisablePagamento(){
            document.getElementById("pagamento").style.display="none";
            const elements = document.getElementsByClassName("abbonamenti");
            for(i=0; i < elements.length; i++){
                elements[i].checked=false;
                
            }
        }
        function EnablePagamento(){
            document.getElementById("pagamento").style.display="block";
        }
    </script>
    



<?php
}else{
  echo "<a href=\"http://localhost/progettoTSW\">Torna all'Homepage</a>";
}
  function username_exist($username){
    require "connection.php";
    $find_sql="SELECT username FROM utente where username=$1";
    $prep=pg_prepare($db,"find_username",$find_sql);
    $ret=pg_execute($db,"find_username",array($username));
    if(!$ret){
      echo "ERRORE QUERY: " . pg_last_error($db);
			return false;
    }else{
      if($row=pg_fetch_assoc($ret)){
        return true;
      }else{
        return false;
      }
    }
  }
  function email_exist($email){
    require "connection.php";
    echo "";
    $find_sql="SELECT email FROM utente where email=$1";
    $prep=pg_prepare($db,"find_email",$find_sql);
    $ret=pg_execute($db,"find_email",array($email));
    if(!$ret){
      echo "ERRORE QUERY: " . pg_last_error($db);
			return false;
    }else{
      if($row=pg_fetch_assoc($ret)){
        return true;
      }else{
        return false;
      }
    }
  }

  function insert_utente($username,$email,$passwd,$nascita,$tipologia){
    require "connection.php";
   ($tipologia == 1) ? ($data_fine =strtotime(" + 1 month")) :  (($tipologia == 2) ? ($data_fine =strtotime(" + 6 month")) : ($data_fine =strtotime(" + 1 year")));
    $insert_sql="INSERT INTO utente (username,email,passwd,nascita,tipologia,data_fine) values($1,$2,$3,$4,$5,$6)";
    $hash=password_hash($passwd,PASSWORD_DEFAULT);
    $prep=pg_prepare($db,'insert',$insert_sql);
    $ret=pg_execute($db,'insert',array($username,$email,$hash,$nascita,empty($tipologia)? '0' : $tipologia,date('Y-m-d', $data_fine)));
    if(!$ret){
      echo "ERRORE QUERY: " . pg_last_error($db);
      return false; 
    }else{
      return true;
    }
    
  }
?>
</body>
</html>