<?php
    require "connection.php";

    if(!empty($_POST['serie'] and ($_POST['serie']>='01' and $_POST['serie']<='09'))){
        $codice_serie=$_POST['serie'];
        mostra_episodi_serie($db,$codice_serie);
        

    }else{
        header("Location: index.php");
    }

?>



<?php
    function mostra_episodi_serie($db,$codice_serie){
        $sql="SELECT * from episodiserie where serie=$1";
        $prep=pg_prepare($db,"find_episodi",$sql);
        $ret=pg_execute($db,"find_episodi",array($codice_serie));
        if(!$ret){
          echo "Serie non esistente";
        }
        while($row=pg_fetch_assoc($ret)){
          echo "<form action=\"FakeContenuto.php\" method=\"POST\">
                  <input type=\"image\" src=\"TheOffice.jpg\" alt=\"TheOffice\"  class=\"primo\">
                  <input type=\"hidden\" value=\"".$codice_serie."\"name=\"serie\">
                  <input type=\"hidden\" value=\"".$row['numero_episodio']."\"name=\"episodio\">
                </form> ";
        }
        
      }
?>