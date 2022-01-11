<?php
require_once ('inc/maininclude.inc.php');


// get parameter: kompetenzerhebungs_id, bereichs_id
// kompetenzerhebung=8&bereich=1 aus URL
$kompetenzerhebungs_id = 8 /*$_GET['kompetenzerhebung']*/;
$bereich_id = 1 /*$_GET['bereich']*/;

//durch iterieren, frage ausgeben, auf prozentwert checken.
$percentages = $kompetenzerhebungManager->getFragen($kompetenzerhebungs_id, $bereich_id);



?>


    <section id="video-bereich">

        <div class="container">
            <div class="row">
                <div class="col-6">
                    <header class="intro-container">
                        <h1>Kompetenzbereich 1: SPIELEN</h1>
                        <form>
                        <?php

                        for($i = 0; $i < count($percentages); $i++){?>


                            <p>Frage <?php echo $i ?></p>
                            <p><?php echo $percentages[$i]->frage->frage?></p>
                            <p>

                                <label><input type="radio" name="q1" value="25">25%</label>
                                <label><input type="radio" name="q1" value="50">50%</label>
                                <label><input type="radio" name="q1" value="75">75%</label>
                                <label><input type="radio" name="q1" value="100">100%</label>
                            </p>
                            <br>

                        <?php }?>
                           <button type="submit" class="btn-typ-2 leistung-ansehen-btn" name="btn_weiter">Weiter</button>
                        </form>
                        <br>

                        <div id="result"></div>

                        <script>
                            function displayRadioValue() {
                                document.getElementById("result").innerHTML = "";
                                const ele = document.getElementsByTagName('input');

                                for(var i = 0; i < ele.length; i++) {

                                    if(ele[i].type="radio") {

                                        if(ele[i].checked)
                                            document.getElementById("result").innerHTML
                                                += ele[i].name + " Value: "
                                                + ele[i].value + "<br>";
                                    }
                                }
                            }
                        </script>
                    </header>

                </div>
            </div>

        </div>

    </section>

<?php
include('./inc/footer.inc.php');
?>