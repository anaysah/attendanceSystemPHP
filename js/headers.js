function closeMessageBox(event) {
    let div = document.querySelector("#messageCard");
    div.classList.add("fade-out");
    setTimeout(function () {
        div.remove();
    }, 500);
}

document.addEventListener("DOMContentLoaded", function () {
    const cookies = document.cookie.split("; ");
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i].split("=");
        if (cookie[0] === "theme") {
            const themeValue = cookie[1];
            if (themeValue==="light"){
                changeTheme();
            }
        }
    }
});

function changeTheme() {
    document.body.classList.toggle("white-theme");
    const label = document.getElementById("theme-label");
    const icon = document.querySelector(".changeTheme-icon");
    icon.classList.toggle("fa-sun");
    if (document.body.classList.contains("white-theme")) {
        label.textContent = "Light";
        document.cookie = "theme=light; path=/";
    } else {
        label.textContent = "Dark";
        document.cookie = "theme=dark; path=/";
    }
}
