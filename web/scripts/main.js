function generateRandomString(length = 5) {
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

function init() {
    const startGameForm = document.querySelector("#pokemonGame");
    $('input[type="checkbox"]').change(function () {
        this.value = (Number(this.checked));
    });
    startGameForm.onsubmit = (event) => {
        event.preventDefault();
        var formData = new FormData(startGameForm);
        $.ajax({
            url: "/game",
            type: 'post',
            data: {
                'startGame': formData.get('startGame'),
                'hints': formData.get('hintsCheckBox'),
            },
            success: function (response) {
                if (response != null) {
                    $(document.body).html(response);
                }
                else {
                    notification("", response.error, true)
                }
            }
        });
    };
}