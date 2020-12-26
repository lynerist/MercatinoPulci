function visualizza(id) {
    let sel = document.getElementById(id);
    if (sel.value === "nuovo"){
        document.getElementById("labelScadenzaGaranzia").classList.remove('garanzia');
        document.getElementById("labelTempoUsura").classList.add('tempoUsura');
    }else{
        document.getElementById("labelTempoUsura").classList.remove('tempoUsura');
        document.getElementById("labelScadenzaGaranzia").classList.add('garanzia');
    }
}