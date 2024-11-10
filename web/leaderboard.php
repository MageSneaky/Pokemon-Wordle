<!DOCTYPE html>

<?php
require __DIR__ . "/config.php";

$mysqli = new mysqli($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
$results_per_page = 15;
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}
$page_first_result = ($page - 1) * $results_per_page;

function getLeaderboard()
{
    global $mysqli, $page_first_result, $results_per_page;

    if ($stmt = $mysqli->prepare('SELECT * FROM games WHERE finished = 1 AND user_id IS NOT NULL ORDER BY guessesCount DESC LIMIT ?, ?')) {
        $stmt->bind_param('ii', $page_first_result, $results_per_page);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $i = 1;
        while ($row = $result->fetch_assoc()) {
            if (isset($row['user_id'])) {
                $user_id = $row['user_id'];
                if ($stmt = $mysqli->prepare('SELECT username, user_avatar FROM users WHERE user_id = ?')) {
                    $stmt->bind_param('s', $user_id);
                    $stmt->execute();
                    $stmt->bind_result($username, $user_avatar);
                    $stmt->fetch();
                    $stmt->close();
                }
                $pokemon = json_decode($row['pokemon']);
                $pokemonName = $pokemon->name;
                $pokemonImage = $pokemon->sprite;
                $date = new DateTime($row['startDate']);
                $date = $date->format('Y-m-d H:i:s');
                echo '
                <tr>
                    <td><span>' . $i . '</span></td><td><a href="/user/' . $user_id . '"><img src="' . $user_avatar . '">' . $username . '</a></td><td><span><img src="' . $pokemonImage . '">' . ucfirst($pokemonName) . '</span></td><td><span>' . $row['guessesCount'] . '</span></td><td><span>' . $date . '</span></td>
                </tr>';
                $i++;
            }
        }
    }
}

function getGamesCount() {
    global $mysqli;

    $getGamesStarted = $mysqli->query("SELECT * FROM games");
    $started = mysqli_num_rows($getGamesStarted);

    $getGamesFinished = $mysqli->query("SELECT * FROM games WHERE finished = 1");
    $finished = mysqli_num_rows($getGamesFinished);

    echo "Games started $started Games finished $finished";
}

$title = "Leaderboard | PokemonGame";
$description = "";
$logo = "/images/logo.png";
$url = "https://pokemon.sneaky.pink";
?>

<html lang="en">

<head>
    <title><?php echo $title ?></title>
    <meta name="description" content="<?php echo $description ?>">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:site" content="@magesneaky">
    <meta property="twitter:title" content="<?php echo $title ?>">
    <meta property="twitter:description" content="<?php echo $description ?>">
    <meta property="twitter:image" content="<?php echo $logo ?>">
    <meta property="og:title" content="<?php echo $title ?>">
    <meta property="og:site_name" content="<?php echo $title ?>">
    <meta property="og:description" content="<?php echo $description ?>">
    <meta property="og:type" content="website">
    <meta property="og:image" content="<?php echo $logo ?>">
    <meta property="og:url" content="<?php echo $url ?>">
    <meta name="author" content="MageSneaky">
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/png" href="<?php echo $logo ?>">
    <link rel="stylesheet" href="/style.css">
    <script src="/scripts/jquery.min.js"></script>
    <script src="/scripts/notifications.js"></script>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <img class="background" src="">
        <div class="leaderboard-container">
            <div class="leaderboard">
                <span><?php getGamesCount(); ?></span>
                <table>
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>User</td>
                            <td>Pokemon</td>
                            <td>Guesses</td>
                            <td>Date</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php getLeaderboard(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php include 'notifications.php'; ?>
    <?php include 'loading.php'; ?>
</body>

</html>