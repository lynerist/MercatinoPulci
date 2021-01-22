function osservaAnnuncioAjax(dop, v){
    let xttp = new AjaxRequest();
    xttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            let risposta = JSON.parse(this.response);

            if (risposta.errore){
                window.location.replace("erroreConnessione.php");
            }
        }
    };
    xttp.open("GET", "backend/osservaAnnuncio.php?dop=" + dop + "&v=" + v, true);
    xttp.send();
}