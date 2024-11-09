initGame();

function initGame() {
    let quessPokemonButton = document.getElementById("quessPokemon");
    let quessPokemonInput = document.getElementById("quessPokemonInput");
    quessPokemonButton.addEventListener("click", function (event) {
        guessPokemon();
    });
    quessPokemonInput.addEventListener("keypress", function (event) {
        if (event.key === 'Enter') {
            guessPokemon();
        }
    });

    function guessPokemon() {
        let format = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
        console.log(quessPokemonInput.value);
        let pokemonQuess = quessPokemonInput.value;
        if(pokemonQuess != null && !format.test(pokemonQuess)) {
            console.log("ok");
        }
        else if(format.test(pokemonQuess)) {
            notification("", "No special characters allowed", true)
            return;
        }
        
        quessPokemonInput.value = "";
    }
}