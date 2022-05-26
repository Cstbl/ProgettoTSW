<?php


    session_start();
    $login=true;
    if(!empty($_SESSION['username'])){ //dovremmo considerare il caso in cui un mongoloide inserisca un utente con username pari a 0
        $username_utente = $_SESSION['username'];
    }else{
        $username_utente = "";
        $login = false;
    }
    if(!empty($_SESSION['tipologia_abbonamento'])){
        $tipologia_abbonamento = $_SESSION['tipologia_abbonamento'];
    }else{
        $tipologia_abbonamento = "";
        $login = false;
    }

?>

























<html>
    <head>

    </head>
    <body>
      <?php    
       if($login){
        ?>
        <div>
            <h1>
                Ciao, <?= $username_utente?>
            </h1>
            <div id="abbonamento_personale">
                <?php if($tipologia_abbonamento>0){
                ?>
                <h2>Il tuo abbonamento</h2>
                <div id="abbonamento_<?=$tipologia_abbonamento?>_mese">
                    <img  src="abbonamento_<?=$tipologia_abbonamento?>" alt="" style="width: 20%; border: 1px solid black">
                    <h3 style="margin:0px"><?php ($tipologia_abbonamento==1)?(print("1 mese")):(($tipologia_abbonamento==2)? print("6 mesi"): print("1 anno")) ?></h3> <!-- MA SECONDO VOI DOBBIAMO AGGIUNGERE IL CONTROLLO DELL'ANNO O è INUTILE, IL CONTROLLO LO FACCIO GIà PRIMA-->
                    <b style="font-size:smaller"><?php ($tipologia_abbonamento==1)?(print("9")):(($tipologia_abbonamento==2)? print("49"): print("99"))?>.0$</b>
                </div>
                <button>Disdici</button>
                <?php 
                }else{?>
                <h1>Non hai nessun abbonamento attivo, scegline uno tra quelli proposti:</h1>
            <?php }?>
            </div>
            <div id="altri_abbonamenti" >
                <h2> Gli altri abbonamenti</h2>
                <?php if($tipologia_abbonamento==1){?>
                    <fieldset>       
                        <input type="radio" onclick="EnablePagamento()" name="abbonamenti" id="abbonamento2"  value="2" class="abbonamenti"/>
                        <label class="label_abbonamenti" for="abbonamento2" ><img src="immagine.png"/></label>
                        <input type="radio" onclick="EnablePagamento()" name="abbonamenti" id="abbonamento3" value="3" class="abbonamenti"/>
                        <label class="label_abbonamenti" for="abbonamento3"  ><img src="immagine.png"/></label>
                        <button type="button" onclick="DisablePagamento()"> SALTA QUESTA OPZIONE</button>
                    </fieldset>
                <?php
                }elseif($tipologia_abbonamento==2) {?>
                    <fieldset >
                            <input type="radio" onclick ="EnablePagamento()" name="abbonamenti" id="abbonamento1" value="1" class="abbonamenti"/>
                            <label class="label_abbonamenti" for="abbonamento1" ><img src="immagine.png"/></label>
                                <input type="radio" onclick="EnablePagamento()" name="abbonamenti" id="abbonamento3" value="3" class="abbonamenti"/>
                            <label class="label_abbonamenti" for="abbonamento3"  ><img src="immagine.png"/></label>
                        </fieldset>
                <?php
                }elseif($tipologia_abbonamento==3){?>
                    <fieldset >
                            <input type="radio" onclick ="EnablePagamento()" name="abbonamenti" id="abbonamento1" value="1" class="abbonamenti"/>
                            <label class="label_abbonamenti" for="abbonamento1" ><img src="immagine.png"/></label>
                                <input type="radio" onclick="EnablePagamento()" name="abbonamenti" id="abbonamento2"  value="2" class="abbonamenti"/>
                            <label class="label_abbonamenti" for="abbonamento2" ><img src="immagine.png"/></label>
                        </fieldset>
                    <?php
                }else{?>
                        <fieldset >
                            <input type="radio" onclick ="EnablePagamento()" name="abbonamenti" id="abbonamento1" value="1" class="abbonamenti"/>
                            <label class="label_abbonamenti" for="abbonamento1" ><img src="immagine.png"/></label>
                                <input type="radio" onclick="EnablePagamento()" name="abbonamenti" id="abbonamento2"  value="2" class="abbonamenti"/>
                            <label class="label_abbonamenti" for="abbonamento2" ><img src="immagine.png"/></label>
                                <input type="radio" onclick="EnablePagamento()" name="abbonamenti" id="abbonamento3" value="3" class="abbonamenti"/>
                            <label class="label_abbonamenti" for="abbonamento3"  ><img src="immagine.png"/></label>
                        </fieldset>
                    <?php
                }?>
                        <div id="pagamento" style="display: none">
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

    
            </div>
            <div id="preferiti" style="width: fit-content; border: 1px solid black">
                <h3>Preferiti:</h3>
                <ul>
                    <li>The Wolf of Wall Maria</li>
                    <li>Game of Drones</li>
                    <li>Sons of Diplomacy</li>
                </ul>
            </div>
        </div>
        <?php }
else{
    echo "user : $username_utente livello:".$_SESSION['tipologia_abbonamento'];
    foreach($_SESSION as &$el){
        echo $el;
    }
    ?>
    <h1>Non sei ancora loggato!!</h1>
    <h2>torna all'<a href="index.php"> homepage </a> e accedi al tuo profilo.</h2>

    <?php  
}?>


    <script>
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
    <h3><a href="index.php">Torna alla Homepage</a></h3>
    </body>
</html>
<?php
?>