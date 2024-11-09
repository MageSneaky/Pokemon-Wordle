<?php
$random_pokemon = [];
$pokemons = [];

if (isset($_POST['startGame'])) {
    $mysqli = new mysqli("127.0.0.1", "user", "pass", "pokemonGame");

    if (mysqli_connect_errno()) {
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }

    if ($stmt = $mysqli->prepare('SELECT * FROM pokemons')) {
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
            array_push($pokemons, $pokemon);
        }
    }

    $random_pokemon = $pokemons[array_rand($pokemons)];

    mysqli_close($mysqli);
}

function GetPokemons() {
    global $pokemons;

    foreach ($pokemons as $i => $pokemon) {
        echo $pokemon->sprite;
        //echo '<div><img src="' . $pokemon->sprite . '"><a data-name="' . $pokemon->name . '">' . $pokemon->name . '</a></div>';
    }
}

?>
<script src="/scripts/game.js"></script>
<div class="container">
    <div class="game">
        <nav>
            <a href="https://pokemon.sneaky.pink">Go back</a>
            <a id="restartGame">Restart Game</a>
        </nav>
        <h1>Guess the Pokemon</h1>
        <div>
            <input type="text" id="quessPokemonInput">
            <div id="pokemonsDropdown" class="dropdown-content">
                <?php GetPokemons(); ?>
            </div>
            <button id="quessPokemon">?</button>
        </div>
    </div>
</div>
<?php include 'notifications.php'; ?>