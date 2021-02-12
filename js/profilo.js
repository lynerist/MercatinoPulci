function popolaAnnunciAcquistati(cf, offset) {
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
    xttp.open("GET", "backend/getFromDB/getAnnunciAcquistati.php?cf=" + cf + "&offset=" + offset, true);
    xttp.send();
}

function popolaAnnunciVenduti(cf, offset) {
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
    xttp.open("GET", "backend/getFromDB/getAnnunciVenduti.php?cf=" + cf + "&offset=" + offset, true);
    xttp.send();
}

function popolaAnnunciInVendita(cf, offset) {
    let xttp = new AjaxRequest();
    xttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            let risposta = JSON.parse(this.response);

            if (risposta.errore){
                window.location.replace("erroreConnessione.php");
            }

            let annunci = risposta.html;
            let contenutoTab = document.getElementById('annunciInVendita');
            contenutoTab.innerHTML = annunci;
        }
    };
    xttp.open("GET", "backend/getFromDB/getAnnunciInVendita.php?cf=" + cf + "&offset=" + offset, true);
    xttp.send();
}
