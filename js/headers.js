function closeMessageBox(event){
    let div = document.querySelector("#messageCard");
    div.classList.add("fade-out");
    setTimeout(function() {
        div.remove();
    }, 500);
}

function changeTheme(event){
    document.body.classList.toggle("white-theme");
    const label = document.getElementById("theme-label");
    const icon = document.querySelector(".changeTheme-icon");
    icon.classList.toggle("fa-sun");
    if (document.body.classList.contains("white-theme")) {
        label.textContent = "Light";
    } else {
        label.textContent = "Dark";
    }
}
