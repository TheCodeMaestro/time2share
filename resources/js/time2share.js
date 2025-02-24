window.openConfirmation = function(id) {
    document.getElementById(id).style.display = "flex";
}

window.closeConfirmation = function(id) {
    document.getElementById(id).style.display = "none";
}

window.openForm = function(id, productId) {
    document.getElementById("overlay").style.display = "flex";
    document.getElementById(id).style.display = "flex";

    if (id === "newReview" && productId) {
        document.getElementById("product_id").value = productId;
    }
}

window.closeForm = function(id) {
    document.getElementById("overlay").style.display = "none";
    document.getElementById(id).style.display = "none";
}