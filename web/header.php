<?php
if (session_status() != 2) {
    session_start();
}

function loggedinheader()
{
    if (isset($_SESSION['user_avatar'])) {
        echo
            '<div class="dropdown">
                <button class="dropbtn"><img class="avatar" src="' . $_SESSION['user_avatar'] . '"/></button>
                <div class="dropdown-content">
                    <a href="/logout">logout</a>
                </div>
            </div>';
    } else {
        echo '<a href="/login">login</a>';
    }
}

function loggedinheadermobile()
{
    if (isset($_SESSION['user_avatar'])) {
        echo '<a href="/logout">Logout</a>';
    } else {
        echo '<div><a href="/login">login</a></div>';
    }
}
?>

<header>
    <nav>
        <div>
            <a class="logo" href="https://pokemon.sneaky.pink"><img src="/images/logo.png" alt="logo"></a>
        </div>
        <div>
            <a href="/leaderboard"><img src="/images/leaderboard.svg"></a>
            <?php loggedinheader(); ?>
        </div>
    </nav>
    <nav class="mobilenav">
        <div class="dropdown">
            <button class="dropbtn">menu</button>
            <div class="dropdown-content">
                <a href="https://pokemon.sneaky.pink">home</a>
                <a style="display: flex; padding: 0;" href="/leaderboard"><img src="/images/leaderboard.svg"></a>
                <?php loggedinheadermobile(); ?>
            </div>
        </div>
    </nav>
</header>