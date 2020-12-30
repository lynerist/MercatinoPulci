function apriNuovoAnnuncio() {
    window.open("/annuncio.html");
}

function prova(id) {
    let myform = $('#' + id);
    myform.addEventListener()
    myform.addEventListener('submit', function (event) {
        event.preventDefault();
        event.stopPropagation();
    }, false);
}


(function () {
    'use strict';
    window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');

        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                } else if (form.id === "nuovoAnnuncio") {
                    apriNuovoAnnuncio()
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
