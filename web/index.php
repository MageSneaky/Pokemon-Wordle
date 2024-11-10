<!DOCTYPE html>

<?php
$hints = isset($_COOKIE["hints"]) ? (filter_var($_COOKIE["hints"], FILTER_VALIDATE_BOOLEAN) ? 'checked=""' : "") : "";

function GetGenerations()
{
    require __DIR__ . "/config.php";
    $mysqli = new mysqli($mysql_host, $mysql_user, $mysql_pass, $mysql_db);

    if ($stmt = $mysqli->prepare('SELECT DISTINCT generation FROM pokemons ORDER BY pokedex ASC')) {
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $i = 1;
        while ($row = $result->fetch_assoc()) {
            if (isset($row['generation'])) {
                $gen = $row['generation'];
                $checkedClass = isset($_COOKIE["gen" . $i]) ? (filter_var($_COOKIE["gen" . $i], FILTER_VALIDATE_BOOLEAN) ? " checked" : "") : " checked";
                $checked = isset($_COOKIE["gen" . $i]) ? (filter_var($_COOKIE["gen" . $i], FILTER_VALIDATE_BOOLEAN) ? 'checked=""' : "") : 'checked=""';
                echo '<div class="generation">
                            <label for="gen' . $i .'" class="generation-checkbox' . $checkedClass . '" title="Include pokemon from generation ' . $i .'">
                                <input type="checkbox" id="gen' . $i .'" name="gen' . $i .'" value="true" ' . $checked . '>
                                <label for="gen' . $i .'">' . $gen .'</label>
                            </label>
                        </div>';
                $i++;
            }
        }
    }
}

$title = "PokemonGame";
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
    <script type="text/javascript">
    let user_avatar='<?php echo (isset($_SESSION['user_avatar']))?$_SESSION['user_avatar']:null; ?>';
    </script>
    <script src="/scripts/main.js"></script>
    <script src="/scripts/game.js"></script>
</head>

<body onload="init()">
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="settings">
            <h1 class="title">Pokemon Game</h1>
            <form id="pokemonGame">
                <div class="check-Box">
                    <label for="hintsCheckBox" title="Allow hints? (score to submitted to leaderboard)">Allow
                        hints?</label>
                    <div class="check-Box">
                        <input type="checkbox" id="hintsCheckBox" <?php echo $hints ?>
                            name="hints" value="false" title="Allow hints? (score to submitted to leaderboard)">
                    </div>
                </div>
                <div class="generations">
                    <p>Generations</p>
                    <div>
                        <?php GetGenerations(); ?>
                    </div>
                </div>
                <input type="submit" id="startButton" value="Play Ranked" name="startGame">
                <span>Made by <a href="https://sneaky.pink" target="_blank">MageSneaky</a></span>
            </form>
        </div>
    </div>
    <?php include 'notifications.php'; ?>
    <?php include 'loading.php'; ?>
</body>

</html>