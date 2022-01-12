<?php
// gibt es Meldungen über den Erfolg?
$successes = [];
if (isset($_GET['success'])){
    if ($_GET['success'] == 'erziehungsberechtigteregistriert'){
        $successes[] = 'Erziehungsberechtigte erfolgreich registriert!';
    }
    if ($_GET['success'] == 'paedagogeregistriert'){
        $successes[] = 'Pädagoge erfolgreich registriert!';
    }
    if ($_GET['success'] == 'kindregistriert'){
        $successes[] = 'Kind erfolgreich registriert!';
    }
}

if (!empty($successes)) {
    if (count($successes) > 0) {
    // wenn ja werden sie Zeile für Zeile ausgegeben
        echo '<div class="success">';
        echo '<ul>';
            foreach ($successes as $success) {
            echo '<li>';
                echo $success;
                echo '</li>';
            }
        echo '</ul>';
        echo '</div>';
    }
}

