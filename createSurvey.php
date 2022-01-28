<?php
require_once 'inc/maininclude.inc.php';

$surveyManager = new SurveyManager($connection);

$showForm = true; // die Registrierung soll angezeigt werden

$errors = [];
$successes = [];

if (isset($_POST['btregister'])) {
    $date = $_POST['date'];
    $fk_child_id = $_POST['fk_child_id'];


    $createdOn = DateTime::createFromFormat('Y-m-d', $date);
    if ($createdOn === false) {
        $errors[] = "Datumsformat ist ungültig->$date";
    }

    if (count($errors) == 0) {
        //liefert bestehendes KE-Objekt zurück wenn es zu dieser FK_Kind_ID schon eines gibt
        $survey = $surveyManager->getSurveyByChildId($fk_child_id);
        // wenn mit dieser KindId ein Eintrag gefunden wurde
        if ($survey !== false) {
            //Eigene ID der KE herausholen
            $survey_id = $survey->id;
            //Diese KE auf nächster Seite öffnen, indem KE-ID und FK_Kind_Id des bestehenden Objektes weitergeleitet werden
            //wenn kein Eintrag/Objekt gefunden wurde
        } else {
            //neue KE erstellen...
            $surveyManager->addSurvey($createdOn, $fk_child_id);
            //...und ihre ID rausholen und danach übergeben
            $survey_id = $surveyManager->getMaxID();
        }
        header('Location: ./survey.php?child_id=' . $fk_child_id . '&survey=' . $survey_id . '&area=1');
    }
}

if ($showForm) {
    ?>
<main class="center-wrapper">
    <section id="kontakt-bereich">
        <?php include 'inc/errormessages.inc.php'; ?>
        <?php include 'inc/successmessages.inc.php'; ?>
        <div class="container">

            <div class="row">
                <div class="col-6">
                    <header class="intro-container">
                        <h1>Verwaltung Kompetenzerhebung </h1>
                    </header>
                </div>
            </div>
            <form id="kontakt-formular" action="?register=1" method="post">
                <div class="row">
                    <div class="col-3">
                        <label for="date">Datum:</label>
                        <input type="date" id="datum" name="date" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <label for="fk_child_id">Kind auswählen:</label>
                        <div style="float:right;">
                            <select name="fk_child_id" id="fk_child_id">
                                <option>Bitte wählen:</option>
                                <?php
                                $select = 'SELECT * FROM kompetenz_regenbogen.t_kind';
                                $query = $connection->prepare($select);
                                $query->execute();
                                $result = $query->fetchAll();
                                foreach ($result as $key => $value) { ?>
                                    <option value="<?= $value['ID']; ?>"><?= $value['Vorname'] . ' ' . $value['Nachname']; ?></option>
                                <?php }
                                echo "<table>";
                                foreach ($result as $row) {
                                    echo "<tr>";
                                    echo "<td>" . $row['ID'] . "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <button id="absendenButton" class="btn-typ-1" type="submit" name="btregister">Erstellen!</button>
                    </div>
                </div>
            </form>
        </div>
        <br>
        <br>
        <br>
        <br>
    </section>
</main>
    <?php
} //Ende von if($showFormular)
include('./inc/footer.inc.php');
?>

