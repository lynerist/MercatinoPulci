<script src="js/jquery-3.5.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/bootstrap.bundle.js"></script>
<script src="js/funzioniAjax.js"></script>
<script src="js/controlloInput.js"></script>
<script src="js/functions.js"></script>
<?php
if (!isset($_SESSION["codiceFiscale"])) {
    echo((isset($_GET['dberr']) and ($_GET['dberr'] == 'pwd' or $_GET['dberr'] == 'eml')) ? '<script>accediRegistrati(\'tabAccedi\')</script>' : '');
    echo((isset($_GET['dberr']) and ($_GET['dberr'] == 'CfE' or $_GET['dberr'] == 'Cf' or $_GET['dberr'] == 'E')) ? '<script>accediRegistrati(\'tabRegistrati\')</script>' : '');
}
?>
<script>
    //ricerca
    window.addEventListener('DOMContentLoaded', function () {
        popolaRegioni('navRegione', 'navProvincia', null, '<?php echo isset($_GET["regione"])?mysqli_real_escape_string($cid, $_GET["regione"]):"";?>', '<?php echo isset($_GET["provincia"])?mysqli_real_escape_string($cid, $_GET["provincia"]):"";?>', null, true)
    });
    document.getElementById('navRegione').addEventListener('change', function () {
        popolaProvince('navRegione', 'navProvincia', null, true)
    });
    //registrazione
    window.addEventListener('DOMContentLoaded', function () {
        popolaRegioni('register-regione', 'register-provincia', 'register-comune', '<?php echo (isset($_GET["rg"])?$_GET["rg"]:"");?>', '<?php echo (isset($_GET["pr"])?$_GET["pr"]:"");?>', '<?php echo (isset($_GET["cm"])?$_GET["cm"]:"");?>', false)
    });
    document.getElementById('register-regione').addEventListener('change', function () {
        popolaProvince('register-regione', 'register-provincia', 'register-comune')
    });
    document.getElementById('register-provincia').addEventListener('change', function () {
        popolaComuni('register-provincia', 'register-comune')
    });
</script>