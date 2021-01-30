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

function popolaRegioni(id, idP, idC, regioneSelezionata, provinciaSelezionata, comuneSelezionato) {
    let xttp = new AjaxRequest();
    xttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            let risposta = JSON.parse(this.response);

            if (risposta.errore){
                window.location.replace("erroreConnessione.php");
            }

            let regioni = risposta.contenuto;
            let select = document.getElementById(id);
            for (let i = 0; i < regioni.length; i++) {
                let regione = document.createElement('option');
                regione.setAttribute("value", regioni[i]);
                regione.selected = (regione.value === regioneSelezionata);
                regione.innerText = regioni[i];
                select.appendChild(regione);
            }
            popolaProvince(id, idP, idC, null, null, provinciaSelezionata, comuneSelezionato)
        }
    };
    xttp.open("GET", "common/getRegioni.php", true);
    xttp.send();
}

function popolaProvince(idR, idP, idC, opzionale, nonSvuotare, provinciaSelezionata, comuneSelezionato) {
    let regioneSelect = document.getElementById(idR);
    let regioneSelezionata = regioneSelect.options[regioneSelect.selectedIndex].value;

    if (regioneSelezionata !== 0) {
        let xttp = new AjaxRequest();
        xttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                let risposta = JSON.parse(this.response);

                if (risposta.errore){
                    window.location.replace("erroreConnessione.php");
                }

                let province = risposta.contenuto;
                let select = document.getElementById(idP);
                if (!nonSvuotare){
                    select.innerHTML = "";
                }

                if (opzionale && !nonSvuotare){
                        select.innerHTML = "<option value=\"Ogni provincia\">Ogni provincia</option>";
                }
                for (let i = 0; i < province.length; i++) {
                    let provincia = document.createElement('option');
                    provincia.setAttribute("value", province[i]);
                    provincia.innerText = province[i];
                    provincia.selected = (provincia.value === provinciaSelezionata);
                    select.appendChild(provincia);
                }
                popolaComuni(idP, idC, comuneSelezionato)
            }
        };
        xttp.open("GET", "common/getProvince.php?regione=" + regioneSelezionata, true);
        xttp.send();
    }
}

function popolaComuni(idP, idC, comuneSelezionato) {
    let provinciaSelect = document.getElementById(idP);
    let provinciaSelezionata = provinciaSelect.options[provinciaSelect.selectedIndex].value;

    if (provinciaSelezionata !== 0) {
        let xttp = new AjaxRequest();
        xttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                let risposta = JSON.parse(this.response);

                if (risposta.errore){
                    window.location.replace("erroreConnessione.php");
                }

                let comuni = risposta.contenuto;
                let select = document.getElementById(idC);
                select.innerHTML = "";
                for (let i = 0; i < comuni.length; i++) {
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

window.addEventListener('DOMContentLoaded', function () {
    popolaRegioni('navRegione')
});
document.getElementById('navRegione').addEventListener('change', function () {
    popolaProvince('navRegione', 'navProvincia', '', true)
});

window.addEventListener('DOMContentLoaded', function () {
    popolaRegioni('register-regione')
});
document.getElementById('register-regione').addEventListener('change', function () {
    popolaProvince('register-regione', 'register-provincia', 'register-comune')
});
document.getElementById('register-provincia').addEventListener('change', function () {
    popolaComuni('register-provincia', 'register-comune')
});