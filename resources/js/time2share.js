window.openConfirmation = function(id) {
    document.getElementById(id).style.display = "flex";
}

window.closeConfirmation = function(id) {
    document.getElementById(id).style.display = "none";
}

window.newProduct = function() {
    document.getElementById("overlay").style.display = "flex";
}

window.closeNewProduct = function() {
    document.getElementById("overlay").style.display = "none";
}