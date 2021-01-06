<?php
function urlCriptato($cf, $dop): string{
    $cf = base64_encode($cf);
    $dop = base64_encode($dop);
    if ($dop == "") {
        return "profile.php?cf=" . $cf;
    } else {
        return "annuncio.php?dop=" . $dop . "&v=" . $cf;
    }
}
