<html>
<head>
  <title>FMCA TV</title>
  <meta name="decsription" content="Sito di streaming di film, serie Tv e calcio per progetto di TSW">
  <meta charset="utf-8">
  <meta name="author" content="Di Iorio Matteo, Carrozza Francesco, Di Gregorio Costabile, Cimino Antonio">
  <meta name="keywords" content="TSW, streaming, film, serie tv, calcio, FMCA, TV">
  <meta name="generetor" content="Visual Studio Code">
  <meta http-equiv="content-type" content="5">
  <link rel="icon" href="Logo/logo4.png" type="image/icon">  
  <link rel="stylesheet" href="registrazione.css" type="text/css">
</head>
<body>
  <?php
    //require_once('header.html');
    session_start();

    if(!empty($_SESSION))
      session_destroy();

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
            echo "LOL";}
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

  <div class="container">
    <h2>Registrati</h2>
    </p>
    <form method="post" name="registrazione" action=<?php echo $_SERVER['PHP_SELF']?> >
      <p>
        <label id="Username" for="username">Username:</label>
      </p>
      <input type="text" name="username" id="username" value="<?php echo $username?>"/>
      <p>
      <label id="Mail" for="email">Mail:</label>
      </p>
      <input type="text" name="email" id="email" value="<?php echo $email?>">
      <p>
      <label id="Password" for="password">Password:</label>
      </p>
      <input type="password" name="password" id="password" min="7" placeholder="Minimo 7 caratteri" value="<?php echo $passwd?>"/>
      <p>
      <label id="Repassword" for="repassword">Ripeti la password:</label>
      </p>
      <input type="password" name="repassword" id="repassword" min="7" value="<?php echo $repassword?>"/>
      <p>
        <label id="Nascita" for="nascita">Data di nascita:</label>
      </p>
      <input type="date" id="nascita" name="nascita" value="<?php echo $nascita?>"
        min="1922-01-01" max=
                              "<?php $timestamp = strtotime("-18 year");
                              echo date('Y-m-d', $timestamp);?>">
    <fieldset>
      <legend>Abbonamento</legend>
      <input type="radio" onclick ="EnablePagamento()" name="abbonamenti" id="abbonamento1" value="1" class="abbonamenti" <?php if($tipologia=="1") echo "checked";?>/>
      <label class="label_abbonamenti" for="abbonamento1" ><img src="Immagini/abbonamento.png"/></label>
          <input type="radio" onclick="EnablePagamento()" name="abbonamenti" id="abbonamento2"  value="2" class="abbonamenti" <?php if($tipologia=="2") echo "checked";?>/>
      <label class="label_abbonamenti" for="abbonamento2" ><img src="Immagini/abbonamento.png"/></label>
          <input type="radio" onclick="EnablePagamento()" name="abbonamenti" id="abbonamento3" value="3" class="abbonamenti" <?php if($tipologia=="3") echo "checked";?>/>
      <label class="label_abbonamenti" for="abbonamento3"  ><img src="Immagini/abbonamento.png"/></label>
      <button type="button" class="salta" onclick="DisablePagamento()">Salta questa opzione</button>
    </fieldset>

    <div id="pagamento" style="display: <?php empty($_POST['abbonamenti']) ? print ("none"): print ("block"); ?>;">
      <div id="metodoPagamento">
        <div class="creditcard">
          <input type="Radio" name="metodoPagamento" id="metodoCarta" value="carta">
          <img class="immagine" src="Immagini/creditcard.png"/>
        </div>
        <div class="paypal">
          <input type="Radio" name="metodoPagamento" id="metodoPaypal" value="Paypal">
          <img class="immagine" src="Immagini/Paypal.png"/>
        </div>
      </div>
      <div id="campiAnagraficaCarta">
        <p>
          <label id="Nome" for="Nome">  Nome intestatario: </label>
        </p>
        <input type="text" class="dati" name="nomeIntestatario" placeholder="Inserisci il nome intestatario..">
        <p>
          <label id="Cognome" for="Cognome"> Cognome intestatario: </label>
        </p>
        <input type="text" name="cognomeIntestatario" class="dati" placeholder="Inserisci il cognome intestatario..">
      </div>
      <div id="campiDatiCarta">
        <p>
          <label id="Numero" for="Numero di carta"> Numero della carta: </label>
        </p>
          <input type="text" id="numero" name="numeroCarta" placeholder="Inserisci numero carta.." maxlength="16">
        <p>
          <label id="Scadenza" for="scadenza"> Data scadenza: </label>
        </p>
        <input type="text" name="scadenza" id="scadenza" placeholder="Inserisci scadenza carta.." class="carta" maxlength="5">
        <p>
          <label id="CVV" for="CVV"> CVV: </label>
        </p>
        <input type="text" id="cvv" name="CVV" placeholder="Inserisci CVV.."  maxlength="3">            
      </div>
      <input type="submit" name="registra" value="Registrati"/>
      </form>
    </div>
      <p>
      </p>
    <hr>
    <p class="accedi">Hai già un account? <a href="Nacchia_TV.php#username">Accedi dalla Homepage</a></p>
  </div>
    <script>
          document.forms.registrazione.addEventListener('submit',function(e){
          e.preventDefault();
          var vuoto=true;
          if(!registrazione.username.value=="" & registrazione.username.value.length<30){
            registrazione.username.style.border = "1px solid #ccc";
           document.getElementById('Username').style.color = "rgb(174, 169, 169)";
          }else{
                registrazione.username.style.border = "1px solid red";
               document.getElementById('Username').style.color = "red";
                vuoto=false;
              }
          if(registrazione.email.value==""){
              registrazione.email.style.border = "1px solid red";
             document.getElementById('Mail').style.color = "red";
              vuoto=false;
          }else{
                  registrazione.email.style.border = "1px solid #ccc";
                  if(!registrazione.email.value.match(/^\w+([\.-]?\w+)@\w+([\.-]?\w+)(\.\w{2,3})+$/g) & registrazione.email.value.length<30){
                      registrazione.email.style.border = "1px solid red";
                     document.getElementById('Mail').style.color = "red";
                      vuoto=false;
                  }
              }
          if(registrazione.password.value!=registrazione.repassword.value | registrazione.password.value=="" |registrazione.password.value.length< 7 | registrazione.password.value.length >255 ){
              registrazione.password.style.border = "1px solid red";
              registrazione.repassword.style.border = "1px solid red";
              document.getElementById('Password').style.color = "red";
              document.getElementById('Repassword').style.color = "red";
              vuoto=false;
          }else{
                  registrazione.repassword.style.border = "1px solid #ccc";
                  document.getElementById('password').style.color = "rgb(174, 169, 169)";
              }
          if(registrazione.nascita.value=="" | !registrazione.nascita.value.match(/\d{4}\-\d{2}\-\d{2}/g)){
              registrazione.nascita.style.border = "1px solid red";
             document.getElementById('Nascita').style.color = "red";
              vuoto=false;
          }else{
                  registrazione.nascita.style.border = "1px solid #ccc";
                  document.getElementById('Nascita').style.color = "rgb(174, 169, 169)";
              }
          if(document.getElementById("pagamento").style.display!="none"){
              if(registrazione.nomeIntestatario.value==""){
                  registrazione.nomeIntestatario.style.border = "1px solid red";
                  document.getElementById('Nome').style.color = "red";
                  vuoto=false;
              }
              else{
                  registrazione.nomeIntestatario.style.border = "1px solid #ccc";
                  document.getElementById('Nome').style.color = "rgb(174, 169, 169)";
              } 
              if(registrazione.cognomeIntestatario.value==""){
                  registrazione.cognomeIntestatario.style.border = "1px solid red";
                  document.getElementById('Cognome').style.color = "red";
                  vuoto=false;
              }else{
                  registrazione.cognomeIntestatario.style.border = "1px solid #ccc";
                  document.getElementById('Cognome').style.color = "rgb(174, 169, 169)";
              }
              if(!document.getElementById("metodoCarta").checked & !document.getElementById("metodoPaypal").checked){
                  metodoPagamento.style.border = "1px solid red";
                  vuoto=false;
              }else{
                  metodoPagamento.style.border = "none";
              }
              if(registrazione.numeroCarta.value==""){
                  registrazione.numeroCarta.style.border = "1px solid red";
                  document.getElementById('Numero').style.color = "red";
                  vuoto=false;
              }else{
                  if(!registrazione.numeroCarta.value.match(/^\d{16}$/g)){
                      registrazione.numeroCarta.style.border = "1px solid red";
                      document.getElementById('Numero').style.color = "red";
                      vuoto=false;
                  }else{
                    registrazione.numeroCarta.style.border = "1px solid #ccc";
                    document.getElementById('Numero').style.color = "rgb(174, 169, 169)";
                  }
              }
              if(registrazione.scadenza.value=="" | registrazione.scadenza.value.length < 5 ){
                  registrazione.scadenza.style.border = "1px solid red";
                  document.getElementById('Scadenza').style.color = "red";
                  vuoto=false;
              }else{
                  if(!registrazione.scadenza.value.match(/^\d[0-9]\/[0-1][0-2]$/g)){
                      registrazione.scadenza.style.border = "1px solid red";
                      document.getElementById('Scadenza').style.color = "red";
                      vuoto=false;
                  }else{
                    registrazione.scadenza.style.border = "1px solid #ccc";
                    document.getElementById('Scadenza').style.color = "rgb(174, 169, 169)";
                  }
              }
              if(registrazione.CVV.value==""){
                  registrazione.CVV.style.border = "1px solid red";
                  document.getElementById('CVV').style.color = "red";
                  vuoto=false;
              }else{
                  if(!registrazione.CVV.value.match(/^\d{3}$/g)){
                      registrazione.numeroCarta.style.border = "1px solid red";
                      document.getElementById('CVV').style.color = "red";
                      vuoto=false;
                  }else{
                  registrazione.CVV.style.border = "1px solid #ccc";
                  document.getElementById('Numero').style.color = "rgb(174, 169, 169)";
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
          registrazione.scadenza.addEventListener('keyup', logKey);
              function logKey(e) {
                x = registrazione.scadenza;
              	if(e.code!="Backspace" & x.value.length==2){
    	            x.value += "/";
                }
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
  <?php
  //  require_once('footer.html');
  ?>
</html>