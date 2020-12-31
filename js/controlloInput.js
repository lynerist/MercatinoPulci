function apriNuovoAnnuncio() {
    window.open("/annuncio.html");
}

function controllaSubmit(id) {
    let myform = document.getElementById(id);

    myform.addEventListener('submit', function (event) {
        if (!controllaForm(id)){
            event.preventDefault();
            event.stopPropagation();
        }
    }, false);
}

function controllaForm(id){
    for (let input of document.getElementById(id).children){
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