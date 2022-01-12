<?php
require_once ('inc/maininclude.inc.php');
include_once ('inc/constants.inc.php');

$kind_id = $_GET['kind_id'];
$kompetenzerhebungs_id = $_GET['kompetenzerhebung'];
$bereich_id = $_GET['bereich'];

//durch iterieren, frage ausgeben, auf prozentwert checken.
$percentages = $kompetenzerhebungManager->getFragen($kompetenzerhebungs_id, $bereich_id);

?>


    <section id="video-bereich">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <header class="intro-container">

                        <h1>Kompetenzbereich: <?php echo $bereich_id ?></h1>
                        <br>

                        <?php
                        for($i = 0; $i < count($percentages); $i++){?>
                            <form>
                                <h3 style="font-size: 1.3rem;">Kompetenz <?php echo $i+1?>:</h3>
                                <p style="font-size: 1.3rem;"><?php echo $percentages[$i]->frage->frage?></p>
                                <p style="font-size: 1.3rem;">
                                    <label><input <?php if($percentages[$i]->prozentsatz == 25){echo 'checked="checked"';} ?> data-frage-id="<?php echo $percentages[$i]->frage->id ?>" data-kompetenzerhebung-id="<?php echo $kompetenzerhebungs_id ?>" type="radio" name="percentage" value="25">25%</label>
                                    <label><input <?php if($percentages[$i]->prozentsatz == 50){echo 'checked="checked"';} ?> data-frage-id="<?php echo $percentages[$i]->frage->id ?>" data-kompetenzerhebung-id="<?php echo $kompetenzerhebungs_id ?>" type="radio" name="percentage" value="50">50%</label>
                                    <label><input <?php if($percentages[$i]->prozentsatz == 75){echo 'checked="checked"';} ?> data-frage-id="<?php echo $percentages[$i]->frage->id ?>" data-kompetenzerhebung-id="<?php echo $kompetenzerhebungs_id ?>" type="radio" name="percentage" value="75">75%</label>
                                    <label><input <?php if($percentages[$i]->prozentsatz == 100){echo 'checked="checked"';} ?> data-frage-id="<?php echo $percentages[$i]->frage->id ?>" data-kompetenzerhebung-id="<?php echo $kompetenzerhebungs_id ?>" type="radio" name="percentage" value="100">100%</label>
                                </p>
                                <br>
                            </form>
                        <?php }?>


                        <br>
                    </header>
                </div>
            </div>
        </div>
    </section>

<?php
include('./inc/footer.inc.php');
?>