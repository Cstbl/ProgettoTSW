<?php
  require "connection.php";



  if(!empty($_POST['film'])  and ($_POST['film']>='01' and $_POST['film']<='09')){
    $codice_film=$_POST['film'];
    $row=get_film($db,$codice_film);
  }
  elseif(!empty($_POST['serie'] and ($_POST['serie']>='01' and $_POST['serie']<='09'))){
    $codice_serie=$_POST['serie'];
    $row=get_serie($db,$codice_serie);
  }else{
    header("Location: index.php");
  }


  session_start();
  if(!empty($_SESSION['username']) & !empty($_SESSION['tipologia_abbonamento'])){
        $username_utente = $_SESSION['username'];
        $tipologia_abbonamento = $_SESSION['tipologia_abbonamento'];
  }else{
    $username_utente = false;
    $tipologia_abbonamento = false;
  }
?>

<html>
<head>
	<title>TV</title>
  <link rel="stylesheet" href="PaginaContenuto.css" type="text/css">
</head>
<body>
  <div id="superiore">  
    <div>
    <?php if(!empty($username_utente) & ($tipologia_abbonamento>0)){?>
      <iframe width="560" height="315" src="<?php  echo $row['href'];?>" title="YouTube video player" frameborder="0"  allowfullscreen></iframe>
    <?php }else{?>
      <img src="<?php  echo $row['screen'];?>" alt="<?php  echo $row['titolo'];?>" width="560" height="315">
    <?php }?>

      </div>
      <div id="superiore_interno">
        <fieldset id="informazioni">
          Valutazione
          Regista 
          ecc
        </fieldset>
      </div>
  </div>
  <div id="inferiore">
    <fieldset id="commenti">
      <?php 
        echo $row['trama'];
        if(!empty($username_utente) & ($tipologia_abbonamento>0)){
      ?>
      <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
        <input type="text" name="commento" placeholder="Inserisci commento...">
        <input type="submit" name="aggiungi_commento" >
        <input type="hidden" name="film" value=<?= $_POST['film']?>>
      </form>
      <?php
          if(!empty($username_utente) & ($tipologia_abbonamento>0)){
            if(!empty($_POST['aggiungi_commento'])){
              if(!insert_commento_film($db,"01",$_POST['commento'],"www")){
                echo "Hai già inserito un commento uguale";}
              }
          }
        }
        if(!empty($codice_film)){
          stampa_commenti_film($db,$codice_film);
        }
        elseif(!empty($codice_serie)){
          stampa_commenti_serie($db,$codice_serie);
        }
      ?>
    </fieldset>
  </div>
  <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>


<?php function stampa_commenti_film($db,$codice_film){
  $sql="SELECT utente,testo from commentoFilm where film=$1";
  $prep=pg_prepare($db,"find_commento",$sql);
  $ret=pg_execute($db,"find_commento",array($codice_film));
  if(!$ret){
    echo "ERRORE QUERY" . pg_last_error($db);
  }
  while($row=pg_fetch_assoc($ret)){
      echo "<p>L'utente".$row['utente']." ha scritto ".$row['testo']."</p>";
  }
  
  }

  function stampa_commenti_serie($db,$codice_serie){
    $sql="SELECT utente,testo from commentoSerie where serie=$1";
    $prep=pg_prepare($db,"find_commento_serie",$sql);
    $ret=pg_execute($db,"find_commento_serie",array($codice_serie));
    if(!$ret){
      echo "ERRORE QUERY" . pg_last_error($db);
    }
    while($row=pg_fetch_assoc($ret)){
        echo "<p>L'utente".$row['utente']." ha scritto ".$row['testo']."</p>";
    }
    
    }

  function get_film($db,$codice_film){
    $sql="SELECT * from film where codice=$1";
    $prep=pg_prepare($db,"find_film",$sql);
    $ret=pg_execute($db,"find_film",array($codice_film));
    if(!$ret){
      echo "Film non esistente";
    }
    if($row=pg_fetch_assoc($ret)){
      return $row;
    }else{
      return FALSE;
    }
    
  }

  function get_serie($db,$codice_serie){
    $sql="SELECT * from serie where codice=$1";
    $prep=pg_prepare($db,"find_serie",$sql);
    $ret=pg_execute($db,"find_serie",array($codice_serie));
    if(!$ret){
      echo "Serie non esistente";
    }
    if($row=pg_fetch_assoc($ret)){
      return $row;
    }else{
      return FALSE;
    }
    
  }
  
  function insert_commento_film($db,$codice_film,$commento,$utente){
    $sql="SELECT * from commentofilm where film=$1 and testo=$2 and utente=$3";
    $prep=pg_prepare($db,"find_commento_esistente_film",$sql);
    $ret=pg_execute($db,"find_commento_esistente_film",array($codice_film,$commento,$utente));
    if(!$ret){
      echo "ERRORE QUERY" . pg_last_error($db);
    }
    if($row=pg_fetch_assoc($ret)){
      return FALSE;
    }
    $sql="INSERT INTO commentoFilm (film,utente,testo) values($1,$2,$3)";
    $prep=pg_prepare($db,"insert",$sql);
    $ret=pg_execute($db,"insert",array($codice_film,$utente,$commento));
    if(!$ret){
      echo "ERRORE QUERY" . pg_last_error($db);
    }
  }

  function insert_commento_serie($db,$codice_serie,$commento,$utente){
    $sql="SELECT * from commentoserie where serie=$1 and testo=$2 and utente=$3";
    $prep=pg_prepare($db,"find_commento_esistente_serie",$sql);
    $ret=pg_execute($db,"find_commento_esistente_serie",array($codice_serie,$commento,$utente));
    if(!$ret){
      echo "ERRORE QUERY" . pg_last_error($db);
    }
    if($row=pg_fetch_assoc($ret)){
      return FALSE;
    }
    $sql="INSERT INTO commentoserie (serie,utente,testo) values($1,$2,$3)";
    $prep=pg_prepare($db,"insert_commento_serie",$sql);
    $ret=pg_execute($db,"insert_commento_serie",array($codice_serie,$utente,$commento));
    if(!$ret){
      echo "ERRORE QUERY" . pg_last_error($db);
    }
  }

      
  
?>