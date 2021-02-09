function accediRegistrati(id) {
    $("#modalLoginRegister").modal("show");
    $("#" + id).click();
}

function AjaxRequest() {
    let request;
    try {
        request = new XMLHttpRequest()
    } catch (e1) {
        try {
            request = new ActiveXObject("Msxml2.XMLHTTP")
        } catch (e2) {
            try {
                request = new ActiveXObject("Microsoft.XMLHTTP")
            } catch (e3) {
                request = false
            }
        }
    }
    return request
}

function popolaRegioni(id, idP, idC, regioneSelezionata, provinciaSelezionata, comuneSelezionato, opzionale) {
    let xttp = new AjaxRequest();
    xttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            let risposta = JSON.parse(this.response);

            if (risposta.errore){
                window.location.replace("erroreConnessione.php");
            }

            let regioni = risposta.contenuto;
            let select = document.getElementById(id);
            if (select === null) return

            if (opzionale){
                select.innerHTML = "<option value=\"Tutta Italia\">Tutta Italia</option>";
            }
            for (let i = 0; i < regioni.length; i++) {
                let regione = document.createElement('option');
                regione.setAttribute("value", regioni[i]);
                regione.selected = (regione.value === regioneSelezionata);
                regione.innerText = regioni[i];
                select.appendChild(regione);
            }
            popolaProvince(id, idP, idC, opzionale, provinciaSelezionata, comuneSelezionato)
        }
    };
    xttp.open("GET", "common/getRegioni.php", true);
    xttp.send();
}

function popolaProvince(idR, idP, idC, opzionale, provinciaSelezionata, comuneSelezionato) {
    let regioneSelect = document.getElementById(idR);
    let regioneSelezionata = regioneSelect.options[regioneSelect.selectedIndex].value;

    if (regioneSelezionata !== "") {
        let xttp = new AjaxRequest();
        xttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                let risposta = JSON.parse(this.response);

                if (risposta.errore){
                    window.location.replace("erroreConnessione.php");
                }

                let province = risposta.contenuto;
                let select = document.getElementById(idP);
                if (select === null) return

                select.innerHTML = "";
                if (opzionale){
                        select.innerHTML = "<option value=\"Ogni provincia\">Ogni provincia</option>";
                }
                for (let i = 0; i < province.length; i++) {
                    if (province[i].length > 22) continue;
                    let provincia = document.createElement('option');
                    provincia.setAttribute("value", province[i]);
                    provincia.innerText = province[i];
                    provincia.selected = (provincia.value === provinciaSelezionata);
                    select.appendChild(provincia);
                }
                popolaComuni(idP, idC, comuneSelezionato, opzionale);
            }
        };
        xttp.open("GET", "common/getProvince.php?regione=" + regioneSelezionata, true);
        xttp.send();
    }
}

function popolaComuni(idP, idC, comuneSelezionato, opzionale) {
    let provinciaSelect = document.getElementById(idP);
    let provinciaSelezionata = provinciaSelect.options[provinciaSelect.selectedIndex].value;

    if (provinciaSelezionata !== "") {
        let xttp = new AjaxRequest();
        xttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                let risposta = JSON.parse(this.response);

                if (risposta.errore){
                    window.location.replace("erroreConnessione.php");
                }

                let comuni = risposta.contenuto;
                let select = document.getElementById(idC);
                if (select === null) return

                select.innerHTML = "";
                if (opzionale){
                    select.innerHTML = "<option value=\"Ogni comune\">Ogni comune</option>";
                }
                for (let i = 0; i < comuni.length; i++) {
                    if (comuni[i] === "Ogni comune") continue;
                    let comune = document.createElement('option');
                    comune.setAttribute("value", comuni[i]);
                    comune.innerText = comuni[i];
                    comune.selected = (comune.value === comuneSelezionato);
                    select.appendChild(comune);
                }
            }
        };
        xttp.open("GET", "common/getComuni.php?provincia=" + provinciaSelezionata, true);
        xttp.send();
    }
}
