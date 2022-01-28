
<?php

session_start();

$_SESSION= ARRAY();

SESSION_DESTROY();

HEADER('location: index.php');
?>
