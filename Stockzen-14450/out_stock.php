<?php
session_start();
include "dbconfig.php";
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <title>StockZen</title>

        <?php include "rel.head.php"; ?>

    </head>
<body class="sb-nav-fixed">

        <?php include "rel.menutopo.php"; ?>

        <div id="layoutSidenav">
            
            <?php include "rel.menulateral.php"; ?>
        
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>

</body>