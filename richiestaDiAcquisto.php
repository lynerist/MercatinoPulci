<?php
require_once "common/session.php"
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <title>Richiesta di acquisto effettuata</title>
    <?php include_once "common/common_header.php" ?>
    <link rel="stylesheet" type="text/css" href="css/products.css">
    <link rel="stylesheet"  type="text/css" href="css/annuncio.css">
    <link rel="stylesheet"  type="text/css" href="css/profile.css">
</head>

<body>
<?php include_once "common/navbar.php" ?>

<div class="container drop-shadow mt-5 mb-5 text-center pt-2">
    <h1>Abbiamo inviato la tua richiesta d'acquisto!</h1>
    <img src="img/bee_thumbs_up.png" class="altezza-fissa mb-3 img-fluid" alt="">
</div>

<?php include_once "common/footer.php"; ?>
<?php include_once "common/common_script.php"; ?>

</body>
</html>