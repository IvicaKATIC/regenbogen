<?php
require_once ('inc/maininclude.inc.php');


$child_id = $_GET['child_id'];
$survey_id = $_GET['survey'];
$area_id = $_GET['area'];

$percentages = $surveyManager->getQuestions($survey_id, $area_id);

if (isset($_POST['btn_weiter'])) {
    $area_id = $_POST['area'];
    $child_id = $_POST['child_id'];
    $survey_id = $_POST['survey'];
    header('Location: ./survey.php?child_id=' . $child_id . '&survey=' . $survey_id . '&area=' .$area_id);
}
?>

    <section id="video-bereich">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <header class="intro-container">

                        <h1>Kompetenzbereich: <?php echo $area_id ?></h1>
                        <br>

                        <?php
                        for($i = 0; $i < count($percentages); $i++){?>
                            <form>
                                <h3 style="font-size: 1.3rem;">Kompetenz <?php
                                    if($area_id == 1){
                                        $question_counter=1;
                                    }
                                    elseif($area_id == 2){$question_counter=39;}
                                    elseif($area_id == 3){$question_counter=62;}
                                    elseif($area_id == 4){$question_counter=91;}
                                    elseif($area_id == 5){$question_counter=115;}
                                    elseif($area_id == 6){$question_counter=144;}

                                    echo $i+$question_counter?>:</h3>
                                <p style="font-size: 1.3rem;"><?php echo $percentages[$i]->question->text?></p>
                                <p style="font-size: 1.3rem;">
                                    <label><input <?php if($percentages[$i]->value == 25){echo 'checked="checked"';} ?> data-question-id="<?php echo $percentages[$i]->question->id ?>" data-survey-id="<?php echo $survey_id ?>" type="radio" name="percentage" value="25">25%</label>
                                    <label><input <?php if($percentages[$i]->value == 50){echo 'checked="checked"';} ?> data-question-id="<?php echo $percentages[$i]->question->id ?>" data-survey-id="<?php echo $survey_id ?>" type="radio" name="percentage" value="50">50%</label>
                                    <label><input <?php if($percentages[$i]->value == 75){echo 'checked="checked"';} ?> data-question-id="<?php echo $percentages[$i]->question->id ?>" data-survey-id="<?php echo $survey_id ?>" type="radio" name="percentage" value="75">75%</label>
                                    <label><input <?php if($percentages[$i]->value == 100){echo 'checked="checked"';} ?> data-question-id="<?php echo $percentages[$i]->question->id ?>" data-survey-id="<?php echo $survey_id ?>" type="radio" name="percentage" value="100">100%</label>
                                </p>
                                <br>
                            </form>
                            <br>
                        <?php }
                        if($area_id <= 5){?>
                        <form>
                            <input type="hidden" name="area" value="<?php echo $area_id+1 ?>"<input>
                            <input type="hidden" name="child_id" value="<?php echo $child_id ?>"<input>
                            <input type="hidden" name="survey" value="<?php echo $survey_id ?>"<input>
                            <button id="absendenButton" class="btn-typ-2" type="submit" name="btn_weiter">Weiter</button>
                        </form>
                    <?php }
                        else {?>
                            <form method="get" action="./result.php" target="_blank">
                                <input type="hidden" name="child_id" value="<?php echo $child_id ?>"<input>
                                <input type="hidden" name="survey" value="<?php echo $survey_id ?>"<input>
                            <input type="submit" value="Erhebung abschließen">
                            </form>
                        <?php }?>
                    </header>
                </div>
            </div>
        </div>
    </section>

<?php
include('./inc/footer.inc.php');
?>