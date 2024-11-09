initGame();

function initGame() {
    let quessPokemonButton = document.getElementById("quessPokemon");
    let quessPokemonInput = document.getElementById("quessPokemonInput");
    quessPokemonButton.addEventListener("click", function (event) {
        guessPokemon();
    });
    $("#quessPokemonInput").keyup(function (e) {
        let code = e.keyCode || e.which;
        if (code === 13) {
            guessPokemon();
        }
        else {
            filterFunction(this);
        }
    });
    $("#quessPokemonInput").focus(function () {
        hideorshow(this, "focus");
    });
    $("#quessPokemonInput").focusout(function () {
        hideorshow(this, "focusout");
        filterFunction(this);
    });

    $("#pokemonDropdown").find("div").click(function (event) {
        document.getElementById("quessPokemonInput").value = $(this).text();
    });

    setTimeout(() => {
        $('#loading').fadeOut(500)
            .promise().done(function () {
                document.getElementById("loading").remove();
            });
    }, 500);

    function guessPokemon() {
        let format = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
        console.log(quessPokemonInput.value);
        let pokemonQuess = quessPokemonInput.value;
        if(pokemonQuess != null && !format.test(pokemonQuess)) {
            
        }
        else if(format.test(pokemonQuess)) {
            notification("", "No special characters allowed", true)
            return;
        }

        quessPokemonInput.value = "";
    }

    function filterFunction(element) {
        let input, filter, a, i;
        input = document.getElementById("quessPokemonInput");
        filter = input.value.toLowerCase();
        div = document.getElementById("pokemonDropdown");
        a = div.getElementsByTagName("div");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                a[i].style.display = "";
            } else {
                a[i].style.display = "none";
            }
        }
    } 

    function hideorshow(element, string) {
        if (string == "focus") {
            setTimeout(function () {
                document.getElementById("pokemonDropdown").classList.add("show");
            }, 100);
        }
        else if (string == "focusout") {
            setTimeout(function () {
                document.getElementById("pokemonDropdown").classList.remove("show");
            }, 100);
        }
    }
}