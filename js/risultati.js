function logslider(position) {
    // position will be between 0 and 100
    var minp = 0;
    var maxp = 1000;

    // The result should be between 100 an 10000000
    var minv = Math.log(1);
    var maxv = Math.log(3000);

    // calculate adjustment factor
    var scale = (maxv-minv) / (maxp-minp);

    return Math.ceil(Math.exp(minv + scale*(position-minp)));
}

$(document).ready(function() {

    const $valueSpan = $('.valueSpan2');
    const $value = $('#customRange11');
    $valueSpan.html(logslider($value.val()));
    $value.on('input change', () => {

        $valueSpan.html(logslider($value.val()));
    });
});

function checked(id){
    let annuncio = document.getElementById(id);
    let leo = annuncio.childNodes;
    leo[1].style.display = "none";
    annuncio.lastElementChild.style.display = "inline"
    annuncio.style.pointerEvents = "none";
    annuncio.style.cursor = "default";
}

function header(link, pagina, maxPagina){
    pagina = controllaVaia(pagina, maxPagina);
    link += "pagina=" + pagina;
    window.open(link, "_self");
}
