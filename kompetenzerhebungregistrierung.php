<?php
require_once 'inc/maininclude.inc.php';

$kompetenzerhebungManager = new KompetenzerhebungManager($connection);

$showFormular = true; // die Registrierung soll angezeigt werden

$errors = [];
$successes = [];

if (isset($_POST['btregister'])) {
    $datum = $_POST['datum'];
    $fk_kind_id = $_POST['fk_kind_id'];

    $erstelltam = DateTime::createFromFormat('Y-m-d', $datum);
    if ($erstelltam === false) {
        $errors[] = "Datumsformat ist ungültig->$datum";
    }

    if (count($errors) == 0) {

        $id = 1;
        if ($kompetenzerhebungManager->getKompetenzerhebungById($id) != false) {
            $errors[] = 'Kompetenzerhebung wurde bereits registriert!';
        } else {
            $id = $kompetenzerhebungManager->registerKompetenzerhebung($erstelltam, $fk_kind_id);
            header('Location: ./kompetenzerhebung.php?kind_id=' . $fk_kind_id . '&kompetenzerhebung=' . $id . '&bereich=1');
            return;
        }
    }
}

if ($showFormular) {
    ?>

    <section id="kontakt-bereich">
        <?php include 'inc/errormessages.inc.php'; ?>
        <?php include 'inc/successmessages.inc.php'; ?>
        <div class="container">

            <div class="row">
                <div class="col-6">
                    <header class="intro-container">
                        <h1>Kompetenzerhebung erstellen!</h1>
                    </header>
                </div>
            </div>
            <form id="kontakt-formular" action="?register=1" method="post">
                <div class="row">
                    <div class="col-3">
                        <label for="datum">Datum:</label>
                        <input type="date" id="datum" name="datum" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <label for="fk_kind_id">Kind auswählen:</label>
                        <div style="float:right;">
                            <select name="fk_kind_id" id="fk_kind_id">
                                <option>Bitte wählen:</option>
                                <?php
                                $select = 'SELECT * FROM kompetenz_regenbogen.t_kind';
                                $abfrage = $connection->prepare($select);
                                $abfrage->execute();
                                $result = $abfrage->fetchAll();
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
                        <button id="absendenButton" class="btn-typ-3" type="submit" name="btregister">Erstellen!</button>
                    </div>
                </div>
            </form>

        </div>

    </section>

    <?php
} //Ende von if($showFormular)
include('./inc/footer.inc.php');
?>

