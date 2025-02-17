window.openConfirmation = function(id) {
    document.getElementById(id).style.display = "flex";
}

window.closeConfirmation = function(id) {
    document.getElementById(id).style.display = "none";
}

window.newProduct = function(id) {
    document.getElementById("overlay").style.display = "flex";
    document.getElementById(id).style.display = "flex";
}

window.closeNewProduct = function(id) {
    document.getElementById("overlay").style.display = "none";
    document.getElementById(id).style.display = "none";
}