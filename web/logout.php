<?php
session_start();
session_unset();
session_destroy();
if(isset($_GET['goto'])) {
    header('Location: ' . $_GET['goto']);
}
else {
    header('Location: https://pokemon.sneaky.pink');
}