<?php
if (isset($_GET['code'])) {
    require __DIR__ . "/discord.php";

    init($redirect_url, $client_id, $secret_id, $bot_token);

    get_user();

    if (isset($_GET['goto'])) {
        header('Location: ' . $_GET['goto']);
    } else {
        header('Location: https://pokemon.sneaky.pink');
    }
}

if(isset($_SESSION['user_id'])) {
    header('Location: https://pokemon.sneaky.pink');
}
?>
<!DOCTYPE html>

<?php
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
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="login">

        </div>
    </div>
    <?php include 'notifications.php'; ?>
    <?php include 'loading.php'; ?>
</body>

</html>