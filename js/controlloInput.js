function visualizza(id) {
    if ($('#' + id).val() === "nuovo"){
        $('#labelScadenzaGaranzia').show();
        $('#labelTempoUsura').hide();
    }else{
        $('#labelTempoUsura').show();
        $('#labelScadenzaGaranzia').hide();
    }
}

function apriNuovoAnnuncio() {
    window.open("/annuncio.html");
}

function controllaForm(id){
    for (let input of document.getElementsByClassName(id)){
        if (input.classList.contains("is-invalid")){
            return false
        }
    }
    return true
}

function colora(id, bool){
    let element = document.getElementById(id);
    if (bool) {
        element.classList.add("is-valid");
        element.classList.remove("is-invalid");
    }else{
        element.classList.add("is-invalid");
        element.classList.remove("is-valid");
    }
}

function controllaCodiceFiscale(codice){
    return /^(?:[A-Z][AEIOU][AEIOUX]|[B-DF-HJ-NP-TV-Z]{2}[A-Z]){2}(?:[\dLMNP-V]{2}(?:[A-EHLMPR-T](?:[04LQ][1-9MNP-V]|[15MR][\dLMNP-V]|[26NS][0-8LMNP-U])|[DHPS][37PT][0L]|[ACELMRT][37PT][01LM]|[AC-EHLMPR-T][26NS][9V])|(?:[02468LNQSU][048LQU]|[13579MPRTV][26NS])B[26NS][9V])(?:[A-MZ][1-9MNP-V][\dLMNP-V]{2}|[A-M][0L](?:[1-9MNP-V][\dLMNP-V]|[0L][1-9MNP-V]))[A-Z]$/.test(codice.toUpperCase());
}

function controllaEmail(email){
    return /\S+@\S+.\S+/.test(email);
}

function controllaPassword(password){
    return /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/.test(password);
}

function controllaRipetizionePassword(idpassword, ripetizione){
    return document.getElementById(idpassword).value === ripetizione;
}

function controllaTesto(testo){
    return testo !== "";
}

function controllaPrezzo(prezzo){
    return /^[1-9][0-9]{0,3}((.|,)[0-9]{1,2})?$/.test(prezzo)
}

function controllaTempoUsura(idTempoUsura, idStatoUsura){
    let tempoUsura = document.getElementById(idTempoUsura).value;
    if (document.getElementById(idStatoUsura).value !== 'nuovo'){
        return /^[1-9][0-9]{0,2}$/.test(tempoUsura)
    }
    return true
}

var countAreaVisibilita = 1;
function aggiungiAreaVisibilita(id){
    let nodo = '<div class="row"><div class="md-form md-outline container-fluid mt-0"><label><select name="regione" id="visibilita-regione_' + countAreaVisibilita + '" class="form-control"><option value="" disabled selected hidden>Regione</option><option value="Lombardia">Lombardia</option></select></label><label><select name="provincia" id="visibilita-provincia_' + countAreaVisibilita + '" class="form-control"><option value="" disabled selected hidden>Provincia</option><option value="Milano">Milano</option></select></label><label><select name="comune" id="visibilita-comune_' + countAreaVisibilita + '" class="form-control"><option value="" disabled selected hidden>Comune</option><option value="Milano">Milano</option></select></label></div></div>'
    document.getElementById("piu").previousElementSibling.outerHTML += nodo
    countAreaVisibilita++
}

function visualizzaAreaVisibilita(visibilita, idAreavisibilita){
    if (visibilita === 'ristretta'){
        document.getElementById(idAreavisibilita).style.display = 'block'
    }else{
        document.getElementById(idAreavisibilita).style.display = 'none'
    }
}