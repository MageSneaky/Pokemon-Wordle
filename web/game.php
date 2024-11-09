<!DOCTYPE html>

<?php
if (isset($_POST['startGame'])) {
    $mysqli = new mysqli("127.0.0.1", "user", "pass", "pokemonGame");

    if (mysqli_connect_errno()) {
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }

    if ($stmtposts = $mysqli->prepare('SELECT * FROM posts ORDER BY datetime DESC')) {
        $stmtposts->execute();
        $p = $stmtposts->get_result();
        $stmtposts->close();
        while ($row = $p->fetch_assoc()) {

        }
    }

    mysqli_close($con);
}

?>
<script src="/scripts/game.js"></script>
<div class="container">
    <div class="game">
        <input type="text">
    </div>
</div>