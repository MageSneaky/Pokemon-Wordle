<?php
require __DIR__ . "/discord.php";
if (isset($_GET['code'])) {
    init($redirect_url, $client_id, $client_secret, $bot_token);

    get_user();

    $mysqli = new mysqli($mysql_host, $mysql_user, $mysql_pass, $mysql_db);

    if (mysqli_connect_errno()) {
        header('Location: https://pokemon.sneaky.pink/logout');
        exit;
    }

    if ($stmt = $mysqli->prepare('INSERT INTO users (user_id, username, user_avatar) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE username = ?, user_avatar = ?')) {
        $user_id = $_SESSION['user_id'];
        $username = $_SESSION['global_name'];
        $user_avatar = $_SESSION['user_avatar'];
        $stmt->bind_param('sssss', $user_id, $username, $user_avatar, $username, $user_avatar);
        $stmt->execute();
        $stmt->close();
    } else {
        header('Location: https://pokemon.sneaky.pink/logout');
        exit;
    }

    mysqli_close($mysqli);

    if (isset($_GET['goto'])) {
        header('Location: ' . $_GET['goto']);
        exit;
    } else {
        header('Location: https://pokemon.sneaky.pink');
        exit;
    }
}

if (isset($_SESSION['user_id'])) {
    header('Location: https://pokemon.sneaky.pink');
    exit;
}

$auth_url = url($client_id, $redirect_url, $scopes);
?>
<!DOCTYPE html>

<?php
$title = "Login | Pokemon Wordle";
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
        <div class="login">
            <a class="discord-login" href="<?php echo $auth_url; ?>"><img src="/images/discord.svg">Login with
                Discord</a>
            <p>Allows for leaderboard submissions</p>
        </div>
    </div>
    <?php include 'notifications.php'; ?>
    <?php include 'loading.php'; ?>
</body>

</html>