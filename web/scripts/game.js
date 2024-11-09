const gameid = generateRandomString();
function initGame() {
    const startGameForm = document.querySelector("#pokemonGame");
    startGameForm.onsubmit = (event) => {
        event.preventDefault();
        var formData = new FormData(startGameForm);
        $.ajax({
            url: "/game",
            type: 'post',
            data: {
                'initGame': gameid,
                'hints': formData.get('hints'),
            },
            success: function (response) {
                if (response != null) {
                    if(response.error != null) {
                        notification("", response.error, true)
                    }
                    else {
                        $(document.body).html(response);
                        startGame();
                    }
                }
                else {
                    notification("Request Failed", "Try again later", true)
                }
            }
        });
    };
}

function startGame() {
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
        filterFunction(this);
    });
    $("#quessPokemonInput").focusout(function () {
        hideorshow(this, "focusout");
    });

    $("#pokemonDropdown").find("div").click(function (event) {
        document.getElementById("quessPokemonInput").value = $(this).text();
    });

    setTimeout(() => {
        $('#loading').fadeOut(500)
            .promise().done(function () {
                document.getElementById("loading").remove();
            });
    }, 1500);

    function guessPokemon() {
        let format = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
        let pokemonQuess = quessPokemonInput.value;
        if(pokemonQuess != null && !format.test(pokemonQuess)) {
            $.ajax({
                url: "/game",
                type: 'post',
                data: {
                    'guessPokemon': pokemonQuess,
                    'gameid': gameid
                },
                success: function (response) {
                    if (response != null) {
                        if(response.error != null) {
                            notification("", response.error, true)
                        }
                        else {
                            let tr = document.createElement("tr");        
                            for (let i = 0; i < response.length; i++) {
                                let td = document.createElement("td");
                                if(i == 0) {
                                    td.innerHTML = `<img src="${response[i].sprite}">`;
                                }
                                else {
                                    td.innerText = capitalizeFirstLetter(response[i][Object.keys(response[i])[0]]);
                                    if(response[i][Object.keys(response[i])[1]]) {
                                        td.classList.add("correct");
                                    }
                                    else {
                                        td.classList.add("incorrect");
                                    }
                                }
                                $(tr).append(td);
                            }
                            $('#guessedPokemon>tbody').append(tr);

                            if(response[1].value) {
                                console.log("WIN");
                            }
                        }
                    }
                    else {
                        notification("Request Failed", "Try again later", true)
                    }
                }
            });
        }
        else {
            notification("", "No special characters allowed", true);
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

function capitalizeFirstLetter(val) {
    return String(val).charAt(0).toUpperCase() + String(val).slice(1);
}

function generateRandomString(length = 10) {
    const chars =
        "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!_";
    const repeatString = chars
        .repeat(Math.ceil(length / chars.length))
        .split("");

    for (let i = repeatString.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [repeatString[i], repeatString[j]] = [repeatString[j], repeatString[i]];
    }

    return repeatString.slice(0, length).join("");
}