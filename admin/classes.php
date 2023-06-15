<?php include "includes/header.php"; ?>

<?php 

                    
                    if(isset($_GET ['source'])) {

                        $source = $_GET ['source'];
                    } else {
                        $source = ' ';
                    }

                    switch($source) {

                        case 'add_class';
                        include "includes/add_class.php";
                        break;

                        case 'edit_class_admin';
                        include "includes/edit_class_admin.php";
                        break;

                        default:
                        include "includes/all_classes.php";
                        break;
                    }
                    
                    ?>
<?php include "includes/footer.php" ?>