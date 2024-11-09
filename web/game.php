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

    if ($stmt = $mysqli->prepare('SELECT pokemon FROM games WHERE gameid = ?')) {

        $stmt->bind_param('s', $gameid);
        $stmt->execute();
        $stmt->bind_result($random_pokemon);
        $stmt->fetch();
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

    $difference = [];

    array_push($difference, array("sprite" => $quessed_pokemon->sprite));
    array_push($difference, array("name" => $quessed_pokemon->name == $random_pokemon->name));
    array_push($difference, array("generation" => $quessed_pokemon->generation == $random_pokemon->generation));
    array_push($difference, array("type1" => $quessed_pokemon->types[0] ?? null == $random_pokemon->types[0] ?? null));
    array_push($difference, array("type2" => $quessed_pokemon->types[1] ?? null == $random_pokemon->types[1] ?? null));
    array_push($difference, array("color" => $quessed_pokemon->color == $random_pokemon->color));
    array_push($difference, array("habitat" => $quessed_pokemon->habitat == $random_pokemon->habitat));
    array_push($difference, array("shape" => $quessed_pokemon->shape == $random_pokemon->shape));

    echo json_encode($difference);
    exit;
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
<div class="container">
    <div class="game">
        <nav>
            <a href="https://pokemon.sneaky.pink">Go back</a>
            <a id="restartGame">Restart Game</a>
        </nav>
        <h1>Guess the Pokemon</h1>
        <div>
            <div>
                <input type="text" id="quessPokemonInput">
                <button id="quessPokemon">?</button>
            </div>
            <div id="pokemonDropdown" class="dropdown-content">
                <?php GetPokemons(); ?>
            </div>
            <table id="guessedPokemon">
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
            </table>
        </div>
    </div>
</div>
<?php include 'notifications.php'; ?>
<?php include 'loading.php'; ?>