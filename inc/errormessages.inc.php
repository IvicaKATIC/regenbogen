<?php
// Gibt es Fehler?
if (count($errors) > 0) {
    // wenn ja werden sie Zeile für Zeile ausgegeben
    echo '<div class="error">';
    echo '<ul>';
    foreach ($errors as $error) {
        echo '<li>';
        echo $error;
        echo '</li>';
    }
    echo '</ul>';
    echo '</div>';
}
