function init() {
    SetRanked();
    initGame();
    $('input[type="checkbox"]').change(function () {
        this.value = this.checked ? true : false;
    });

    $('#hintsCheckBox').change(function () {
        SetRanked();
    });

    $('.generation-checkbox>input[type="checkbox"]').change(function () {
        this.checked ? $(this).parent().addClass("checked") : $(this).parent().removeClass("checked");
        SetRanked();
    });
}

function SetRanked() {
    ranked = true;

    $('.generation-checkbox>input[type="checkbox"]').each(function () {
        if(!this.checked) {
            ranked = false;
        }
    });

    if($('#hintsCheckBox').prop('checked')) ranked = false;

    if(user_avatar == "") ranked = false;

    if (ranked) {
        $('#startButton').attr("value", "Play Ranked");
    }
    else {
        $('#startButton').attr("value", "Play Unranked");
    }
}