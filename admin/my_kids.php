<?php include "includes/header.php"; ?>

<?php 

                    
                    if(isset($_GET ['source'])) {

                        $source = $_GET ['source'];
                    } else {
                        $source = ' ';
                    }

                    switch($source) {

                        case 'add_kid';
                        include "includes/add_kid.php";
                        break;

                        case 'edit_kid';
                        include "includes/edit_kid.php";
                        break;

                        default:
                        include "includes/all_kids.php";
                        break;
                    }
                    
                    ?>
<?php include "includes/footer.php" ?>