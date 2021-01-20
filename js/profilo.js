function popolaAnnunciAcquistati(cf) {
    let xttp = new AjaxRequest();
    xttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            let risposta = JSON.parse(this.response);

            if (risposta.errore){
                window.location.replace("erroreConnessione.php");
            }

            let annunci = risposta.html;
            let contenutoTab = document.getElementById('annunciAcquistati');
            contenutoTab.innerHTML = annunci;
        }
    };
    xttp.open("GET", "backend/getAnnunciAcquistati.php?cf=" + cf, true);
    xttp.send();
}

function popolaAnnunciVenduti(cf) {
    let xttp = new AjaxRequest();
    xttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            let risposta = JSON.parse(this.response);

            if (risposta.errore){
                window.location.replace("erroreConnessione.php");
            }

            let annunci = risposta.html;
            let contenutoTab = document.getElementById('annunciVenduti');
            contenutoTab.innerHTML = annunci;
        }
    };
    xttp.open("GET", "backend/getAnnunciVenduti.php?cf=" + cf, true);
    xttp.send();
}