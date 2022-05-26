<?php
session_start();
$login = false;
$password_errata=false;
if(!empty($_POST['username']))
    $username_utente = $_POST['username'];
    
if(!empty($_SESSION['username'])){
    if(!empty($_SESSION['tipologia_abbonamento'])){
        $username_utente = $_SESSION['username'];
        $tipologia_abbonamento = $_SESSION['tipologia_abbonamento'];
        $login=true;
    }
}
if(!empty($_POST['password']))
    $password_utente = $_POST['password'];
    
if(!$login & !empty($username_utente) & !empty($password_utente)){
    require_once "connection.php";
    $query = "SELECT * FROM utente WHERE username = $1";
    pg_prepare($db,"Controlla_account", $query);
    $res = pg_execute($db,"Controlla_account", array($username_utente));
    if(!$res){
        $login=false;
        $password_errata=true;
    }else{
        if($row = pg_fetch_assoc($res)){
            $login = password_verify($password_utente, $row["passwd"]);
            if($login){
                if($row["tipologia"]== 1 | $row["tipologia"]== 2 | $row["tipologia"]== 3 )
                    $tipologia_abbonamento= $row["tipologia"];
                else
                    $tipologia_abbonamento="-1";
                $password_errata=false;
            }else{
                $password_errata=true;
            }
        }else{
            $password_errata=true;
        }
    }
}elseif(!empty($username_utente) & !empty($password_utente)){
    $login=false;
    $password_errata=false;
}
if($login & (!empty($username_utente) & !empty($tipologia_abbonamento))){
    $_SESSION['username']=$username_utente;
    $_SESSION['tipologia_abbonamento'] = $tipologia_abbonamento;
}

?>











