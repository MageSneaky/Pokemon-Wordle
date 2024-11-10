<?php
$random_pokemon = "";
$pokemons = [];

if (isset($_POST['initGame'])) {
    $mysqli = new mysqli("127.0.0.1", "user", "pass", "pokemonGame");

    if (mysqli_connect_errno()) {
        ReturnJson("error", 'Failed to connect to MySQL: ' . mysqli_connect_error(), $mysqli);
    }

    if ($stmt = $mysqli->prepare('SELECT * FROM pokemons ORDER BY pokedex ASC')) {
        $stmt->execute();
        $p = $stmt->get_result();
        $stmt->close();
        while ($row = $p->fetch_assoc()) {
            $pokemon = array(
                "name" => $row['name'],
                "generation" => $row['generation'],
                "sprite" => $row['sprite'],
                "types" => $row['types'],
                "color" => $row['color'],
                "habitat" => $row['habitat'],
                "shape" => $row['shape']
            );
            $pokemon = json_encode($pokemon);
            array_push($pokemons, $pokemon);
        }
    } else {
        ReturnJson("error", "Could not prepare statement!", $stmt);
    }
    $random_pokemon = $pokemons[array_rand($pokemons)];

    if ($stmt = $mysqli->prepare('INSERT INTO games (gameid, pokemon) VALUES (?, ?)')) {
        $gameid = $_POST['initGame'];
        $stmt->bind_param('ss', $gameid, $random_pokemon);
        $stmt->execute();
        $stmt->close();
    } else {
        ReturnJson("error", "Could not prepare statement!", $stmt);
    }

    mysqli_close($mysqli);
} else if (isset($_POST['guessPokemon'], $_POST['gameid'])) {
    header('Content-Type: application/json');
    $mysqli = new mysqli("127.0.0.1", "user", "pass", "pokemonGame");

    if (mysqli_connect_errno()) {
        ReturnJson("error", 'Failed to connect to MySQL: ' . mysqli_connect_error(), $mysqli);
    }

    $pokemonName = $_POST['guessPokemon'];
    $gameid = $_POST['gameid'];

    $quessed_pokemon = [];

    if ($stmt = $mysqli->prepare('SELECT pokemon, guesses FROM games WHERE gameid = ?')) {
        $stmt->bind_param('s', $gameid);
        $stmt->execute();
        $stmt->bind_result($random_pokemon, $guesses);
        $stmt->fetch();
        $stmt->close();
    } else {
        ReturnJson("error", "Could not prepare statement!", $stmt);
    }

    if ($stmt = $mysqli->prepare('UPDATE games SET guesses = guesses + 1 WHERE gameid = ?')) {
        $stmt->bind_param('s', $gameid);
        $stmt->execute();
        $stmt->close();
    } else {
        ReturnJson("error", "Could not prepare statement!", $stmt);
    }

    if ($stmt = $mysqli->prepare('SELECT * FROM pokemons WHERE name = ?')) {
        $stmt->bind_param('s', $pokemonName);
        $stmt->execute();
        $p = $stmt->get_result();
        $stmt->close();
        while ($row = $p->fetch_assoc()) {
            $quessed_pokemon = array(
                "name" => $row['name'],
                "generation" => $row['generation'],
                "sprite" => $row['sprite'],
                "types" => $row['types'],
                "color" => $row['color'],
                "habitat" => $row['habitat'],
                "shape" => $row['shape']
            );
            $quessed_pokemon = json_encode($quessed_pokemon);
        }
    } else {
        ReturnJson("error", "Could not prepare statement!", $stmt);
    }

    mysqli_close($mysqli);

    $quessed_pokemon = json_decode($quessed_pokemon);
    $random_pokemon = json_decode($random_pokemon);

    $quessed_pokemon->types = json_decode($quessed_pokemon->types);
    $random_pokemon->types = json_decode($random_pokemon->types);

    $guesses++;

    $difference = [
        ["sprite" => $quessed_pokemon->sprite],
        ["name" => $quessed_pokemon->name, "value" => $quessed_pokemon->name == $random_pokemon->name],
        ["generation" => $quessed_pokemon->generation, "value" => $quessed_pokemon->generation == $random_pokemon->generation],
        ["type1" => $quessed_pokemon->types[0] ?? "undefined", "value" => ($quessed_pokemon->types[0] ?? "undefined") == ($random_pokemon->types[0] ?? "undefined")],
        ["type2" => $quessed_pokemon->types[1] ?? "undefined", "value" => ($quessed_pokemon->types[1] ?? "undefined") == ($random_pokemon->types[1] ?? "undefined")],
        ["color" => $quessed_pokemon->color, "value" => $quessed_pokemon->color == $random_pokemon->color],
        ["habitat" => $quessed_pokemon->habitat, "value" => $quessed_pokemon->habitat == $random_pokemon->habitat],
        ["shape" => $quessed_pokemon->shape, "value" => $quessed_pokemon->shape == $random_pokemon->shape],
        ["guesses" => $guesses],
    ];

    echo json_encode($difference);
    exit;
}

function Hints()
{
    if (isset($_POST['hints'])) {
        if ($_POST['hints'] == 1) {
            echo '<a id="hint">Get a hint</a>';
        }
    }
}

function ReturnJson($t, $s, $stmt = null)
{
    $array = [];

    $array[$t] = $s;
    echo json_encode($array);
    if (isset($stmt)) {
        $stmt->close();
    }
    exit;
}

function GetPokemons()
{
    global $pokemons;

    foreach ($pokemons as $i => $pokemon) {
        $pokemon = json_decode($pokemon);
        echo '<div><img src="' . $pokemon->sprite . '"><a data-name="' . $pokemon->name . '">' . ucfirst($pokemon->name) . '</a></div>';
    }
}

?>
<?php include 'header.php'; ?>
<div class="container">
    <div class="game">
        <nav>
            <a href="https://pokemon.sneaky.pink">Go back</a>
            <?php Hints(); ?>
            <a class="restartGame" title="Restart game with same settings?">Restart Game</a>
        </nav>
        <h1>Guess the Pokemon</h1>
        <div>
            <div>
                <input type="text" id="quessPokemonInput">
                <button id="quessPokemon">?</button>
                <div id="pokemonDropdown" class="dropdown-content">
                    <?php GetPokemons(); ?>
                </div>
            </div>
            <table id="guessedPokemon">
                <thead>
                    <tr>
                        <td>Image</td>
                        <td>Name</td>
                        <td>Generation</td>
                        <td>Type 1</td>
                        <td>Type 2</td>
                        <td>Color</td>
                        <td>Habitat</td>
                        <td>Shape</td>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    <div class="win-overlay" id="winOverlay">
        <div class="popup-box">
            <button class="close-btn" onclick="closeWinPopup()">✖</button>
            <h1>Congrats!</h1>
            <img id="pokemonImage" src="" alt="">
            <h3 id="pokemonName"></h3>
            <p id="guessesText"></p>
            <nav>
                <a class="restartGame" title="Restart game with same settings?">Play Again</a>
                <a href="/leaderboard">Leaderboard</a>
            </nav>
        </div>
    </div>
</div>
<?php include 'notifications.php'; ?>
<?php include 'loading.php'; ?>