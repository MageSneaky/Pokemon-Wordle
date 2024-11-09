document.addEventListener('DOMContentLoaded', () =>
    setTimeout(() => {
        $('#loading').fadeOut(500)
            .promise().done(function () {
                document.getElementById("loading").remove();
            });
    }, 500));