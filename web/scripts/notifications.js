$(document).ready(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    if (urlParams.has("error")) {
        notification("", urlParams.get("error"), true)
    }
});

function notification(name, desc, error = false) {
    var item = document.createElement("div");
    item.onclick = () => {
        $(item).fadeOut(600, function () {
            $(this).remove();
        });
    };
    item.classList.add("item");
    if (error) {
        item.classList.add("error");
    }
    var title = document.createElement("h3");
    var description = document.createElement("p");
    title.innerText = name;
    description.innerText = desc;
    if (name) {
        item.appendChild(title);
    }
    item.appendChild(description);
    document.getElementById('notifications').appendChild(item);
    item.style.display = "none";
    $(item).fadeIn(600, () => {
        setTimeout(() => {
            $(item).fadeOut(600, function () {
                $(this).remove();
            });
        }, 5000);
    });
}