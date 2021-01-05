<?php
require_once "common/session.php";

?>
<!DOCTYPE html>
<html lang="it">

<head>
    <title>404 Not found</title>
    <?php include_once "common/common_header.php" ?>
    <link rel="stylesheet" type="text/css" href="css/products.css">
    <link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="css/owl.theme.default.css">
    <link rel="stylesheet" type="text/css" href="css/profile.css">
</head>

<body>
<?php include_once "common/navbar.php" ?>

<div class="container drop-shadow mt-5 mb-5 text-center pt-2">
    <h1>Ops, la pagina che stai cercando non esiste.</h1>
    <img src="img/404.png" class="altezza-fissa mb-3 img-fluid" alt="">
</div>


<?php include_once "common/footer.php"; ?>

<?php include_once "common/common_script.php"; ?>

</body>
</html>



