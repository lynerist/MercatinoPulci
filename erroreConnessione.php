<?php
require_once "common/session.php";

?>
<!DOCTYPE html>
<html lang="it">

<head>
    <title>Errore di connessione</title>
    <?php include_once "common/common_header.php" ?>
    <link rel="stylesheet" type="text/css" href="css/products.css">
    <link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="css/owl.theme.default.css">
    <link rel="stylesheet" type="text/css" href="css/profile.css">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">
        <img src="img/bee.svg" class="icon-bee" alt="bee"><span>Be</span><span>e-Market</span></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
</nav>

<div class="container drop-shadow mt-5 mb-5 p-5 text-center pt-2">
    <img src="img/errore_connessione.png" class="altezza-fissa mb-3 img-fluid" alt="">
</div>


<?php include_once "common/footer.php"; ?>

<script src="js/jquery-3.5.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/bootstrap.bundle.js"></script>

</body>
</html>