<!DOCTYPE html>
<html>
    <head>
        <title>Netflix</title>
        <meta name="decsription" content="Sito di streaming di film, serie Tv e calcio per progetto di TSW">
        <meta charset="utf-8">
        <meta name="author" content="Di Iorio Matteo, Carrozza Francesco, Di Gregorio Costabile, Cimino Antonio">
        <meta name="keywords" content="TSW, streaming, film, serie tv, calcio, Nacchia, Gragnaniello">
        <meta name="generetor" content="Visual Studio Code">
        <meta http-equiv="content-type" content="5">
        <link rel="icon" href="../Icone png/unisa.png" type="image/icon">
        <link rel="stylesheet" href="stile.css" type="text/css">
       
    </head>
    <body>
        <div class="container">
            <div class="title">
                <h1 id="titolo">Netflix</h1>
                <h3 id="sottotitolo">Tutto quello che cerchi <br> quando e dove vuoi</h3>
            </div>
            <div class="menu">
                <a href="#film" class="menu_film">Film</a>            
                <a href="#serie" class="menu_serie">Serie Tv</a>           
                <input type="image" src="Immagini/lente1.jpg" name="lente" class="lente">
                <input type="text" placeholder="Cerca.." id="cerca">
                
                    <div class="utente">
                        <?php 
                           if(!$login){?>
                                 <button onclick="Login()" class="dropbtn"><img src="Immagini/account.png" id="omino">Login</button>
                                 <div id=tendina class="content">
                                <form name="login" method="POST" id="login_form" action= <?=$_SERVER['PHP_SELF']?>>
                                    <p>
                                        <label for="username">
                                            Username: <input type="text" name="username" id="username" <?php (!empty($username_utente) & $password_errata)?print"style=\"border: 1px solid red\"":""?>>
                                        </label>
                                    </p>
                                    <p>
                                    <label for="password">
                                        Password: <input type="password" name="password" id="password" <?php (!empty($password_utente) & $password_errata)?print"style=\"border: 1px solid red\"":""?>>
                                    </label>
                                    </p>
                                    <p>
                                    <input id="login" type=submit name="login">
                                     Oppure<a href="Registrazione.php" id="registrati">Registrati</a>
                                    </p>
                                </form>
                            </div>
                        <?php
                           }else{?>
                            <a  href="Utente.php"><button class="dropbtn"><img src="Immagini/account.png" id="omino"><p class="username"><?=$username_utente?></p><p class="abbonamento"><?php ($tipologia_abbonamento==1)?(print("1 mese")):(($tipologia_abbonamento==2)? print("6 mesi"):(($tipologia_abbonamento == 3)? print("1 anno"):print("Nessun abbonamento attivato"))); ?></p></button></a>
                        <?php
                           }
                        ?>
                    </div>  
                               
            </div>
            <div class="abbonamenti">
                <div class="sottoabb">
                    <h2 id="piani">Dai un'occhiata ai nostri abbonamenti</h2>
                </div>
                <div class="img_abb">
                    <a href="#abbonamento1"><img src="Immagini/cinema e serie tv.png" id="abbonamento1"></a>
                    <a href="#abbonamento6"><img src="Immagini/cinema e serie tv.png" id="abbonamento6"></a>
                    <a href="#abbonamento12"><img src="Immagini/cinema e serie tv.png" id="abbonamento12"></a>
                </div>
            </div>
            <div class="film">
                <h2 id="film">Film</h2>
            </div>  
            <div class="elenco">
                <input type="image" src="Immagini/avengers.jpg" class="primo">
                <input type="image" src="Immagini/avengers.jpg">
                <input type="image" src="Immagini/avengers.jpg">
                <input type="image" src="Immagini/avengers.jpg">
                <input type="image" src="Immagini/avengers.jpg">
                <input type="image" src="Immagini/avengers.jpg">
                <input type="image" src="Immagini/avengers.jpg" class="ultimo">
            </div>
            <div class="serie">
                <h2 id="serie">Serie Tv</h2>
            </div>
            <div class="elenco">
                <input type="image" src="Immagini/the office.png" class="primo">
                <input type="image" src="Immagini/the office.png">
                <input type="image" src="Immagini/the office.png">
                <input type="image" src="Immagini/the office.png" class="ultimo">  
            </div>
        </div>
        <script>
            function Login() {
                document.getElementById("utente").classList.toggle("show");
            }

    
            window.onclick = function(event) {
              if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                  var openDropdown = dropdowns[i];
                  if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                  }
                }
              }
            }
            if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
            }
        </script>
        <?php  

            for($i=0;$i<20;$i++)  
                echo "<br>";

        
        
        
        
        
        
        
        
        ?>
    </body>
    <footer>
        <div class="contatti">
            <h4>Contattaci:</h4>
            <ul class="listacont">   
                <li><a href="mailto:f.carrozza6@studenti.unisa.it">f.carrozza6@studenti.unisa.it</a></li>
                <li><a href="mailto:a.cimino14@studenti.unisa.it">a.cimino14@studenti.unisa.it</a></li>
                <li><a href="mailto:c.digregorio9@studenti.unisa.it">c.digregorio9@studenti.unisa.it</a></li>
                <li><a href="mailto:m.diiorio6@studenti.unisa.it">m.diiorio6@studenti.unisa.it</a></li>
            </ul>
        </div>
        <div class="social">
            <h4>Seguici su:</h4>
            <ul class="listasoc">
                <li><a href="instagram"><img src="instagram"></a>  Instagram</li>
                <li><a href="Facebook"><img src="facebook"></a>  Facebook</li>
                <li><a href="Twitter"><img src="twitter"></a>  Twitter</li>
                <li><a href="TikTok"><img src="tiktok"></a>  Tik Tok</li>
            </ul>
        </div>
        <div class="chisiamo">
            <h4>Chi siamo:</h4>
            <ul class="listachi">
                <li><a href="unisa/account">Francesco Carrozza</a></li>
                <li><a href="unisa/account">Cimino Antonio</a></li>
                <li><a href="unisa/account">Di Gregorio Costabile</a></li>
                <li><a href="unisa/account">Di Iorio Matteo</a></li>
            </ul>
        </div>
    </footer>
</html>