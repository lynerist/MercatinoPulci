function visualizza(id) {
    if ($('#' + id).val() === "nuovo"){
        $('#labelScadenzaGaranzia').show();
        $('#labelTempoUsura').hide();
    }else{
        $('#labelTempoUsura').show();
        $('#labelScadenzaGaranzia').hide();
    }
}