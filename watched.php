<?php require_once "common/session.php";?>
<!DOCTYPE html>
<html lang="it">
<head>
    <title>Annunci osservati</title>
    <?php include_once "common/common_header.php" ?>
    <link rel="stylesheet" type="text/css" href="css/products.css">
    <link rel="stylesheet" type="text/css" href="css/profile.css">
    <link rel="stylesheet" type="text/css" href="css/watched.css">
</head>
<body>
<?php include_once "common/navbar.php" ?>

<h1 class="title-watched container">Annunci osservati</h1>

<div id="containerOsservati" class="container pb-5 mt-n2 mt-md-n3 drop-shadow altezza-minima"></div>

<?php include_once "common/footer.php" ?>

<?php include_once "common/common_script.php"; ?>
<script>aggiornaOsservati()</script>

</body>
</html>
