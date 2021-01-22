<script src="js/jquery-3.5.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/bootstrap.bundle.js"></script>
<script src="js/navbar.js"></script>
<script src="js/controlloInput.js"></script>
<script src="js/functions.js"></script>
<?php echo ((isset($_GET['dberr']) and ($_GET['dberr'] == 'pwd' or $_GET['dberr'] == 'eml'))?'<script>accediRegistrati(\'tabAccedi\')</script>':'');?>
