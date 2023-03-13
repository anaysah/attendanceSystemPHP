function closeMessageBox(event){
    let div = document.querySelector("#messageCard");
    div.classList.add("fade-out");
    setTimeout(function() {
        div.remove();
    }, 500);
}