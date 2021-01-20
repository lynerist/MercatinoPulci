function aggiornaOsservati() {
    let xttp = new AjaxRequest();
    xttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            let risposta = JSON.parse(this.response);

            if (risposta.errore){
                window.location.replace("erroreConnessione.php");
            }

            let osservati = risposta.html;
            let container = document.getElementById('containerOsservati');
            container.innerHTML = osservati;
        }
    };
    setTimeout(aggiornaOsservati, 30000);
    xttp.open("GET", "backend/getOsservati.php", true);
    xttp.send();
}
