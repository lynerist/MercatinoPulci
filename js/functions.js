function rimuovi(me, other) {
    document.getElementById(me).style.display = "none";
    document.getElementById(other).style.display = "block";
}

function accediRegistrati(id) {
    $("#modalLoginRegister").modal("show");
    $("#" + id).click();
}
